<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            // Menghitung total semua jenis alat
            'total_alat'      => Alat::count(),
            
            // PERBAIKAN: Mengambil data koleksi alat (bukan cuma angka) agar nama alat bisa muncul di sidebar
            'stok_menipis'    => Alat::where('stok', '<', 5)->get(),
            
            // Menghitung jumlah pengajuan yang statusnya masih 'menunggu'
            'pinjam_menunggu' => Peminjaman::where('status', 'menunggu')->count(),
            
            // Menghitung transaksi yang sedang berjalan (status 'disetujui' atau sedang dipinjam)
            'pinjam_aktif'    => Peminjaman::where('status', 'disetujui')->count(),
            
            // Mengambil total uang denda yang sudah masuk ke kas
            'total_denda'     => Pengembalian::sum('denda'),
            
            // Mengambil 5 aktivitas terbaru beserta data user yang melakukannya
            'recent_logs'     => ActivityLog::with('user')->latest()->take(5)->get()
        ];

        return view('admin.dashboard', $data);
    }
}