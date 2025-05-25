<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'token' => $user->createToken('mobile-token')->plainTextToken,
                'user' => $user,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Token invalid or expired.'
            ], 401);
        }

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful'
        ], 200);
    }


  public function changePassword(Request $request)
    {
        // Dapatkan token dari request
        $token = $request->bearerToken();

        // Dapatkan token record dari database
        $tokenRecord = \Laravel\Sanctum\PersonalAccessToken::findToken(
            explode('|', $token)[1] ?? ''
        );

        if (!$tokenRecord) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token.'
            ], 401);
        }

        $user = User::find($tokenRecord->tokenable_id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Verifikasi password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.'
            ], 403);
        }

        // Update password
        $user->password = Hash::make($request->new_password);

        if ($user->must_change_password) {
            $user->must_change_password = false;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully.'
        ], 200);
    }


}

