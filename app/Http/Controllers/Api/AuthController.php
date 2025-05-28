<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_id' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        // if (is_null($user->device_id)) {
        //     $user->device_id = $request->device_id;
        //     $user->save();
        // } else {
        //     if ($user->device_id !== $request->device_id) {
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'Akun ini sudah login di perangkat lain'
        //         ], 403);
        //     }
        // }

        $tokenName = 'mobile-token-' . $request->device_id;
        $user->tokens()->where('name', $tokenName)->delete(); // Optional: hapus token lama

        $token = $user->createToken($tokenName)->plainTextToken;

       return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'user' => new UserResource($user),
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

