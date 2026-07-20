<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkflowRequest;
use App\Http\Requests\ProcessApprovalRequest;
use App\Http\Requests\SubmitApprovalRequest;
use App\Models\ApprovalRequest;
use App\Models\Workflow;
use App\Services\WorkflowService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    use ApiResponse;

    protected $workflowService;

    public function __construct(WorkflowService $workflowService)
    {
        $this->workflowService = $workflowService;
    }

    public function index()
    {
        $workflows = Workflow::with('steps')->get();
        return $this->successResponse($workflows, 'Workflow templates list retrieved.');
    }

    public function store(CreateWorkflowRequest $request)
    {
        $workflow = $this->workflowService->createWorkflow($request->validated());
        return $this->successResponse($workflow, 'Workflow template created successfully.', 201);
    }

    public function submitApproval(SubmitApprovalRequest $request)
    {
        $approval = $this->workflowService->submitApproval($request->validated());
        return $this->successResponse($approval, 'Approval request submitted successfully.', 201);
    }

    public function approve(ProcessApprovalRequest $request, string $id)
    {
        $approvalRequest = ApprovalRequest::with('currentStep')->find($id);
        if (!$approvalRequest) {
            return $this->errorResponse('Approval request not found.', 404);
        }

        $approved = $this->workflowService->approveStep($approvalRequest, $request->comments);
        return $this->successResponse($approved, 'Approval step processed successfully.');
    }

    public function reject(ProcessApprovalRequest $request, string $id)
    {
        $approvalRequest = ApprovalRequest::find($id);
        if (!$approvalRequest) {
            return $this->errorResponse('Approval request not found.', 404);
        }

        $rejected = $this->workflowService->rejectRequest($approvalRequest, $request->comments);
        return $this->successResponse($rejected, 'Approval request rejected.');
    }
}
