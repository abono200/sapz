<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProgrammeMilestone extends Model
{
    use HasUuids;

    protected $fillable = ['programme_id', 'title', 'description', 'target_date', 'status'];

    protected $casts = [
        'target_date' => 'date',
    ];

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }
}
