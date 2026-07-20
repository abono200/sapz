<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadDocumentVersionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'version_number' => 'required|string|max:10',
            'file' => 'required|file|mimes:pdf,docx,xlsx,png,jpg|max:20480',
        ];
    }
}
