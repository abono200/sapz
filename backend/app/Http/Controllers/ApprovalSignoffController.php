<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDelegationRequest;
use App\Http\Requests\DigitalSignoffRequest;
use App\Http\Requests\RequestRevisionRequest;
use App\Models\ApprovalRequest;
use App\Services\ApprovalSignoffService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class ApprovalSignoffController extends Controller
{
    use ApiResponse;

    protected $signoffService;

    public function __construct(ApprovalSignoffService $signoffService)
    {
        $this->signoffService = $signoffService;
    }

    public function inbox()
    {
        $pending = $this->signoffService->getPendingInbox(Auth::id());
        return $this->paginatedResponse($pending, 'Pending approval inbox retrieved.');
    }

    public function signoff(DigitalSignoffRequest $request, string $id)
    {
        $approval = ApprovalRequest::find($id);
        if (!$approval) {
            return $this->errorResponse('Approval request not found.', 404);
        }

        $signoff = $this->signoffService->executeSignoff($approval, $request->comments ?? '');
        return $this->successResponse($signoff, 'Digital sign-off executed successfully.', 201);
    }

    public function requestRevision(RequestRevisionRequest $request, string $id)
    {
        $approval = ApprovalRequest::find($id);
        if (!$approval) {
            return $this->errorResponse('Approval request not found.', 404);
        }

        $revised = $this->signoffService->requestRevision($approval, $request->revision_notes);
        return $this->successResponse($revised, 'Approval returned for revision.');
    }

    public function createDelegation(CreateDelegationRequest $request)
    {
        $delegation = $this->signoffService->createDelegation($request->validated());
        return $this->successResponse($delegation, 'Approval proxy delegation created.', 201);
    }
}
