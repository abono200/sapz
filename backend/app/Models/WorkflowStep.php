<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class WorkflowStep extends Model
{
    use HasUuids;

    protected $fillable = ['workflow_id', 'step_order', 'name', 'approver_role_id', 'approver_user_id'];

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }

    public function approverRole()
    {
        return $this->belongsTo(Role::class, 'approver_role_id');
    }
}
