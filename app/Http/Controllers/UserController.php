<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {

        $users = User::with('role')->get();

        $roles = Role::all();
        return view('user.indexuser', compact('users', 'roles'));
    }

    // Ganti method store() Anda dengan ini

    public function store(Request $request)
    {
        // Gunakan Validator::make() untuk kontrol penuh
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|string|unique:users',
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);


        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()], 422);
        }


        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id,
            ]);


            return response()->json([
                'status' => true,
                'message' => 'User berhasil ditambahkan!'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false, 
                'message' => 'Gagal menambahkan user!'
            ], 500);
        }
    }
    public function resetPassword($id)
    {
        try {
            $user = User::findOrFail($id);

            // Setel ulang password ke 'password' (atau sesuaikan sesuai kebutuhan)
            $user->update(['password' => bcrypt('password123')]);

            return response()->json(['success' => true, 'message' => 'Password berhasil direset.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mereset password!'], 500);
        }
    }

    public function edit($id)
    {
        try {
        $user = User::findOrFail($id);

        
        return response()->json([
            'status' => true,
            'data' => $user 
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        
        return response()->json([
            'status' => false,
            'message' => 'User not found.'
        ], 404); 
    }

    }

    public function update(Request $request, $id)
    {
$user = User::findOrFail($id);

    $validated = $request->validate([
        // TAMBAHKAN 'unique' dengan pengecualian ID saat ini
        'name' => 'required|string|max:255|unique:users,name,' . $id,
        'email' => 'required|email|unique:users,email,' . $id,
        'role_id' => 'required|exists:roles,id',
    ]);

    $user->update($validated);

    return response()->json([
        'status' => true,
        'message' => 'User berhasil diperbarui.'
    ]);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('role')->select(['id', 'name', 'email', 'role_id']);
            return DataTables::of($users)->make(true);
        }
    }
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'User berhasil dihapus!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus user!'], 500);
        }
    }
}
