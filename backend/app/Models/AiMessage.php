<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AiMessage extends Model
{
    use HasUuids;

    protected $fillable = ['conversation_id', 'role', 'content', 'sources_json'];

    protected $casts = [
        'sources_json' => 'array',
    ];

    public function conversation()
    {
        return $this->belongsTo(AiConversation::class, 'conversation_id');
    }
}
