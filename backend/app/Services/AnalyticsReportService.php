<?php

namespace App\Services;

use App\Models\AnalyticsReport;
use App\Models\Project;
use App\Models\Programme;
use Illuminate\Support\Facades\Auth;

class AnalyticsReportService
{
    public function getKpiSummary(): array
    {
        $totalBudget = Project::sum('budget');
        $totalSpent = Project::sum('actual_expenditure');
        $executionRate = $totalBudget > 0 ? round(($totalSpent / $totalBudget) * 100, 2) : 0;

        return [
            'total_programmes' => Programme::count(),
            'total_projects' => Project::count(),
            'total_budget_allocated' => $totalBudget,
            'total_expenditure' => $totalSpent,
            'budget_execution_rate' => $executionRate,
            'active_agro_zones' => DB::table('project_zones')->where('status', 'ACTIVE')->count(),
        ];
    }

    public function getBudgetChartData(): array
    {
        return [
            'labels' => ['Q1', 'Q2', 'Q3', 'Q4'],
            'allocated' => [2500000, 5000000, 7500000, 10000000],
            'expenditure' => [2100000, 4800000, 6900000, 9200000],
        ];
    }

    public function generateReport(array $data): AnalyticsReport
    {
        $report = AnalyticsReport::create([
            'report_type' => $data['report_type'],
            'title' => $data['title'],
            'export_format' => $data['export_format'],
            'parameters_json' => $data['parameters'] ?? [],
            'generated_by' => Auth::id(),
            'status' => 'COMPLETED',
            'output_path' => 'reports/' . $data['report_type'] . '_' . time() . '.' . strtolower($data['export_format']),
        ]);

        return $report;
    }
}
