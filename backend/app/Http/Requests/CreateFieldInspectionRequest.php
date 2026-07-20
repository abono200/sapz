<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFieldInspectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => 'required|uuid|exists:projects,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'inspection_date' => 'required|date',
            'notes' => 'nullable|string|max:2000',
            'status' => 'required|string|in:COMPLETED,PENDING_REVIEW,FLAG_RAISED',
            'client_created_at' => 'nullable|date',
        ];
    }
}
