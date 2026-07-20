<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use ApiResponse;

    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'zone_id', 'search']);
        $projects = $this->projectService->getProjects($filters, $request->input('per_page', 15));
        return $this->paginatedResponse($projects, 'Project list retrieved.');
    }

    public function store(CreateProjectRequest $request)
    {
        $project = $this->projectService->createProject($request->validated());
        return $this->successResponse($project, 'Project created successfully.', 201);
    }

    public function show(string $id)
    {
        $project = Project::with(['creator', 'documents'])->find($id);
        if (!$project) {
            return $this->errorResponse('Project not found.', 404);
        }
        return $this->successResponse($project, 'Project details retrieved.');
    }

    public function update(UpdateProjectRequest $request, string $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return $this->errorResponse('Project not found.', 404);
        }

        $updatedProject = $this->projectService->updateProject($project, $request->validated());
        return $this->successResponse($updatedProject, 'Project details updated.');
    }

    public function destroy(string $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return $this->errorResponse('Project not found.', 404);
        }

        $this->projectService->deleteProject($project);
        return $this->successResponse(null, 'Project archived successfully.');
    }

    public function zones()
    {
        $zones = $this->projectService->getAgroZones();
        return $this->successResponse($zones, 'SAPZ Agro-Industrial Zones list retrieved.');
    }
}
