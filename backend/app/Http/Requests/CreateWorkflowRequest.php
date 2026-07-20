<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkflowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:30|unique:workflows,code',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'steps' => 'required|array|min:1',
            'steps.*.name' => 'required|string|max:100',
            'steps.*.step_order' => 'required|integer|min:1',
            'steps.*.approver_role_id' => 'nullable|uuid|exists:roles,id',
        ];
    }
}
