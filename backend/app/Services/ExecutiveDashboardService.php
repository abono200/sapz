<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ExecutiveDashboardService
{
    public function getExecutiveSummary(): array
    {
        $totalProjects = DB::table('projects')->whereNull('deleted_at')->count();
        $totalBudget = DB::table('projects')->whereNull('deleted_at')->sum('budget');
        $activeProjects = DB::table('projects')->whereNull('deleted_at')->where('status', 'ACTIVE')->count();
        $totalDocuments = DB::table('documents')->whereNull('deleted_at')->count();
        $totalUsers = DB::table('users')->whereNull('deleted_at')->where('is_active', true)->count();
        $totalDepartments = DB::table('departments')->whereNull('deleted_at')->count();

        return [
            'kpis' => [
                'total_projects' => $totalProjects,
                'active_projects' => $activeProjects,
                'total_budget_ngn' => (float) $totalBudget,
                'formatted_budget' => '₦' . number_format($totalBudget, 2),
                'total_documents' => $totalDocuments,
                'total_users' => $totalUsers,
                'total_departments' => $totalDepartments,
                'compliance_score' => 98.5, // Target NDPR & Audit score %
            ],
            'system_status' => 'OPERATIONAL',
        ];
    }

    public function getProgrammeHealth(): array
    {
        $byStatus = DB::table('projects')
            ->select('status', DB::raw('count(*) as count'), DB::raw('sum(budget) as total_budget'))
            ->whereNull('deleted_at')
            ->groupBy('status')
            ->get();

        return [
            'status_breakdown' => $byStatus,
            'risk_level' => 'LOW',
        ];
    }

    public function getDepartmentPerformance(): array
    {
        return DB::table('departments')
            ->leftJoin('users', 'departments.id', '=', 'users.department_id')
            ->select(
                'departments.id',
                'departments.code',
                'departments.name',
                DB::raw('count(users.id) as total_staff')
            )
            ->whereNull('departments.deleted_at')
            ->groupBy('departments.id', 'departments.code', 'departments.name')
            ->get()
            ->toArray();
    }

    public function getRecentActivity(int $limit = 10): array
    {
        return DB::table('audit_logs')
            ->leftJoin('users', 'audit_logs.user_id', '=', 'users.id')
            ->select(
                'audit_logs.id',
                'audit_logs.event',
                'audit_logs.auditable_type',
                'audit_logs.created_at',
                'users.first_name',
                'users.last_name',
                'users.email'
            )
            ->orderBy('audit_logs.created_at', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
