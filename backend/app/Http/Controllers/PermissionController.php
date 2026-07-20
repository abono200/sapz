<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Traits\ApiResponse;

class PermissionController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $permissions = Permission::all();
        return $this->successResponse($permissions, 'Permissions catalogue retrieved.');
    }
}
