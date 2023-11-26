<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['role'] = 'pharmacist';

        if ($validatedData) {
            // Creating a user with validated data
            $user = User::create($validatedData);

            return response()->json([
                'data' => $user,
                'access_token' => $user->createToken('api_token')->plainTextToken,
            ]);
        }
    }

    public function login(LogRequest $request)
    {
        // Getting the validated data from the request
        $validatedData = $request->validated();
        // Getting the user data according to the phone_number
        $user = User::where('phone_number', $validatedData['phone_number'])->first();

        if ($user->role === 'pharmacist') {
            if (Auth::attempt($validatedData) && $user->role === 'pharmacist') {
                return response()->json([
                    'message' => 'Login successful',
                    'data' => $user,
                    'token' => $user->createToken('authToken')->plainTextToken,
                ], 200);
            } elseif (!Auth::attempt($validatedData)) {
                return response()->json([
                    'error' => 'Invalid phone number or password',
                ], 401);
            }
        }

        return response()->json([
            'message' => 'User not authorized',
        ], 401);
    }

    public function weblogin(LogRequest $request)
    {
        // Getting the validated data from the request
        $validatedData = $request->validated();
        // Getting the user data according to the phone_number
        $user = User::where('phone_number', $validatedData['phone_number'])->first();

        if ($user->role === 'warehouseowner') {
            if (Auth::attempt($validatedData) && $user->role === 'warehouseowner') {
                return response()->json([
                    'message' => 'Login successful',
                    'data' => $user,
                    'token' => $user->createToken('authToken')->plainTextToken,
                ], 200);
            } elseif (!Auth::attempt($validatedData)) {
                return response()->json([
                    'error' => 'Invalid phone number or password',
                ], 401);
            }
        }

        return response()->json([
            'message' => 'User not authorized',
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Logout successful',
        ]);
    }
}
