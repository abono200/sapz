<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationPreferencesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email_enabled' => 'required|boolean',
            'sms_enabled' => 'required|boolean',
            'in_app_enabled' => 'required|boolean',
        ];
    }
}
