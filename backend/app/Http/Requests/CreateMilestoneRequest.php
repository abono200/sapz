<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMilestoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'target_date' => 'required|date',
            'status' => 'required|string|in:PENDING,IN_PROGRESS,ACHIEVED,DELAYED',
        ];
    }
}
