<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaAsset extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'disk', 'file_name', 'original_name', 'mime_type',
        'file_size', 'width', 'height', 'sha256_hash', 'url', 'uploaded_by'
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
