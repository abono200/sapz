<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:50|unique:projects,code',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'status' => 'required|string|in:DRAFT,PROPOSED,IN_REVIEW,ACTIVE,COMPLETED,ON_HOLD,CANCELLED',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'required|numeric|min:0',
            'executed_budget' => 'nullable|numeric|min:0',
            'zone_id' => 'nullable|uuid|exists:project_zones,id',
            'contractor_name' => 'nullable|string|max:150',
        ];
    }
}
