<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waktu;
use Yajra\DataTables\Facades\DataTables;

class WaktuController extends Controller
{
    public function index()
    {

        $waktus = Waktu::all();
        return view('waktu.index', compact('waktus'));
    }
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Waktu::select(['id', 'waktu']);
            return DataTables::of($data)->make(true);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'waktu' => 'required|date_format:H:i',
        ]);

        try {
            Waktu::create([
                'waktu' => $request->waktu,
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan waktu!'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'waktu' => 'required|date_format:H:i',
        ]);

        try {
            $waktu = Waktu::findOrFail($id);
            $waktu->update([
                'waktu' => $request->waktu,
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui waktu!'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $waktu = Waktu::findOrFail($id);
            $waktu->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus waktu!'], 500);
        }
    }
}