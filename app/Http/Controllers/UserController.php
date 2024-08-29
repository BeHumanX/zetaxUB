<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Assign default role as 'user'
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['user' => $user, 'token' => $token]);
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Email or Password is not matched'], 401);
        }

        $user = Auth::user();
        $customClaims = ['role' => $user->role, 'user' => ['id' => $user->id]];
        $token = JWTAuth::claims($customClaims)->fromUser($user);

        $response = response()->json(['token' => $token]);

        $response->withCookie(cookie('jwt', $token, 60, 'api/', null, false, true, 'Lax'));
        $response->withCookie(cookie('isAuthenticated', 'true', 60, null, null, false, true));

        return $response;
    }
}
