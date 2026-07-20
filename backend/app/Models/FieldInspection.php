<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class FieldInspection extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'project_id', 'inspector_id', 'latitude', 'longitude',
        'inspection_date', 'notes', 'status', 'client_created_at'
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'client_created_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
}
