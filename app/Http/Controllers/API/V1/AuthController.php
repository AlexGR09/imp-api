<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\LoginRequest;
use App\Http\Requests\API\V1\RegisterRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        $user = User::create($request->validated());

        $user->assignRole('admin');

        $token = JWTAuth::fromUser($user);

        DB::commit();
        
        return response()->json([
            'status' => 'success',
            'message' => 'You have been registered successfully!',
            'data' => [
                'token' => $token,
            ],
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid email or password.',
                ], 422);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'not create token',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'token' => $token,
            ],
        ], 200);
        
    }

    public function logout()
    {
        JWTAuth::invalidate();

        return response()->json([
            'status' => 'success',
            'message' => 'You have been logged out successfully.',
        ], 205);
    }
}
