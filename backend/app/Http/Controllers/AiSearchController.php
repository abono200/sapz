<?php

namespace App\Http\Controllers;

use App\Http\Requests\AiChatRequest;
use App\Http\Requests\SemanticSearchRequest;
use App\Models\AiConversation;
use App\Services\AiSearchService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class AiSearchController extends Controller
{
    use ApiResponse;

    protected $aiService;

    public function __construct(AiSearchService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function search(SemanticSearchRequest $request)
    {
        $results = $this->aiService->hybridSearch($request->input('query'));
        return $this->successResponse($results, 'Hybrid semantic search completed.');
    }

    public function chat(AiChatRequest $request)
    {
        $chatResponse = $this->aiService->chatWithAssistant(
            $request->prompt,
            $request->conversation_id
        );

        return $this->successResponse($chatResponse, 'AI assistant response generated.', 201);
    }

    public function conversations()
    {
        $conversations = AiConversation::with('messages')
            ->where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get();

        return $this->successResponse($conversations, 'AI conversation history retrieved.');
    }
}
