<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Invalid email or password credentials.', 401);
        }

        if (!$user->is_active) {
            return $this->errorResponse('Account is deactivated. Contact Administrator.', 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->full_name,
                'email' => $user->email,
            ]
        ], 'Authentication successful.');
    }

    public function me()
    {
        $user = Auth::user();
        return $this->successResponse([
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'department' => $user->department ? $user->department->name : null,
        ], 'User profile details retrieved.');
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return $this->successResponse(null, 'User successfully logged out.');
    }
}
