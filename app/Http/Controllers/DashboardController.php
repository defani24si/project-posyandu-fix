<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Warga;
use App\Models\Posyandu;
use App\Models\JadwalPosyandu;
use App\Models\KaderPosyandu;
use App\Models\LayananPosyandu;
use App\Models\CatatanImunisasi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get statistics
        $stats = [
            'total_warga' => Warga::count(),
            'total_posyandu' => Posyandu::count(),
            'total_kader' => KaderPosyandu::whereNull('akhir_tugas')->orWhere('akhir_tugas', '>', now())->count(),
            'total_layanan_bulan_ini' => LayananPosyandu::whereHas('jadwal', function($query) {
                $query->whereMonth('tanggal', now()->month)
                      ->whereYear('tanggal', now()->year);
            })->count(),
            'total_imunisasi_bulan_ini' => CatatanImunisasi::whereMonth('tanggal', now()->month)
                                                          ->whereYear('tanggal', now()->year)
                                                          ->count(),
            'jadwal_minggu_ini' => JadwalPosyandu::whereBetween('tanggal', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
        ];

        // Get recent activities
        $recent_layanan = LayananPosyandu::with(['warga', 'jadwal.posyandu'])
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();

        $recent_imunisasi = CatatanImunisasi::with('warga')
                                           ->orderBy('created_at', 'desc')
                                           ->limit(5)
                                           ->get();

        // Get chart data for layanan per month (last 6 months)
        $layanan_chart = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = LayananPosyandu::whereHas('jadwal', function($query) use ($date) {
                $query->whereMonth('tanggal', $date->month)
                      ->whereYear('tanggal', $date->year);
            })->count();
            
            $layanan_chart[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }

        // Get imunisasi chart data (last 6 months)
        $imunisasi_chart = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = CatatanImunisasi::whereMonth('tanggal', $date->month)
                                   ->whereYear('tanggal', $date->year)
                                   ->count();
            
            $imunisasi_chart[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }

        // Get gender distribution
        $gender_stats = Warga::select('jenis_kelamin', DB::raw('count(*) as total'))
                            ->groupBy('jenis_kelamin')
                            ->get();

        // Get upcoming schedules
        $upcoming_schedules = JadwalPosyandu::with('posyandu')
                                           ->where('tanggal', '>=', now())
                                           ->orderBy('tanggal', 'asc')
                                           ->limit(5)
                                           ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'recent_layanan', 
            'recent_imunisasi', 
            'layanan_chart', 
            'imunisasi_chart', 
            'gender_stats', 
            'upcoming_schedules'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
