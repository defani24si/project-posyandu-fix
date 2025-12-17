<?php

namespace App\Http\Controllers;

use App\Models\KaderPosyandu;
use App\Models\Posyandu;
use App\Models\Warga;
use Illuminate\Http\Request;

class KaderPosyanduController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KaderPosyandu::with(['posyandu', 'warga']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('peran', 'like', "%{$search}%")
                  ->orWhereHas('warga', function($wargaQuery) use ($search) {
                      $wargaQuery->where('nama', 'like', "%{$search}%")
                                 ->orWhere('nik', 'like', "%{$search}%");
                  })
                  ->orWhereHas('posyandu', function($posyanduQuery) use ($search) {
                      $posyanduQuery->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Posyandu
        if ($request->filled('posyandu_id')) {
            $query->where('posyandu_id', $request->posyandu_id);
        }

        // Filter by Peran
        if ($request->filled('peran')) {
            $query->where('peran', 'like', "%{$request->peran}%");
        }

        // Filter by Status (Aktif/Tidak Aktif)
        if ($request->filled('status')) {
            if ($request->status === 'aktif') {
                $query->where(function($q) {
                    $q->whereNull('akhir_tugas')
                      ->orWhere('akhir_tugas', '>', now());
                });
            } elseif ($request->status === 'tidak_aktif') {
                $query->where('akhir_tugas', '<=', now());
            }
        }

        // Filter by Date Range
        if ($request->filled('tanggal_mulai')) {
            $query->where('mulai_tugas', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->where('mulai_tugas', '<=', $request->tanggal_akhir);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'mulai_tugas');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['mulai_tugas', 'akhir_tugas', 'peran', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $kaderPosyandu = $query->paginate(10)->withQueryString();
        
        // Get data for filters
        $posyandu = Posyandu::all();
        $peranList = KaderPosyandu::distinct()->pluck('peran')->filter();
        
        return view('kader-posyandu.index', compact('kaderPosyandu', 'posyandu', 'peranList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $posyandu = Posyandu::all();
        $warga = Warga::all();
        return view('kader-posyandu.create', compact('posyandu', 'warga'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'warga_id' => 'required|exists:warga,warga_id',
            'peran' => 'required|string|max:255',
            'mulai_tugas' => 'required|date',
            'akhir_tugas' => 'nullable|date|after:mulai_tugas',
        ]);

        KaderPosyandu::create($request->all());

        return redirect()->route('kader-posyandu.index')
            ->with('success', 'Kader Posyandu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KaderPosyandu $kaderPosyandu)
    {
        $kaderPosyandu->load(['posyandu', 'warga']);
        return view('kader-posyandu.show', compact('kaderPosyandu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KaderPosyandu $kaderPosyandu)
    {
        $posyandu = Posyandu::all();
        $warga = Warga::all();
        return view('kader-posyandu.edit', compact('kaderPosyandu', 'posyandu', 'warga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KaderPosyandu $kaderPosyandu)
    {
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'warga_id' => 'required|exists:warga,warga_id',
            'peran' => 'required|string|max:255',
            'mulai_tugas' => 'required|date',
            'akhir_tugas' => 'nullable|date|after:mulai_tugas',
        ]);

        $kaderPosyandu->update($request->all());

        return redirect()->route('kader-posyandu.index')
            ->with('success', 'Kader Posyandu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KaderPosyandu $kaderPosyandu)
    {
        $kaderPosyandu->delete();

        return redirect()->route('kader-posyandu.index')
            ->with('success', 'Kader Posyandu berhasil dihapus.');
    }
}