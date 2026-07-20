<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterApiClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_name' => 'required|string|max:150|unique:api_clients,client_name',
            'allowed_ip_range' => 'nullable|string|max:100',
            'rate_limit' => 'nullable|integer|min:100|max:10000',
        ];
    }
}
