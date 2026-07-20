<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectZone;
use Illuminate\Support\Facades\Auth;

class ProjectService
{
    public function getProjects(array $filters = [], int $perPage = 15)
    {
        $query = Project::with(['creator', 'documents']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['zone_id'])) {
            $query->where('zone_id', $filters['zone_id']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('title', 'ILIKE', "%{$search}%")
                  ->orWhere('code', 'ILIKE', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function createProject(array $data): Project
    {
        $data['created_by'] = Auth::id();
        return Project::create($data);
    }

    public function updateProject(Project $project, array $data): Project
    {
        $project->update($data);
        return $project->fresh(['creator', 'documents']);
    }

    public function deleteProject(Project $project): bool
    {
        return $project->delete();
    }

    public function getAgroZones()
    {
        return ProjectZone::with('projects')->get();
    }
}
