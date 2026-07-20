<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDepartmentRequest;
use App\Services\DepartmentService;
use App\Traits\ApiResponse;

class DepartmentController extends Controller
{
    use ApiResponse;

    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index()
    {
        $departments = $this->departmentService->getAllDepartments();
        return $this->successResponse($departments, 'Department list retrieved.');
    }

    public function store(CreateDepartmentRequest $request)
    {
        $dept = $this->departmentService->createDepartment($request->validated());
        return $this->successResponse($dept, 'Department created successfully.', 201);
    }
}
