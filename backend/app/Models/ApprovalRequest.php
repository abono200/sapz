<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApprovalRequest extends Model
{
    use HasUuids;

    protected $fillable = [
        'workflow_id', 'approvable_type', 'approvable_id',
        'requester_id', 'current_step_id', 'status'
    ];

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function currentStep()
    {
        return $this->belongsTo(WorkflowStep::class, 'current_step_id');
    }

    public function histories()
    {
        return $this->hasMany(ApprovalHistory::class);
    }
}
