<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AnalyticsReport extends Model
{
    use HasUuids;

    protected $fillable = [
        'report_type', 'title', 'parameters_json',
        'output_path', 'export_format', 'generated_by', 'status'
    ];

    protected $casts = [
        'parameters_json' => 'array',
    ];

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
