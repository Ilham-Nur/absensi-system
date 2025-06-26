<?php

namespace App\Http\Controllers;

use App\Exports\HistoryExport;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\Absensi;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class HistoryController extends Controller
{
    public function index()
    {
        return view('history.index');
    }

    public function getListHistory(Request $request)
    {
        $presensi = Presensi::with(['statusPresensi', 'user'])
            ->get()
            ->map(function ($item) {
                // Default badge
                $badgeClass = 'secondary';

                if ($item->statusPresensi?->id == 1) {
                    $badgeClass = 'success'; // Hijau
                } elseif ($item->statusPresensi?->id == 2) {
                    $badgeClass = 'danger'; // Merah
                }

                $typeLabel = $item->statusPresensi->name ?? '-';
                $typeBadge = '<span class="badge bg-' . $badgeClass . '">' . $typeLabel . '</span>';

                return [
                    'type' => $typeBadge,
                    'user' => $item->user->name ?? '-',
                    'date' => $item->checked_at?->format('H:i d F Y'),
                    'status' => 'Presensi',
                    'extra' => $item->location,
                ];
            });

        $absensi = Absensi::with('user')
            ->get()
            ->map(function ($item) {
                $badgeClass = 'secondary';

                if (in_array(strtolower($item->status_absensi), ['izin', 'sakit'])) {
                    $badgeClass = 'warning'; // Kuning
                }

                $typeBadge = '<span class="badge bg-' . $badgeClass . '">' . ucfirst($item->status_absensi) . '</span>';

                return [
                    'type' => $typeBadge,
                    'user' => $item->user->name ?? '-',
                    'date' => $item->start?->format('H:i d F Y'),
                    'status' => 'Absensi',
                    'extra' => $item->file_izin
                        ? '<a href="' . asset('storage/' . $item->file_izin) . '" target="_blank">Lihat File</a>'
                        : 'Tidak ada file',
                ];
            });

            // dd( $absensi);

        $history = $presensi->merge($absensi)->sortByDesc('date')->values();

        return DataTables::of($history)
            ->rawColumns(['type', 'extra'])
            ->make(true);
    }

    public function exportExcel()
    {
        $presensi = Presensi::with(['statusPresensi', 'user'])->get()->map(function ($item) {
            return [
                'user' => $item->user->name ?? '-',
                'type' => $item->statusPresensi->name ?? '-',
                'date' => Carbon::parse($item->checked_at)->translatedFormat('H:i d F Y'),
                'status' => 'Presensi',
            ];
        });

        $absensi = Absensi::with('user')->get()->map(function ($item) {
            return [
                'user' => $item->user->name ?? '-',
                'type' => $item->status_absensi ?? '-',
                'date' => Carbon::parse($item->start)->translatedFormat('H:i d F Y'),
                'status' => 'Absensi',
            ];
        });

        $data = $presensi->merge($absensi)->sortByDesc('date')->values();

        $now = now()->format('His_dmY');
        $filename = "data-history_{$now}.xlsx";

        return Excel::download(new HistoryExport($data), $filename);
    }

}
