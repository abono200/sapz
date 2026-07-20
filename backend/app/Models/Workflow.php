<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Workflow extends Model
{
    use HasUuids;

    protected $fillable = ['code', 'name', 'description', 'status'];

    public function steps()
    {
        return $this->hasMany(WorkflowStep::class)->orderBy('step_order', 'asc');
    }
}
