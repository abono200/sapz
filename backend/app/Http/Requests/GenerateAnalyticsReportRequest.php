<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateAnalyticsReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'report_type' => 'required|string|in:EXECUTIVE_SUMMARY,BUDGET_EXECUTION,AGRO_ZONE_METRICS,AUDIT_TRAIL',
            'title' => 'required|string|max:200',
            'export_format' => 'required|string|in:PDF,CSV,XLSX',
            'parameters' => 'nullable|array',
        ];
    }
}
