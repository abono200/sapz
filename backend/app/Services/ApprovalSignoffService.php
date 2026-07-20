<?php

namespace App\Services;

use App\Models\ApprovalDelegation;
use App\Models\ApprovalHistory;
use App\Models\ApprovalRequest;
use App\Models\ApprovalSignoff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalSignoffService
{
    public function getPendingInbox(string $userId)
    {
        return ApprovalRequest::with(['workflow', 'requester', 'currentStep'])
            ->where('status', 'PENDING_APPROVAL')
            ->paginate(15);
    }

    public function executeSignoff(ApprovalRequest $request, string $comments): ApprovalSignoff
    {
        return DB::transaction(function() use ($request, $comments) {
            $user = Auth::user();
            $sigData = "{$request->id}|{$user->id}|" . now()->timestamp;
            $signatureHash = hash('sha256', $sigData);

            $signoff = ApprovalSignoff::create([
                'approval_request_id' => $request->id,
                'step_id' => $request->current_step_id,
                'signoff_by' => $user->id,
                'signature_hash' => $signatureHash,
                'security_pin_verified' => true,
                'comments' => $comments,
            ]);

            // Advance workflow via service or history
            ApprovalHistory::create([
                'approval_request_id' => $request->id,
                'step_id' => $request->current_step_id,
                'approver_id' => $user->id,
                'action' => 'SIGNOFF_APPROVED',
                'comments' => $comments,
            ]);

            $request->update(['status' => 'APPROVED']);
            return $signoff;
        });
    }

    public function requestRevision(ApprovalRequest $request, string $notes): ApprovalRequest
    {
        ApprovalHistory::create([
            'approval_request_id' => $request->id,
            'step_id' => $request->current_step_id,
            'approver_id' => Auth::id(),
            'action' => 'REVISION_REQUESTED',
            'comments' => $notes,
        ]);

        $request->update(['status' => 'REVISION_REQUESTED']);
        return $request->fresh(['histories']);
    }

    public function createDelegation(array $data): ApprovalDelegation
    {
        $data['user_id'] = Auth::id();
        return ApprovalDelegation::create($data);
    }
}
