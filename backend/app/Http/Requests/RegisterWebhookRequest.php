<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterWebhookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'target_url' => 'required|url|max:255',
            'event_type' => 'required|string|in:PROJECT_UPDATED,DOCUMENT_APPROVED,TASK_COMPLETED',
        ];
    }
}
