<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Presensi;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
   public function show(Request $request, $id)
    {
        $presensi = Presensi::with(['statusPresensi'])
            ->where('user_id', $id)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => $item->statusPresensi->name ?? '-',
                    'date' => $item->checked_at?->format('H:i d F Y'),
                    'status' => 'Presensi',
                    'extra' => $item->location,
                ];
            });

        $absensi = Absensi::where('user_id', $id)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => ucfirst($item->status_absensi),
                    'date' => $item->start?->format('H:i d F Y'),
                    'status' => 'Absensi',
                    'extra' => $item->file_izin
                        ? asset('storage/' . $item->file_izin)
                        : 'Tidak ada file',
                ];
            });

        $history = $presensi->merge($absensi)
                            ->sortByDesc('date')
                            ->values();

        return response()->json([
            'data' => $history
        ]);
}

}
