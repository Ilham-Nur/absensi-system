<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('absensi.indexabsensi');
    }

    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'status' => 'required|string|in:Hadir,Tidak Hadir,Sakit,Izin',
        ]);

        AbsensiController::create($request->all());

    }

}
