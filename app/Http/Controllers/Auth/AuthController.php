<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Abilities are optional; include if you intend to gate routes by ability:
        $token = $user->createToken('api', ['todos:read', 'todos:write'])->plainTextToken;

        return response()->json([
            'message' => 'Registered',
            'token'   => $token,
            'type'    => 'Bearer',
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        $token = $user->createToken('api', ['todos:read', 'todos:write'])->plainTextToken;

        return response()->json([
            'message' => 'Logged in',
            'token'   => $token,
            'type'    => 'Bearer',
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function logout(Request $request): JsonResponse
    {
        // Revoke only the current token:
        $request->user()->currentAccessToken()?->delete();

        // Or revoke all tokens:
        // $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
