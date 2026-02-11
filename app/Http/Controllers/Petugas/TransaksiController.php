<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // 1. Menampilkan daftar permohonan yang statusnya masih 'menunggu'
    public function indexApproval()
    {
        // Menampilkan data status 'menunggu'
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->where('status', 'menunggu')
            ->latest()
            ->paginate(10);

        return view('petugas.peminjaman.approval', compact('peminjamans'));
    }

    /**
     * Fungsi untuk Menyetujui Peminjaman
     */
    public function setujui($id)
    {
        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::findOrFail($id);

            // Update status menjadi disetujui
            $peminjaman->update([
                'status' => 'disetujui'
            ]);

            // CATAT LOG AKTIVITAS (Agar Admin tahu petugas yang menyetujui)
            ActivityLog::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Penyetujuan',
                'deskripsi' => auth()->user()->name . ' menyetujui peminjaman ID: ' . $peminjaman->kode_peminjaman,
                'ip_address' => request()->ip(),
            ]);

            DB::commit();
            return back()->with('success', 'Peminjaman berhasil disetujui!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyetujui: ' . $e->getMessage());
        }
    }

    // 3. Logika menolak peminjaman
    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'ditolak']);

        return back()->with('success', 'Permohonan peminjaman telah ditolak.');
    }

    public function indexValidasi()
    {
        // Menggunakan paginate agar fungsi ($peminjamans->currentPage() - 1) di Blade tidak error
        $peminjamans = Peminjaman::with(['user', 'alat'])
                        ->where('status', 'disetujui')
                        ->latest()
                        ->paginate(10); // Ganti get() menjadi paginate()

        return view('petugas.pengembalian.index', compact('peminjamans'));
    }

    public function konfirmasiKembali(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $alat = Alat::findOrFail($peminjaman->alat_id);
        
        $tgl_kembali_real = now(); // Tanggal hari ini
        $tgl_seharusnya = \Carbon\Carbon::parse($peminjaman->tgl_kembali_rencana);
        
        $denda = 0;
        $tarif_denda = 5000; // Contoh denda per hari

        // Hitung jika terlambat
        if ($tgl_kembali_real->gt($tgl_seharusnya)) {
            $selisih_hari = $tgl_kembali_real->diffInDays($tgl_seharusnya);
            $denda = $selisih_hari * $tarif_denda;
        }

        DB::transaction(function () use ($peminjaman, $alat, $denda, $tgl_kembali_real) {
            // 1. Update status peminjaman jadi selesai
            $peminjaman->update([
                'status' => 'selesai',
                'tgl_kembali_real' => $tgl_kembali_real,
                'denda' => $denda,
                'petugas_id' => auth()->id()
            ]);

            // 2. Tambahkan kembali stok alat
            $alat->increment('stok', $peminjaman->jumlah);
        });

        return back()->with('success', 'Barang berhasil dikembalikan. Stok alat telah bertambah.');
    }

    // Tahap 1: Halaman Kalkulasi (Menghitung denda sebelum disimpan)
    public function cekDenda($id)
    {
        // Mengambil data peminjaman beserta detail alatnya
        $peminjaman = Peminjaman::with(['user', 'detailPeminjaman.alat'])->findOrFail($id);
        
        // Gunakan startOfDay agar perhitungan selisih jam tidak mengganggu hitungan hari
        $tgl_kembali_real = now()->startOfDay(); 
        $tgl_seharusnya = \Carbon\Carbon::parse($peminjaman->tgl_kembali_rencana)->startOfDay();
        
        $hari_terlambat = 0;
        $denda_terlambat = 0;
        $tarif_denda = 5000; 

        // Cek jika tanggal kembali aktual lebih besar (melewati) tanggal seharusnya
        if ($tgl_kembali_real->gt($tgl_seharusnya)) {
            /**
             * PERBAIKAN UTAMA:
             * Tambahkan parameter 'true' pada diffInDays agar hasilnya ABSOLUT (selalu positif)
             */
            $hari_terlambat = $tgl_kembali_real->diffInDays($tgl_seharusnya, true);
            $denda_terlambat = $hari_terlambat * $tarif_denda;
        }

        return view('petugas.pengembalian.cek_denda', compact(
            'peminjaman', 'tgl_kembali_real', 'hari_terlambat', 'denda_terlambat'
        ));
    }

    // Tahap 2: Eksekusi Simpan ke Database
    // Pastikan nama method-nya persis seperti ini
    public function simpanPengembalian(Request $request, $id)
    {
        // Ambil data Header Peminjaman beserta rincian alatnya
        $peminjaman = Peminjaman::with('detailPeminjaman.alat')->findOrFail($id);

        try {
            DB::beginTransaction();

            // Ambil denda dan catatan dari input manual petugas/admin
            // Gunakan Math.max untuk memastikan denda tidak negatif
            $dendaFinal = max(0, $request->input('denda', 0));
            $catatanManual = $request->input('catatan');

            // 1. Update Header Peminjaman
            $peminjaman->update([
                'status' => 'selesai',
                'tgl_kembali_real' => now(),
                'denda' => $dendaFinal, 
                'catatan' => $catatanManual,
                'petugas_id' => auth()->id()
            ]);

            // 2. Kembalikan stok alat
            foreach ($peminjaman->detailPeminjaman as $detail) {
                if ($detail->alat) {
                    $detail->alat->increment('stok', $detail->jumlah);
                }
            }

            // 3. Catat Log Aktivitas
            ActivityLog::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Pengembalian Selesai',
                'deskripsi' => auth()->user()->name . ' memproses pengembalian ' . $peminjaman->kode_peminjaman . ' dengan denda Rp ' . number_format($dendaFinal),
                'ip_address' => request()->ip(),
            ]);

            DB::commit();
            
            // Sesuaikan route redirect ini dengan nama route index validasi Anda
            return redirect()->route('petugas.pengembalian.index')->with('success', 'Transaksi berhasil diselesaikan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }
}