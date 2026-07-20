<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CkrCategory extends Model
{
    use HasUuids;

    protected $fillable = ['slug', 'name', 'description'];

    public function articles()
    {
        return $this->hasMany(CkrArticle::class, 'category_id');
    }
}
