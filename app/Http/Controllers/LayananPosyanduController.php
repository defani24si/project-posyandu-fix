<?php

namespace App\Http\Controllers;

use App\Models\LayananPosyandu;
use App\Models\JadwalPosyandu;
use App\Models\Posyandu;
use App\Models\Warga;
use Illuminate\Http\Request;

class LayananPosyanduController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LayananPosyandu::with(['jadwal.posyandu', 'warga']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('vitamin', 'like', "%{$search}%")
                  ->orWhere('konseling', 'like', "%{$search}%")
                  ->orWhereHas('warga', function($wargaQuery) use ($search) {
                      $wargaQuery->where('nama', 'like', "%{$search}%")
                                 ->orWhere('nik', 'like', "%{$search}%");
                  })
                  ->orWhereHas('jadwal.posyandu', function($posyanduQuery) use ($search) {
                      $posyanduQuery->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Posyandu
        if ($request->filled('posyandu_id')) {
            $query->whereHas('jadwal', function($jadwalQuery) use ($request) {
                $jadwalQuery->where('posyandu_id', $request->posyandu_id);
            });
        }

        // Filter by Date Range
        if ($request->filled('tanggal_mulai')) {
            $query->whereHas('jadwal', function($jadwalQuery) use ($request) {
                $jadwalQuery->where('tanggal', '>=', $request->tanggal_mulai);
            });
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereHas('jadwal', function($jadwalQuery) use ($request) {
                $jadwalQuery->where('tanggal', '<=', $request->tanggal_akhir);
            });
        }

        // Filter by Berat Range
        if ($request->filled('berat_min')) {
            $query->where('berat', '>=', $request->berat_min);
        }

        if ($request->filled('berat_max')) {
            $query->where('berat', '<=', $request->berat_max);
        }

        // Filter by Tinggi Range
        if ($request->filled('tinggi_min')) {
            $query->where('tinggi', '>=', $request->tinggi_min);
        }

        if ($request->filled('tinggi_max')) {
            $query->where('tinggi', '<=', $request->tinggi_max);
        }

        // Filter by Vitamin
        if ($request->filled('vitamin')) {
            if ($request->vitamin === 'ada') {
                $query->whereNotNull('vitamin')->where('vitamin', '!=', '');
            } elseif ($request->vitamin === 'tidak_ada') {
                $query->where(function($q) {
                    $q->whereNull('vitamin')->orWhere('vitamin', '');
                });
            }
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['berat', 'tinggi', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } elseif ($sortBy === 'tanggal') {
            $query->join('jadwal_posyandu', 'layanan_posyandu.jadwal_id', '=', 'jadwal_posyandu.jadwal_id')
                  ->orderBy('jadwal_posyandu.tanggal', $sortOrder)
                  ->select('layanan_posyandu.*');
        }

        $layananPosyandu = $query->paginate(10)->withQueryString();
        
        // Get data for filters
        $posyandu = Posyandu::all();
        $vitaminList = LayananPosyandu::whereNotNull('vitamin')
                                     ->where('vitamin', '!=', '')
                                     ->distinct()
                                     ->pluck('vitamin')
                                     ->filter();
        
        return view('layanan-posyandu.index', compact('layananPosyandu', 'posyandu', 'vitaminList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jadwal = JadwalPosyandu::with('posyandu')->get();
        $warga = Warga::all();
        return view('layanan-posyandu.create', compact('jadwal', 'warga'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_posyandu,jadwal_id',
            'warga_id' => 'required|exists:warga,warga_id',
            'berat' => 'nullable|numeric|min:0',
            'tinggi' => 'nullable|numeric|min:0',
            'vitamin' => 'nullable|string|max:255',
            'konseling' => 'nullable|string',
        ]);

        LayananPosyandu::create($request->all());

        return redirect()->route('layanan-posyandu.index')
            ->with('success', 'Layanan Posyandu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LayananPosyandu $layananPosyandu)
    {
        $layananPosyandu->load(['jadwal.posyandu', 'warga']);
        return view('layanan-posyandu.show', compact('layananPosyandu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LayananPosyandu $layananPosyandu)
    {
        $jadwal = JadwalPosyandu::with('posyandu')->get();
        $warga = Warga::all();
        return view('layanan-posyandu.edit', compact('layananPosyandu', 'jadwal', 'warga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LayananPosyandu $layananPosyandu)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_posyandu,jadwal_id',
            'warga_id' => 'required|exists:warga,warga_id',
            'berat' => 'nullable|numeric|min:0',
            'tinggi' => 'nullable|numeric|min:0',
            'vitamin' => 'nullable|string|max:255',
            'konseling' => 'nullable|string',
        ]);

        $layananPosyandu->update($request->all());

        return redirect()->route('layanan-posyandu.index')
            ->with('success', 'Layanan Posyandu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LayananPosyandu $layananPosyandu)
    {
        $layananPosyandu->delete();

        return redirect()->route('layanan-posyandu.index')
            ->with('success', 'Layanan Posyandu berhasil dihapus.');
    }
}