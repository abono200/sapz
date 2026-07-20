<?php

namespace App\Services;

use App\Models\AiConversation;
use App\Models\AiMessage;
use App\Models\Document;
use App\Models\DocumentChunk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AiSearchService
{
    public function hybridSearch(string $queryStr, int $limit = 10): array
    {
        // Full-Text + Semantic Vector Retrieval Mock
        $documents = Document::where('title', 'ILIKE', "%{$queryStr}%")
            ->orWhere('abstract', 'ILIKE', "%{$queryStr}%")
            ->limit($limit)
            ->get();

        $chunks = DocumentChunk::with('document')
            ->where('content_chunk', 'ILIKE', "%{$queryStr}%")
            ->limit($limit)
            ->get();

        return [
            'query' => $queryStr,
            'documents' => $documents,
            'chunks' => $chunks,
        ];
    }

    public function chatWithAssistant(string $promptText, ?string $conversationId = null): array
    {
        $user = Auth::user();

        if (!$conversationId) {
            $conversation = AiConversation::create([
                'user_id' => $user->id,
                'title' => Str::limit($promptText, 40),
            ]);
        } else {
            $conversation = AiConversation::findOrFail($conversationId);
        }

        // Save User Message
        AiMessage::create([
            'conversation_id' => $conversation->id,
            'role' => 'user',
            'content' => $promptText,
        ]);

        // Perform RAG Context Retrieval
        $contextResults = $this->hybridSearch($promptText, 3);
        $sources = [];
        $contextText = "";

        foreach ($contextResults['documents'] as $doc) {
            $sources[] = [
                'reference' => $doc->reference_number,
                'title' => $doc->title,
            ];
            $contextText .= "Document [{$doc->reference_number}]: {$doc->title}. ";
        }

        $responseContent = "Based on the SAPZ Enterprise Knowledge Base: {$contextText} The requested assignment details and guidelines align with approved technical manuals.";

        // Save Assistant Message with Citations
        $assistantMsg = AiMessage::create([
            'conversation_id' => $conversation->id,
            'role' => 'assistant',
            'content' => $responseContent,
            'sources_json' => $sources,
        ]);

        return [
            'conversation_id' => $conversation->id,
            'answer' => $responseContent,
            'sources' => $sources,
        ];
    }
}
