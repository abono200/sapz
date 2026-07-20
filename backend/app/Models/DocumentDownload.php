<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DocumentDownload extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = ['document_id', 'version_id', 'downloaded_by', 'ip_address', 'created_at'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
