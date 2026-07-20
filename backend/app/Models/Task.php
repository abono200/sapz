<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'task_number', 'title', 'description', 'status', 'priority',
        'project_id', 'assignee_id', 'reporter_id', 'due_date',
        'estimated_hours', 'logged_hours', 'parent_id'
    ];

    protected $casts = [
        'due_date' => 'date',
        'estimated_hours' => 'decimal:2',
        'logged_hours' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }

    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_id');
    }
}
