<?php

namespace App\Http\Controllers;

use App\Models\CatatanImunisasi;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatatanImunisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CatatanImunisasi::with('warga');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('jenis_vaksin', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('nakes', 'like', "%{$search}%")
                  ->orWhereHas('warga', function($wargaQuery) use ($search) {
                      $wargaQuery->where('nama', 'like', "%{$search}%")
                                 ->orWhere('nik', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Jenis Vaksin
        if ($request->filled('jenis_vaksin')) {
            $query->where('jenis_vaksin', 'like', "%{$request->jenis_vaksin}%");
        }

        // Filter by Lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', "%{$request->lokasi}%");
        }

        // Filter by Date Range
        if ($request->filled('tanggal_mulai')) {
            $query->where('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->where('tanggal', '<=', $request->tanggal_akhir);
        }

        // Filter by Kartu Scan
        if ($request->filled('kartu_scan')) {
            if ($request->kartu_scan === 'ada') {
                $query->whereNotNull('kartu_imunisasi_scan');
            } elseif ($request->kartu_scan === 'tidak_ada') {
                $query->whereNull('kartu_imunisasi_scan');
            }
        }

        // Filter by Nakes
        if ($request->filled('nakes')) {
            $query->where('nakes', 'like', "%{$request->nakes}%");
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'tanggal');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['tanggal', 'jenis_vaksin', 'lokasi', 'nakes', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $catatanImunisasi = $query->paginate(10)->withQueryString();
        
        // Get data for filters
        $jenisVaksinList = CatatanImunisasi::distinct()->pluck('jenis_vaksin')->filter();
        $lokasiList = CatatanImunisasi::distinct()->pluck('lokasi')->filter();
        $nakesList = CatatanImunisasi::distinct()->pluck('nakes')->filter();
        
        return view('catatan-imunisasi.index', compact('catatanImunisasi', 'jenisVaksinList', 'lokasiList', 'nakesList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $warga = Warga::all();
        return view('catatan-imunisasi.create', compact('warga'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:warga,warga_id',
            'jenis_vaksin' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'nakes' => 'required|string|max:255',
            'kartu_imunisasi_scan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('kartu_imunisasi_scan')) {
            $file = $request->file('kartu_imunisasi_scan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('catatan_imunisasi', $filename, 'public');
            $data['kartu_imunisasi_scan'] = $path;
        }

        CatatanImunisasi::create($data);

        return redirect()->route('catatan-imunisasi.index')
            ->with('success', 'Catatan Imunisasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CatatanImunisasi $catatanImunisasi)
    {
        $catatanImunisasi->load('warga');
        return view('catatan-imunisasi.show', compact('catatanImunisasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CatatanImunisasi $catatanImunisasi)
    {
        $warga = Warga::all();
        return view('catatan-imunisasi.edit', compact('catatanImunisasi', 'warga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CatatanImunisasi $catatanImunisasi)
    {
        $request->validate([
            'warga_id' => 'required|exists:warga,warga_id',
            'jenis_vaksin' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'nakes' => 'required|string|max:255',
            'kartu_imunisasi_scan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('kartu_imunisasi_scan')) {
            // Delete old file if exists
            if ($catatanImunisasi->kartu_imunisasi_scan) {
                Storage::disk('public')->delete($catatanImunisasi->kartu_imunisasi_scan);
            }

            $file = $request->file('kartu_imunisasi_scan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('catatan_imunisasi', $filename, 'public');
            $data['kartu_imunisasi_scan'] = $path;
        }

        $catatanImunisasi->update($data);

        return redirect()->route('catatan-imunisasi.index')
            ->with('success', 'Catatan Imunisasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CatatanImunisasi $catatanImunisasi)
    {
        // Delete file if exists
        if ($catatanImunisasi->kartu_imunisasi_scan) {
            Storage::disk('public')->delete($catatanImunisasi->kartu_imunisasi_scan);
        }

        $catatanImunisasi->delete();

        return redirect()->route('catatan-imunisasi.index')
            ->with('success', 'Catatan Imunisasi berhasil dihapus.');
    }
}