<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::all();
        return view('absensi.indexabsensi', compact('absensis'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'status' => 'required|string|in:Hadir,Tidak Hadir,Sakit,Izin',
        ]);

        Absensi::create($request->all());
        return response()->json(['success' => 'Data berhasil disimpan.']);
    }
    public function list(request $request)
    {

        if ($request->ajax()) {
            $data = Absensi::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" class="btn btn-danger btn-sm">Hapus</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    }
    public function edit($id)
    {
        $absensi = Absensi::findOrFail($id);
        return response()->json($absensi);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'status' => 'required|string|in:Hadir,Tidak Hadir,Sakit,Izin',
        ]);

        $absensi = Absensi::findOrFail($id);
        $absensi->update($request->all());
        return response()->json(['success' => 'Data berhasil diperbarui.']);
    }


    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();
        return response()->json(['success' => 'Data berhasil dihapus.']);

    }

}
