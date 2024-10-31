<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthController extends Controller
{
    // User registration
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
    
        $token = JWTAuth::fromUser($user);
    
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201); 
    }
    

    // User login
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
    
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
            $user = JWTAuth::user();
            return response()->json(['user' => $user, 'token' => $token], 200);
        } catch (JWTException $e) {
            \Log::error('JWT Exception: '.$e->getMessage());
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }
    


    // Get authenticated user
    public function getUser()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }
    
        return response()->json($user, 200); 
    }
    


    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    
        return response()->json(['message' => 'Successfully logged out'], 200);
    }    
}
