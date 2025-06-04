<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ScannerController extends Controller
{
    public function index()
    {
        return view('scanner.index');
    }

        public function scan(Request $request)
        {

            // dd($request->all());
            $qrCode = $request->input('result');
            $parts = explode('_', $qrCode);

            if (count($parts) < 3) {
                return response()->json(['message' => 'Format QR tidak valid.'], 422);
            }

            $uuid = $parts[0];
            $date = $parts[1];
            $time = $parts[2];

            // Gabungkan dan parsing tanggal + waktu
            $datetimeStr = str_replace('-', '/', $date) . ' ' . str_replace('-', ':', $time);
            $checkedAt = Carbon::createFromFormat('d/m/Y H:i', $datetimeStr);

            // Validasi waktu
            if (Carbon::now()->diffInMinutes($checkedAt, false) < -10) {
                return response()->json(['message' => 'QR sudah kedaluwarsa.'], 410);
            }

            // Cari user
            $user = User::where('uuid', $uuid)->first();
            if (!$user) {
                return response()->json(['message' => 'User tidak ditemukan.'], 404);
            }

            // Simpan presensi (status default: hadir = 1)
            Presensi::create([
                'uuid' => (string) \Str::uuid(),
                'user_id' => $user->id,
                'checked_at' => now(),
                'status_presensi_id' => 1,
                'location' => $request->input('location')
            ]);

            return response()->json(['message' => 'Presensi berhasil disimpan.']);
        }

}
