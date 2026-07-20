<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'task_number' => 'required|string|max:30|unique:tasks,task_number',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'status' => 'required|string|in:TODO,IN_PROGRESS,IN_REVIEW,COMPLETED,BLOCKED',
            'priority' => 'required|string|in:LOW,MEDIUM,HIGH,CRITICAL',
            'project_id' => 'nullable|uuid|exists:projects,id',
            'assignee_id' => 'nullable|uuid|exists:users,id',
            'due_date' => 'nullable|date',
            'estimated_hours' => 'nullable|numeric|min:0',
        ];
    }
}
