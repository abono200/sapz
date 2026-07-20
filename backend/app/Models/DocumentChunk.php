<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DocumentChunk extends Model
{
    use HasUuids;

    protected $fillable = ['document_id', 'chunk_index', 'content_chunk', 'embedding_json'];

    protected $casts = [
        'embedding_json' => 'array',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
