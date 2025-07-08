<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Models\Waktu;
use Yajra\DataTables\Facades\DataTables;

class WaktuController extends Controller
{
    public function index()
    {
        $waktus = Waktu::all();
        $statuses = Status::all();
        return view('waktu.index', compact('waktus', 'statuses'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Waktu::with('status')
                ->select(['id', 'status_id', 'starttime', 'endtime']);

            return DataTables::of($data)->make(true);
        }
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'status_id' => 'required|exists:status,id',
            'starttime' => 'required|',
            'endtime' => 'required|after:starttime',
        ]);

        try {
            // Simpan data ke tabel waktu
            Waktu::create([
                'status_id' => $request->status_id,
                'starttime' => $request->starttime . ':00',
                'endtime'   => $request->endtime . ':00',
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menyimpan waktu!',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $waktu = Waktu::findOrFail($id);
        return response()->json($waktu);
    }

    public function update(Request $request, $id)
    {

        // dd($request->all());
        $request->validate([
            'status_id' => 'required|exists:status,id',
            'starttime' => 'required',
            'endtime' => 'required|after:starttime',
        ]);

        try {
            $waktu = Waktu::findOrFail($id);
            $waktu->update([
                'status_id' => $request->status_id,
                'starttime' => $request->starttime . ':00',
                'endtime'   => $request->endtime . ':00',
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengupdate waktu'], 500);
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
