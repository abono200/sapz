<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProjectMilestone extends Model
{
    use HasUuids;

    protected $fillable = ['project_id', 'title', 'percentage_weight', 'status', 'due_date'];

    protected $casts = [
        'percentage_weight' => 'integer',
        'due_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
