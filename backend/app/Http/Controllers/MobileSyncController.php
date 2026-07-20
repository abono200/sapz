<?php

namespace App\Http\Controllers;

use App\Http\Requests\BatchMobileSyncRequest;
use App\Http\Requests\CreateFieldInspectionRequest;
use App\Models\FieldInspection;
use App\Models\MobileSyncSession;
use App\Services\MobileSyncService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobileSyncController extends Controller
{
    use ApiResponse;

    protected $syncService;

    public function __construct(MobileSyncService $syncService)
    {
        $this->syncService = $syncService;
    }

    public function batchSync(BatchMobileSyncRequest $request)
    {
        $session = $this->syncService->processBatchSync(
            $request->device_id,
            $request->input('inspections', [])
        );

        return $this->successResponse($session, 'Mobile offline batch sync completed successfully.', 201);
    }

    public function index(Request $request)
    {
        $query = FieldInspection::with(['project', 'inspector']);

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $inspections = $query->orderBy('inspection_date', 'desc')->paginate($request->input('per_page', 15));
        return $this->paginatedResponse($inspections, 'Field inspection list retrieved.');
    }

    public function store(CreateFieldInspectionRequest $request)
    {
        $inspection = $this->syncService->createInspection($request->validated());
        return $this->successResponse($inspection, 'Field inspection created successfully.', 201);
    }

    public function syncHistory()
    {
        $sessions = MobileSyncSession::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->successResponse($sessions, 'Mobile sync session history retrieved.');
    }
}
