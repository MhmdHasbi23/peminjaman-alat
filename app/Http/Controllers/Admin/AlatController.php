<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $alats = Alat::with('kategori')->latest()->paginate(10);
        return view('admin.alat.index', compact('alats'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.alat.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat'   => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'spesifikasi' => 'required|string',
            'stok'        => 'required|integer|min:0',
        ]);

        try {
            Alat::create([
                'nama_alat'   => $request->nama_alat,
                'kategori_id' => $request->kategori_id,
                'spesifikasi' => $request->spesifikasi,
                'stok'        => $request->stok,
            ]);

            return redirect()->route('admin.alat.index')
                ->with('success', 'Data alat berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data alat gagal ditambahkan!');
        }
    }

    public function edit(Alat $alat)
    {
        $kategoris = Kategori::all();
        return view('admin.alat.edit', compact('alat', 'kategoris'));
    }

    public function update(Request $request, Alat $alat)
    {
        $request->validate([
            'nama_alat'   => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id', // sesuaikan dengan nama tabel kategori kamu
            'spesifikasi' => 'required|string',
            'stok'        => 'required|integer|min:0',
        ]);

        try {
            $alat->update([
                'nama_alat'   => $request->nama_alat,
                'kategori_id' => $request->kategori_id,
                'spesifikasi' => $request->spesifikasi,
                'stok'        => $request->stok,
            ]);

            return redirect()->route('admin.alat.index')
                ->with('success', 'Data alat berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data alat gagal diupdate!');
        }
    }

    public function destroy(Alat $alat)
    {
        try {
            $alat->delete();

            return redirect()->route('admin.alat.index')
                ->with('success', 'Data alat berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.alat.index')
                ->with('error', 'Data alat gagal dihapus!');
        }
    }
}