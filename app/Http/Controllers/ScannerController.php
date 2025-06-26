<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\User;
use App\Models\Waktu;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

    class ScannerController extends Controller
    {
        public function index()
        {
            return view('scanner.index');
        }

    public function scan(Request $request)
    {
        $qrCode = $request->input('result');
        $parts = explode('_', $qrCode);

        if (count($parts) < 3) {
            return response()->json(['status' => 'error', 'message' => 'Format QR tidak valid.'], 422);
        }

        [$uuid, $date, $time] = $parts;

        try {
            $datetimeStr = str_replace('-', '/', $date) . ' ' . str_replace('-', ':', $time);
            $checkedAt = Carbon::createFromFormat('d/m/Y H:i', $datetimeStr);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Format waktu tidak valid.'], 422);
        }

        if (now()->diffInMinutes($checkedAt, false) < -10) {
            return response()->json(['status' => 'error', 'message' => 'QR sudah kedaluwarsa.'], 410);
        }

        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan.'], 404);
        }

        $lastPresensi = Presensi::where('user_id', $user->id)
            ->orderBy('checked_at', 'desc')
            ->first();

        if ($lastPresensi && $lastPresensi->checked_at->diffInMinutes(now()) < 30) {
            $remaining = 30 - $lastPresensi->checked_at->diffInMinutes(now());
            return response()->json([
                'status' => 'error',
                'message' => 'Sudah melakukan presensi. Silakan tunggu ' . $remaining . ' menit lagi.'
            ], 429);
        }

        // Cari status_presensi_id berdasarkan waktu
        $now = Carbon::now()->format('H:i:s');

        $status = Waktu::where('starttime', '<=', $now)
            ->where('endtime', '>=', $now)
            ->first();

        if (!$status) {
            return response()->json(['status' => 'error', 'message' => 'Waktu presensi tidak valid.'], 422);
        }

        Presensi::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $user->id,
            'checked_at' => now(),
            'status_presensi_id' => $status->status_id,
            'location' => $request->input('location')
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Presensi berhasil disimpan.'
        ]);
    }

}
