<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian; // Pastikan Model ini di-import
use App\Models\Alat;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * 1. Monitoring Semua Transaksi
     */
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'detailPeminjaman.alat', 'petugas'])
            ->latest()
            ->paginate(15);

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    /**
     * 2. Menampilkan daftar permohonan yang butuh approval
     */
    public function indexApproval()
    {
        $peminjamans = Peminjaman::with(['user', 'detailPeminjaman.alat'])
            ->where('status', 'menunggu')
            ->latest()
            ->paginate(10);

        return view('admin.peminjaman.approval', compact('peminjamans'));
    }

    /**
     * 3. Fungsi Menyetujui Peminjaman
     */
    public function setujui($id)
    {
        try {
            DB::beginTransaction();

            // Gunakan eager loading untuk menghindari N+1 query
            $peminjaman = Peminjaman::with('detailPeminjaman.alat')->findOrFail($id);

            if ($peminjaman->status !== 'menunggu') {
                return back()->with('error', 'Transaksi ini sudah diproses sebelumnya.');
            }

            // Validasi Stok Massal
            foreach ($peminjaman->detailPeminjaman as $detail) {
                if (!$detail->alat || $detail->alat->stok < $detail->jumlah) {
                    throw new \Exception("Stok alat " . ($detail->alat->nama_alat ?? 'Unknown') . " tidak mencukupi.");
                }
            }

            // Eksekusi Pengurangan Stok
            foreach ($peminjaman->detailPeminjaman as $detail) {
                $detail->alat->decrement('stok', $detail->jumlah);
            }

            $peminjaman->update(['status' => 'disetujui']);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Penyetujuan (Admin)',
                'deskripsi' => auth()->user()->name . ' menyetujui peminjaman: ' . $peminjaman->kode_peminjaman,
                'ip_address' => request()->ip(),
            ]);

            DB::commit();
            return back()->with('success', 'Peminjaman berhasil disetujui oleh Admin.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * 4. Logika menolak peminjaman
     */
    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'ditolak']);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Penolakan (Admin)',
            'deskripsi' => auth()->user()->name . ' menolak peminjaman: ' . $peminjaman->kode_peminjaman,
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', 'Permohonan peminjaman telah ditolak.');
    }

    /**
     * 5. Detail Transaksi
     */
    public function show($id)
    {
        // Pastikan relasi 'logs' ada di model Peminjaman jika ingin digunakan
        $peminjaman = Peminjaman::with(['user', 'detailPeminjaman.alat', 'petugas'])->findOrFail($id);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    /**
     * 6. Fungsi Hapus Transaksi
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $peminjaman = Peminjaman::with('detailPeminjaman.alat')->findOrFail($id);

            // Jika status disetujui (sedang dipinjam), kembalikan stok sebelum dihapus
            if ($peminjaman->status == 'disetujui') {
                foreach ($peminjaman->detailPeminjaman as $detail) {
                    if ($detail->alat) {
                        $detail->alat->increment('stok', $detail->jumlah);
                    }
                }
            }

            $peminjaman->delete();

            ActivityLog::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Hapus Transaksi',
                'deskripsi' => auth()->user()->name . ' menghapus data: ' . $peminjaman->kode_peminjaman,
                'ip_address' => request()->ip(),
            ]);

            DB::commit();
            return redirect()->route('admin.peminjaman.index')->with('success', 'Data transaksi berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    /**
     * 7. Store Pengembalian (SINKRONISASI DENDA POSITIF)
     */
    public function storePengembalian(Request $request, $kode)
    {
        try {
            DB::beginTransaction();

            $items = Peminjaman::with('detailPeminjaman.alat')
                        ->where('kode_peminjaman', $kode)
                        ->where('status', 'disetujui')
                        ->get();

            if ($items->isEmpty()) {
                return redirect()->route('admin.peminjaman.index')->with('error', 'Transaksi tidak ditemukan atau sudah diproses.');
            }

            foreach ($items as $index => $peminjaman) {
                // SINKRONISASI: Denda dipastikan absolut (positif)
                $nominalDenda = ($index == 0) ? abs($request->denda) : 0;

                Pengembalian::create([
                    'peminjaman_id'      => $peminjaman->id,
                    'tgl_kembali_aktual' => $request->tgl_kembali_aktual ?? now(),
                    'denda'              => $nominalDenda, 
                    'petugas_id'         => auth()->id(),
                ]);

                $peminjaman->update([
                    'status' => 'selesai',
                    'denda'  => $nominalDenda,
                    'tgl_kembali_real' => $request->tgl_kembali_aktual ?? now()
                ]);
                
                // Kembalikan stok alat ke inventaris
                foreach ($peminjaman->detailPeminjaman as $detail) {
                    if ($detail->alat) {
                        $detail->alat->increment('stok', $detail->jumlah);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.pengembalian.index')->with('success', 'Pengembalian berhasil diproses. Denda tercatat.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}