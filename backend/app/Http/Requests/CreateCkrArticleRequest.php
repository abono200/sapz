<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCkrArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|uuid|exists:ckr_categories,id',
            'title' => 'required|string|max:250',
            'summary' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:150',
        ];
    }
}
