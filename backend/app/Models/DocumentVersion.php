<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DocumentVersion extends Model
{
    use HasUuids;

    protected $fillable = [
        'document_id', 'version_number', 'file_path',
        'file_size', 'mime_type', 'sha256_hash', 'uploaded_by'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
