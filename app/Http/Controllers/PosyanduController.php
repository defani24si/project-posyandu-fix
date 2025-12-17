<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PosyanduController extends Controller
{
     public function index(Request $request)
{
    $query = Posyandu::query();
    
    if ($request->filled('rt')) {
        $query->where('rt', $request->rt);
    }
    
    if ($request->filled('rw')) {
        $query->where('rw', $request->rw);
    }
    
    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->where(function($q) use ($searchTerm) {
            $q->where('nama', 'like', "%{$searchTerm}%")
              ->orWhere('alamat', 'like', "%{$searchTerm}%");
        });
    }
    
    $posyandus = $query->paginate(10)->withQueryString();
    
    return view('posyandu.index', compact('posyandus'));
}  

    public function create()
    {
        return view('posyandu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:100',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'kontak' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->only(['nama', 'alamat', 'rt', 'rw', 'kontak']);
        
        // Handle foto upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('posyandu_foto', $filename, 'public');
            $data['foto'] = 'posyandu_foto/' . $filename;
        }
        
        // Handle multiple file uploads
        if ($request->hasFile('files')) {
            $uploadedFiles = [];
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('posyandu_files', $filename, 'public');
                $uploadedFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => 'posyandu_files/' . $filename,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                ];
            }
            $data['files'] = json_encode($uploadedFiles);
        } else {
            $data['files'] = null;
        }
        
        Posyandu::create($data);

        return redirect()->route('posyandu.index')
            ->with('success', 'Posyandu berhasil ditambahkan.');
    }

    public function show($id)
    {
        $posyandu = Posyandu::findOrFail($id);
        return view('posyandu.show', compact('posyandu'));
    }

    public function edit($id)
    {
        $posyandu = Posyandu::findOrFail($id);
        return view('posyandu.edit', compact('posyandu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:100',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'kontak' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $posyandu = Posyandu::findOrFail($id);
        $data = $request->only(['nama', 'alamat', 'rt', 'rw', 'kontak']);
        
        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($posyandu->foto && Storage::disk('public')->exists($posyandu->foto)) {
                Storage::disk('public')->delete($posyandu->foto);
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('posyandu_foto', $filename, 'public');
            $data['foto'] = 'posyandu_foto/' . $filename;
        }
        
        // Handle multiple file uploads
        $existingFiles = $posyandu->files ? json_decode($posyandu->files, true) : [];
        
        // Hapus file yang dipilih untuk dihapus
        if ($request->has('delete_files')) {
            foreach ($request->delete_files as $fileToDelete) {
                if (Storage::disk('public')->exists($fileToDelete)) {
                    Storage::disk('public')->delete($fileToDelete);
                }
                $existingFiles = array_filter($existingFiles, function($file) use ($fileToDelete) {
                    return $file['path'] !== $fileToDelete;
                });
            }
            $existingFiles = array_values($existingFiles); // Re-index array
        }
        
        // Tambah file baru
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('posyandu_files', $filename, 'public');
                $existingFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => 'posyandu_files/' . $filename,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                ];
            }
        }
        
        $data['files'] = !empty($existingFiles) ? json_encode($existingFiles) : null;
        
        $posyandu->update($data);

        return redirect()->route('posyandu.index')
            ->with('success', 'Posyandu berhasil diupdate.');
    }

    public function destroy($id)
    {
        $posyandu = Posyandu::findOrFail($id);
        
        // Hapus foto jika ada
        if ($posyandu->foto && Storage::disk('public')->exists($posyandu->foto)) {
            Storage::disk('public')->delete($posyandu->foto);
        }
        
        // Hapus semua file yang terkait
        if ($posyandu->files) {
            $files = json_decode($posyandu->files, true);
            if (is_array($files)) {
                foreach ($files as $file) {
                    if (isset($file['path']) && Storage::disk('public')->exists($file['path'])) {
                        Storage::disk('public')->delete($file['path']);
                    }
                }
            }
        }
        
        $posyandu->delete();

        return redirect()->route('posyandu.index')
            ->with('success', 'Posyandu berhasil dihapus.');
    }
}