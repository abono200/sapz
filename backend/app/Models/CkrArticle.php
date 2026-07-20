<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class CkrArticle extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'category_id', 'slug', 'title', 'summary',
        'content', 'author_name', 'published_at',
        'view_count', 'download_count'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'view_count' => 'integer',
        'download_count' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(CkrCategory::class, 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(CkrTag::class, 'article_has_tags', 'article_id', 'tag_id');
    }
}
