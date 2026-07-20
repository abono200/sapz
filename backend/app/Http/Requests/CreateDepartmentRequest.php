<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:20|unique:departments,code',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|uuid|exists:departments,id',
        ];
    }
}
