<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total user dengan role 2
        $totalUser = DB::table('users')
            ->where('role_id', 2)
            ->count();

        // Hitung presensi hari ini untuk user role 2
        $totalPresensi = DB::table('presensi')
            ->join('users', 'users.id', '=', 'presensi.user_id')
            ->whereDate('presensi.checked_at', today())
            ->where('users.role_id', 2)
            ->count();

        // Hitung sakit/izin hari ini untuk user role 2
        $totalSakitIzin = DB::table('absensi')
            ->join('users', 'users.id', '=', 'absensi.user_id')
            ->where('users.role_id', 2)
            ->whereIn('absensi.status_absensi', ['sakit', 'izin'])
            ->whereDate('absensi.start', '<=', today())
            ->whereDate('absensi.end', '>=', today())
            ->distinct('absensi.user_id')
            ->count('absensi.user_id');

        return view('dashboard.dashboardindex', [
            'totalUser'      => $totalUser,
            'totalPresensi'  => $totalPresensi,
            'totalSakitIzin' => $totalSakitIzin,
        ]);
    }


   public function getdataChart(Request $request)
    {
        try {
            $month = $request->validate([
                'month' => 'sometimes|date_format:Y-m'
            ])['month'] ?? now()->format('Y-m');

            // Set date range
            $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

            // Initialize dates array with all days in month
            $dates = collect();
            $currentDate = $startDate->copy();

            while ($currentDate->lte($endDate)) {
                $dates->push([
                    'tanggal' => $currentDate->toDateString(),
                    'total_terlambat' => 0,
                    'total_sakit_izin' => 0
                ]);
                $currentDate->addDay();
            }

            // Query for late arrivals (terlambat)
            $terlambatData = DB::table('presensi as p')
                ->join('users as u', 'u.id', '=', 'p.user_id')
                ->select(
                    DB::raw('DATE(p.checked_at) as tanggal'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereBetween('p.checked_at', [$startDate, $endDate])
                ->where('p.status_presensi_id', 2)
                ->where('u.role_id', 2)
                ->groupBy('tanggal')
                ->get()
                ->keyBy('tanggal');

            // Query for sick/leave (sakit/izin)
            $sakitIzinData = DB::table('absensi as a')
                ->join('users as u', 'u.id', '=', 'a.user_id')
                ->select(
                    DB::raw('DATE(a.start) as tanggal'),
                    DB::raw('COUNT(a.id) as total')
                )
                ->where('u.role_id', 2)
                ->whereIn('a.status_absensi', ['sakit', 'izin'])
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('a.start', [$startDate, $endDate])
                        ->orWhereBetween('a.end', [$startDate, $endDate])
                        ->orWhere(function ($q) use ($startDate, $endDate) {
                            $q->where('a.start', '<', $startDate)
                                ->where('a.end', '>', $endDate);
                        });
                })
                ->groupBy('tanggal')
                ->get()
                ->keyBy('tanggal');

            // Merge the data into the dates collection
            $result = $dates->map(function ($day) use ($terlambatData, $sakitIzinData) {
                $day['total_terlambat'] = $terlambatData->get($day['tanggal'])->total ?? 0;
                $day['total_sakit_izin'] = $sakitIzinData->get($day['tanggal'])->total ?? 0;
                return $day;
            });

            return response()->json([
                'chart' => $result->values()->all()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred',
                'message' => $e->getMessage()
            ], 500);
        }
    }





}
