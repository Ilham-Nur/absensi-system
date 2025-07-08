<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('absensi.index');
    }

    public function store(Request $request)
    {
        // Logic to store attendance data
        // Validate and save the data from the request
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'status' => 'required|string|in:Hadir,Tidak Hadir,Sakit,Izin',
        ]);

        // Save the data to the database
        AbsensiController::create($request->all());

    }


}
