<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateAnalyticsReportRequest;
use App\Models\AnalyticsReport;
use App\Services\AnalyticsReportService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AnalyticsReportController extends Controller
{
    use ApiResponse;

    protected $analyticsService;

    public function __construct(AnalyticsReportService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function kpiSummary()
    {
        $summary = $this->analyticsService->getKpiSummary();
        return $this->successResponse($summary, 'Executive KPI summary retrieved.');
    }

    public function budgetChart()
    {
        $chartData = $this->analyticsService->getBudgetChartData();
        return $this->successResponse($chartData, 'Budget vs actual spending chart data retrieved.');
    }

    public function index()
    {
        $reports = AnalyticsReport::with('generator')->orderBy('created_at', 'desc')->paginate(15);
        return $this->paginatedResponse($reports, 'Generated analytics reports list retrieved.');
    }

    public function generate(GenerateAnalyticsReportRequest $request)
    {
        $report = $this->analyticsService->generateReport($request->validated());
        return $this->successResponse($report, 'Analytics report generated successfully.', 201);
    }

    public function download(string $id)
    {
        $report = AnalyticsReport::find($id);
        if (!$report) {
            return $this->errorResponse('Report not found.', 404);
        }

        return $this->successResponse(['download_url' => "/storage/{$report->output_path}"], 'Report download URL generated.');
    }
}
