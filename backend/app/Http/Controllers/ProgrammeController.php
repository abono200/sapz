<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMilestoneRequest;
use App\Http\Requests\CreateProgrammeRequest;
use App\Models\Programme;
use App\Services\ProgrammeService;
use App\Traits\ApiResponse;

class ProgrammeController extends Controller
{
    use ApiResponse;

    protected $programmeService;

    public function __construct(ProgrammeService $programmeService)
    {
        $this->programmeService = $programmeService;
    }

    public function index()
    {
        $programmes = $this->programmeService->getAllProgrammes();
        return $this->paginatedResponse($programmes, 'Programmes list retrieved.');
    }

    public function store(CreateProgrammeRequest $request)
    {
        $programme = $this->programmeService->createProgramme($request->validated());
        return $this->successResponse($programme, 'Programme created successfully.', 201);
    }

    public function show(string $id)
    {
        $programme = $this->programmeService->getProgrammeDetails($id);
        if (!$programme) {
            return $this->errorResponse('Programme not found.', 404);
        }
        return $this->successResponse($programme, 'Programme details retrieved.');
    }

    public function addMilestone(CreateMilestoneRequest $request, string $id)
    {
        $programme = Programme::find($id);
        if (!$programme) {
            return $this->errorResponse('Programme not found.', 404);
        }

        $milestone = $this->programmeService->addMilestone($programme, $request->validated());
        return $this->successResponse($milestone, 'Programme milestone added successfully.', 201);
    }
}
