<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApprovalSignoff extends Model
{
    use HasUuids;

    protected $fillable = [
        'approval_request_id', 'step_id', 'signoff_by',
        'signature_hash', 'security_pin_verified', 'comments'
    ];

    protected $casts = [
        'security_pin_verified' => 'boolean',
    ];

    public function approvalRequest()
    {
        return $this->belongsTo(ApprovalRequest::class);
    }

    public function signer()
    {
        return $this->belongsTo(User::class, 'signoff_by');
    }
}
