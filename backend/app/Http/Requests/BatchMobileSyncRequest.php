<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatchMobileSyncRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'device_id' => 'required|string|max:100',
            'inspections' => 'present|array',
            'inspections.*.project_id' => 'required|uuid|exists:projects,id',
            'inspections.*.inspection_date' => 'required|date',
            'inspections.*.status' => 'required|string',
        ];
    }
}
