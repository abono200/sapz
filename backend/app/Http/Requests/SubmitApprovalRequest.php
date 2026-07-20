<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitApprovalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'workflow_id' => 'required|uuid|exists:workflows,id',
            'approvable_type' => 'required|string',
            'approvable_id' => 'required|uuid',
        ];
    }
}
