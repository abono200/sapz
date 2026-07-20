<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'status' => 'sometimes|string|in:DRAFT,PROPOSED,IN_REVIEW,ACTIVE,COMPLETED,ON_HOLD,CANCELLED',
            'budget' => 'sometimes|numeric|min:0',
            'executed_budget' => 'sometimes|numeric|min:0',
            'zone_id' => 'nullable|uuid|exists:project_zones,id',
            'contractor_name' => 'nullable|string|max:150',
        ];
    }
}
