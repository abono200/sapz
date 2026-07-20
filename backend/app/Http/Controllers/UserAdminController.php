<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    use ApiResponse;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['department_id', 'is_active', 'search']);
        $users = $this->userService->getUsers($filters, $request->input('per_page', 15));
        return $this->paginatedResponse($users, 'User accounts retrieved.');
    }

    public function store(CreateUserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());
        return $this->successResponse($user, 'User account created successfully.', 201);
    }

    public function show(string $id)
    {
        $user = User::with('department')->find($id);
        if (!$user) {
            return $this->errorResponse('User account not found.', 404);
        }
        return $this->successResponse($user, 'User profile retrieved.');
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->errorResponse('User account not found.', 404);
        }
        $updatedUser = $this->userService->updateUser($user, $request->validated());
        return $this->successResponse($updatedUser, 'User account updated successfully.');
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->errorResponse('User account not found.', 404);
        }
        $this->userService->deleteUser($user);
        return $this->successResponse(null, 'User account deactivated.');
    }
}
