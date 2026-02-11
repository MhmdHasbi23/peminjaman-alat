<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Petugas\AlatController as PetugasAlat;
use App\Http\Controllers\Petugas\TransaksiController as TransaksiPetugas;
use App\Http\Controllers\Petugas\LaporanController as LaporanPetugas;
use App\Http\Controllers\Petugas\DashboardController as DashPetugas;
use App\Http\Controllers\Peminjam\AlatController as AlatUser;
use App\Http\Controllers\Peminjam\TransaksiController as TransaksiUser;

Route::get('/', function () {
    return redirect()->route('login');
});

/*
| Dashboard Redirect (SETELAH LOGIN)
*/
Route::middleware('auth')->get('/dashboard', function () {

    return match (auth()->user()->role) {
        'admin'     => redirect()->route('admin.dashboard'),
        'petugas'   => redirect()->route('petugas.dashboard'),
        'peminjam'  => redirect()->route('peminjam.dashboard'),
        default     => abort(403),
    };

})->name('dashboard');

/*
| Admin Route
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // 1. DASHBOARD
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // 2. MASTER DATA
        Route::resource('user', UserController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('alat', AlatController::class);
        
        // 3. MONITORING & APPROVAL (Mengacu pada TransaksiController Admin)
        // Menampilkan semua transaksi
        Route::get('/peminjaman', [TransaksiController::class, 'index'])->name('peminjaman.index');
        
        // Menampilkan daftar yang butuh persetujuan
        Route::get('/peminjaman/approval', [TransaksiController::class, 'indexApproval'])->name('peminjaman.approval');
        
        // Aksi Setuju & Tolak (Gunakan POST/PATCH)
        Route::post('/peminjaman/setujui/{id}', [TransaksiController::class, 'setujui'])->name('peminjaman.setujui');
        Route::post('/peminjaman/tolak/{id}', [TransaksiController::class, 'tolak'])->name('peminjaman.tolak');

        // 4. DETAIL & HAPUS
        Route::get('/peminjaman/detail/{id}', [TransaksiController::class, 'show'])->name('peminjaman.show');
        Route::delete('/peminjaman/hapus/{id}', [TransaksiController::class, 'destroy'])->name('peminjaman.destroy');

        // 5. LOG AKTIVITAS
        Route::get('/log-aktivitas', [ActivityLogController::class, 'index'])->name('log.index');
});

/*
| Petugas Route
*/
Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('petugas.dashboard');
        })->name('dashboard');

        Route::get('/dashboard', [DashPetugas::class, 'index'])->name('dashboard');
        Route::get('/daftar-alat', [PetugasAlat::class, 'index'])->name('alat.index');
        Route::get('/peminjaman/approval', [TransaksiPetugas::class, 'indexApproval'])->name('peminjaman.index');
        Route::post('/peminjaman/setujui/{id}', [TransaksiPetugas::class, 'setujui'])->name('peminjaman.setujui');
        Route::post('/peminjaman/tolak/{id}', [TransaksiPetugas::class, 'tolak'])->name('peminjaman.tolak');
        Route::get('/pengembalian', [TransaksiPetugas::class, 'indexValidasi'])->name('pengembalian.index');
    
    // Proses pengembalian barang
        Route::post('/pengembalian/konfirmasi/{id}', [TransaksiPetugas::class, 'konfirmasiKembali'])->name('pengembalian.konfirmasi');
        Route::get('/pengembalian/cek/{id}', [TransaksiPetugas::class, 'cekDenda'])->name('pengembalian.cek');
    
    // Tahap 2: Proses Simpan ke Database
        Route::post('/pengembalian/simpan/{id}', [TransaksiPetugas::class, 'simpanPengembalian'])->name('pengembalian.simpan');
        Route::get('/laporan', [LaporanPetugas::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [LaporanPetugas::class, 'cetakPdf'])->name('laporan.cetak');
});

/*
| Peminjam Route
*/
Route::middleware(['auth', 'role:peminjam'])
    ->prefix('peminjam')
    ->name('peminjam.')
    ->group(function () {

        Route::get('/dashboard', [TransaksiUser::class, 'index'])->name('dashboard');

        // Katalog Alat
        Route::get('/daftar-alat', [AlatUser::class, 'index'])->name('alat.index');

        // Keranjang (Cart) - Untuk meminjam lebih dari 1 jenis barang
        Route::post('/cart/add', [TransaksiUser::class, 'addToCart'])->name('cart.add');
        Route::get('/cart/hapus/{id}', [TransaksiUser::class, 'removeFromCart'])->name('cart.remove');

        // Checkout - Untuk menjadwalkan tanggal pinjam & kembali
        Route::get('/checkout', [TransaksiUser::class, 'checkout'])->name('checkout');
        
        // Simpan transaksi ke Header & Detail
        Route::post('/pinjam/simpan', [TransaksiUser::class, 'store'])->name('pinjam.store');
        Route::get('/riwayat', [TransaksiUser::class, 'history'])->name('riwayat');
        Route::get('/kembalikan', [TransaksiUser::class, 'returning'])->name('kembalikan');
});

/*
| Profile Route (ALL ROLE)
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';