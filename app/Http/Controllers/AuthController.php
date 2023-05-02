<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function signup(SignUpRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::query()->create($data);

        $token = $user->createToken($request->userAgent())->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'user' => $user
        ]);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::query()->where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->userAgent())->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {

    }

    public function whoami(Request $request)
    {

    }


}
