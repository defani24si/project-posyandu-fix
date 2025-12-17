<?php

namespace App\Http\Controllers;

use App\Models\JadwalPosyandu;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JadwalPosyanduController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalPosyandu::with('posyandu');

        if ($request->filled('posyandu_id')) {
            $query->where('posyandu_id', $request->posyandu_id);
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('tema', 'like', "%{$searchTerm}%")
                  ->orWhere('keterangan', 'like', "%{$searchTerm}%")
                  ->orWhereHas('posyandu', function($posyanduQuery) use ($searchTerm) {
                      $posyanduQuery->where('nama', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $jadwals = $query->paginate(10)->withQueryString();
        $posyandus = Posyandu::all();

        return view('jadwal_posyandu.index', compact('jadwals', 'posyandus'));
    }

    public function create()
    {
        $posyandus = Posyandu::all();
        return view('jadwal_posyandu.create', compact('posyandus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'tanggal'     => 'required|date',
            'tema'        => 'required|string',
            'keterangan'  => 'nullable|string',
            'poster_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle poster upload
        if ($request->hasFile('poster_kegiatan')) {
            $file = $request->file('poster_kegiatan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('jadwal_posyandu', $filename, 'public');
            $data['poster_kegiatan'] = $path;
        }

        JadwalPosyandu::create($data);

        return redirect()->route('jadwal_posyandu.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jadwalPosyandu = JadwalPosyandu::with('posyandu')->findOrFail($id);
        return view('jadwal_posyandu.show', compact('jadwalPosyandu'));
    }

    public function edit($id)
    {
        $jadwalPosyandu = JadwalPosyandu::findOrFail($id);
        $posyandus = Posyandu::all();

        return view('jadwal_posyandu.edit', compact('jadwalPosyandu', 'posyandus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'tanggal'     => 'required|date',
            'tema'        => 'required|string',
            'keterangan'  => 'nullable|string',
            'poster_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $jadwalPosyandu = JadwalPosyandu::findOrFail($id);
        $data = $request->all();

        // Handle poster upload
        if ($request->hasFile('poster_kegiatan')) {
            // Delete old poster if exists
            if ($jadwalPosyandu->poster_kegiatan) {
                Storage::disk('public')->delete($jadwalPosyandu->poster_kegiatan);
            }

            $file = $request->file('poster_kegiatan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('jadwal_posyandu', $filename, 'public');
            $data['poster_kegiatan'] = $path;
        }

        $jadwalPosyandu->update($data);

        return redirect()->route('jadwal_posyandu.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        $jadwalPosyandu = JadwalPosyandu::findOrFail($id);
        
        // Delete poster file if exists
        if ($jadwalPosyandu->poster_kegiatan) {
            Storage::disk('public')->delete($jadwalPosyandu->poster_kegiatan);
        }
        
        $jadwalPosyandu->delete();

        return redirect()->route('jadwal_posyandu.index')->with('success', 'Data berhasil dihapus.');
    }

    /**
     * Delete poster from jadwal posyandu
     */
    public function deletePoster($id)
    {
        $jadwalPosyandu = JadwalPosyandu::findOrFail($id);
        
        if ($jadwalPosyandu->poster_kegiatan) {
            Storage::disk('public')->delete($jadwalPosyandu->poster_kegiatan);
            $jadwalPosyandu->update(['poster_kegiatan' => null]);
        }

        return redirect()->back()->with('success', 'Poster berhasil dihapus.');
    }
}
