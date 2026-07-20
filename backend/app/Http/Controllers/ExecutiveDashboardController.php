<?php

namespace App\Http\Controllers;

use App\Services\ExecutiveDashboardService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ExecutiveDashboardController extends Controller
{
    use ApiResponse;

    protected $executiveService;

    public function __construct(ExecutiveDashboardService $executiveService)
    {
        $this->executiveService = $executiveService;
    }

    public function summary()
    {
        $summary = $this->executiveService->getExecutiveSummary();
        return $this->successResponse($summary, 'Executive summary KPIs retrieved.');
    }

    public function programmes()
    {
        $health = $this->executiveService->getProgrammeHealth();
        return $this->successResponse($health, 'Programme health metrics retrieved.');
    }

    public function departments()
    {
        $depts = $this->executiveService->getDepartmentPerformance();
        return $this->successResponse($depts, 'Department performance metrics retrieved.');
    }

    public function activity(Request $request)
    {
        $limit = $request->input('limit', 10);
        $activity = $this->executiveService->getRecentActivity((int) $limit);
        return $this->successResponse($activity, 'Executive activity timeline retrieved.');
    }
}
