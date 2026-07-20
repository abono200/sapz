<?php

namespace App\Services;

use App\Models\CkrArticle;
use App\Models\CkrCategory;
use Illuminate\Support\Str;

class CkrPublicService
{
    public function getPublicArticles(array $filters = [], int $perPage = 15)
    {
        $query = CkrArticle::with(['category', 'tags'])->whereNotNull('published_at');

        if (!empty($filters['category_slug'])) {
            $query->whereHas('category', function($q) use ($filters) {
                $q->where('slug', $filters['category_slug']);
            });
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('title', 'ILIKE', "%{$search}%")
                  ->orWhere('summary', 'ILIKE', "%{$search}%");
            });
        }

        return $query->orderBy('published_at', 'desc')->paginate($perPage);
    }

    public function getArticleBySlug(string $slug): ?CkrArticle
    {
        $article = CkrArticle::with(['category', 'tags'])->where('slug', $slug)->first();
        if ($article) {
            $article->increment('view_count');
        }
        return $article;
    }

    public function generateCitation(CkrArticle $article, string $format = 'APA'): string
    {
        $year = $article->published_at ? $article->published_at->format('Y') : date('Y');

        return match (strtoupper($format)) {
            'MLA' => "{$article->author_name}. \"{$article->title}.\" SAPZ Central Knowledge Repository, {$year}.",
            'IEEE' => "{$article->author_name}, \"{$article->title},\" SAPZ Central Knowledge Repository, {$year}.",
            default => "{$article->author_name} ({$year}). {$article->title}. SAPZ Central Knowledge Repository. Retrieved from https://ckr.sapz.gov.ng/articles/{$article->slug}",
        };
    }

    public function createArticle(array $data): CkrArticle
    {
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
        $data['published_at'] = now();
        return CkrArticle::create($data);
    }
}
