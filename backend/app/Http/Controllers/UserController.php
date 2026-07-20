<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $users = User::with('department')->paginate(15);
        return $this->paginatedResponse($users, 'Users retrieved successfully.');
    }

    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return $this->successResponse($user, 'User created successfully.', 201);
    }

    public function show(string $id)
    {
        $user = User::with('department')->find($id);

        if (!$user) {
            return $this->errorResponse('User not found.', 404);
        }

        return $this->successResponse($user, 'User details retrieved.');
    }
}
