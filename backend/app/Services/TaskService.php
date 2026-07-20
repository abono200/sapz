<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function getTasks(array $filters = [], int $perPage = 15)
    {
        $query = Task::with(['assignee', 'project']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (!empty($filters['assignee_id'])) {
            $query->where('assignee_id', $filters['assignee_id']);
        }

        if (!empty($filters['project_id'])) {
            $query->where('project_id', $filters['project_id']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('title', 'ILIKE', "%{$search}%")
                  ->orWhere('task_number', 'ILIKE', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function createTask(array $data): Task
    {
        $data['reporter_id'] = Auth::id();
        return Task::create($data);
    }

    public function updateTask(Task $task, array $data): Task
    {
        $task->update($data);
        return $task->fresh(['assignee', 'project']);
    }

    public function deleteTask(Task $task): bool
    {
        return $task->delete();
    }

    public function addComment(Task $task, string $commentText): TaskComment
    {
        return $task->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $commentText,
        ]);
    }
}
