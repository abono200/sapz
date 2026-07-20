<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCkrArticleRequest;
use App\Models\CkrCategory;
use App\Services\CkrPublicService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CkrPublicController extends Controller
{
    use ApiResponse;

    protected $ckrService;

    public function __construct(CkrPublicService $ckrService)
    {
        $this->ckrService = $ckrService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['category_slug', 'search']);
        $articles = $this->ckrService->getPublicArticles($filters, $request->input('per_page', 15));
        return $this->paginatedResponse($articles, 'Public knowledge repository articles retrieved.');
    }

    public function show(string $slug)
    {
        $article = $this->ckrService->getArticleBySlug($slug);
        if (!$article) {
            return $this->errorResponse('Article not found.', 404);
        }
        return $this->successResponse($article, 'Article details retrieved.');
    }

    public function citation(Request $request, string $id)
    {
        $article = \App\Models\CkrArticle::find($id);
        if (!$article) {
            return $this->errorResponse('Article not found.', 404);
        }

        $format = $request->input('format', 'APA');
        $citation = $this->ckrService->generateCitation($article, $format);
        return $this->successResponse(['citation' => $citation, 'format' => $format], 'Citation generated successfully.');
    }

    public function categories()
    {
        $categories = CkrCategory::all();
        return $this->successResponse($categories, 'CKR public categories list retrieved.');
    }

    public function store(CreateCkrArticleRequest $request)
    {
        $article = $this->ckrService->createArticle($request->validated());
        return $this->successResponse($article, 'CKR article published successfully.', 201);
    }
}
