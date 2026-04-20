<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        // 🔍 ALAT
        $alats = Alat::with('kategori')
            ->where('nama_alat', 'like', "%{$q}%")
            ->orWhereHas('kategori', function ($k) use ($q) {
                $k->where('nama_kategori', 'like', "%{$q}%");
            })
            ->limit(5)
            ->get();

        // 🔍 KATEGORI
        $kategoris = Kategori::where('nama_kategori', 'like', "%{$q}%")
            ->limit(5)
            ->get();

        // 🔍 PEMINJAMAN
        $peminjamans = Peminjaman::with('user')
            ->where('kode_peminjaman', 'like', "%{$q}%")
            ->orWhereHas('user', function ($u) use ($q) {
                $u->where('name', 'like', "%{$q}%");
            })
            ->limit(5)
            ->get();

        // 🔥 🔍 USER (INI YANG BARU)
        $users = User::where('name', 'like', "%{$q}%")
            ->orWhere('email', 'like', "%{$q}%")
            ->orWhere('role', 'like', "%{$q}%")
            ->limit(5)
            ->get();

        return view('admin.search', compact(
            'q',
            'alats',
            'kategoris',
            'peminjamans',
            'users'
        ));
    }
}