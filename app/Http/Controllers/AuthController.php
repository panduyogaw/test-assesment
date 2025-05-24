<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

        if (!$user->status) {
            return response()->json(['error' => 'Account inactive'], 403);
        }

        try {
            $token = $user->createToken('auth_token')->plainTextToken;
            Log::info('Token created successfully', ['user_id' => $user->id, 'token' => $token]);

            return response()->json([
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create token', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to generate authentication token'], 500);
        }
    }
}
