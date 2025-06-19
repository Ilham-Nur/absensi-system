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

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        try {
            // Buat user baru menggunakan model
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),

                'role_id' => $request->role_id,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menambahkan user!'], 500);
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
        $user = User::findOrFail($id);
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
        ]);

    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
        ]);
        dd($request->all());

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $validated['role_id'];
        $user->save();

        return response()->json(['message' => 'User berhasil diperbarui.']);
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
