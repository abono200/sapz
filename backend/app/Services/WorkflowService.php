<?php

namespace App\Services;

use App\Models\ApprovalHistory;
use App\Models\ApprovalRequest;
use App\Models\Workflow;
use App\Models\WorkflowStep;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkflowService
{
    public function createWorkflow(array $data): Workflow
    {
        return DB::transaction(function() use ($data) {
            $workflow = Workflow::create([
                'code' => $data['code'],
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);

            foreach ($data['steps'] as $s) {
                $workflow->steps()->create([
                    'step_order' => $s['step_order'],
                    'name' => $s['name'],
                    'approver_role_id' => $s['approver_role_id'] ?? null,
                ]);
            }

            return $workflow->load('steps');
        });
    }

    public function submitApproval(array $data): ApprovalRequest
    {
        $workflow = Workflow::with('steps')->findOrFail($data['workflow_id']);
        $firstStep = $workflow->steps->first();

        return ApprovalRequest::create([
            'workflow_id' => $workflow->id,
            'approvable_type' => $data['approvable_type'],
            'approvable_id' => $data['approvable_id'],
            'requester_id' => Auth::id(),
            'current_step_id' => $firstStep ? $firstStep->id : null,
            'status' => 'PENDING_APPROVAL',
        ]);
    }

    public function approveStep(ApprovalRequest $request, ?string $comments = null): ApprovalRequest
    {
        return DB::transaction(function() use ($request, $comments) {
            $currentStep = $request->currentStep;

            // Log history
            ApprovalHistory::create([
                'approval_request_id' => $request->id,
                'step_id' => $currentStep ? $currentStep->id : null,
                'approver_id' => Auth::id(),
                'action' => 'APPROVED',
                'comments' => $comments,
            ]);

            // Find next step
            $nextStep = WorkflowStep::where('workflow_id', $request->workflow_id)
                ->where('step_order', '>', $currentStep ? $currentStep->step_order : 0)
                ->orderBy('step_order', 'asc')
                ->first();

            if ($nextStep) {
                $request->update(['current_step_id' => $nextStep->id]);
            } else {
                $request->update(['status' => 'APPROVED', 'current_step_id' => null]);
            }

            return $request->fresh(['currentStep', 'histories']);
        });
    }

    public function rejectRequest(ApprovalRequest $request, ?string $comments = null): ApprovalRequest
    {
        ApprovalHistory::create([
            'approval_request_id' => $request->id,
            'step_id' => $request->current_step_id,
            'approver_id' => Auth::id(),
            'action' => 'REJECTED',
            'comments' => $comments,
        ]);

        $request->update(['status' => 'REJECTED']);
        return $request->fresh(['histories']);
    }
}
