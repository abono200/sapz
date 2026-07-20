<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:200',
            'description' => 'nullable|string',
            'status' => 'sometimes|string|in:TODO,IN_PROGRESS,IN_REVIEW,COMPLETED,BLOCKED',
            'priority' => 'sometimes|string|in:LOW,MEDIUM,HIGH,CRITICAL',
            'assignee_id' => 'nullable|uuid|exists:users,id',
            'due_date' => 'nullable|date',
            'logged_hours' => 'sometimes|numeric|min:0',
        ];
    }
}
