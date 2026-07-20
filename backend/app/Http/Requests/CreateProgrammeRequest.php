<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProgrammeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:30|unique:programmes,code',
            'name' => 'required|string|max:200',
            'funder' => 'required|string|max:100',
            'total_allocation' => 'required|numeric|min:0',
            'status' => 'required|string|in:PLANNING,ACTIVE,COMPLETED,ON_HOLD',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'coordinator_id' => 'nullable|uuid|exists:users,id',
        ];
    }
}
