<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Programme extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'code', 'name', 'funder', 'total_allocation',
        'status', 'start_date', 'end_date', 'coordinator_id'
    ];

    protected $casts = [
        'total_allocation' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function milestones()
    {
        return $this->hasMany(ProgrammeMilestone::class);
    }
}
