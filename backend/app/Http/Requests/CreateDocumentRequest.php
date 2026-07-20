<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reference_number' => 'required|string|max:50|unique:documents,reference_number',
            'title' => 'required|string|max:200',
            'abstract' => 'nullable|string',
            'category' => 'required|string|in:POLICY,REPORT,PROPOSAL,TECHNICAL,CONTRACT',
            'security_classification' => 'required|string|in:PUBLIC,INTERNAL,RESTRICTED,CONFIDENTIAL',
            'project_id' => 'nullable|uuid|exists:projects,id',
            'file' => 'nullable|file|mimes:pdf,docx,xlsx,png,jpg|max:20480', // 20MB limit
        ];
    }
}
