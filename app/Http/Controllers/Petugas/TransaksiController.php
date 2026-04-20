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
        $peminjamans = Peminjaman::with(['user', 'detailPeminjaman.alat'])
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

            // Ambil data peminjaman beserta detail alat
            $peminjaman = Peminjaman::with('detailPeminjaman.alat')->findOrFail($id);

            // Validasi stok sebelum disetujui
            foreach ($peminjaman->detailPeminjaman as $detail) {
                if (!$detail->alat) {
                    throw new \Exception('Data alat tidak ditemukan pada detail peminjaman.');
                }

                if ($detail->alat->stok < $detail->jumlah) {
                    throw new \Exception('Stok alat "' . $detail->alat->nama_alat . '" tidak mencukupi.');
                }
            }

            // Kurangi stok semua alat
            foreach ($peminjaman->detailPeminjaman as $detail) {
                $detail->alat->decrement('stok', $detail->jumlah);
            }

            // Update status menjadi disetujui
            $peminjaman->update([
                'status' => 'disetujui',
                'petugas_id' => auth()->id()
            ]);

            // Catat log aktivitas
            ActivityLog::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Penyetujuan',
                'deskripsi' => auth()->user()->name . ' menyetujui peminjaman ID: ' . $peminjaman->kode_peminjaman,
                'ip_address' => request()->ip(),
            ]);

            DB::commit();
            return back()->with('success', 'Peminjaman berhasil disetujui dan stok alat berhasil dikurangi!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyetujui: ' . $e->getMessage());
        }
    }

    // 3. Logika menolak peminjaman
    public function tolak($id)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($id);

            $peminjaman->update([
                'status' => 'ditolak',
                'petugas_id' => auth()->id()
            ]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Penolakan',
                'deskripsi' => auth()->user()->name . ' menolak peminjaman ID: ' . $peminjaman->kode_peminjaman,
                'ip_address' => request()->ip(),
            ]);

            return back()->with('success', 'Permohonan peminjaman telah ditolak.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menolak peminjaman: ' . $e->getMessage());
        }
    }

    public function indexValidasi()
    {
        $peminjamans = Peminjaman::with(['user', 'detailPeminjaman.alat'])
                        ->where('status', 'disetujui')
                        ->latest()
                        ->paginate(10);

        return view('petugas.pengembalian.index', compact('peminjamans'));
    }

    public function konfirmasiKembali(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman.alat')->findOrFail($id);

        $tgl_kembali_real = now();
        $tgl_seharusnya = \Carbon\Carbon::parse($peminjaman->tgl_kembali_rencana);

        $denda = 0;
        $tarif_denda = 5000;

        if ($tgl_kembali_real->gt($tgl_seharusnya)) {
            $selisih_hari = $tgl_kembali_real->diffInDays($tgl_seharusnya);
            $denda = $selisih_hari * $tarif_denda;
        }

        DB::transaction(function () use ($peminjaman, $denda, $tgl_kembali_real) {
            $peminjaman->update([
                'status' => 'selesai',
                'tgl_kembali_real' => $tgl_kembali_real,
                'denda' => $denda,
                'petugas_id' => auth()->id()
            ]);

            foreach ($peminjaman->detailPeminjaman as $detail) {
                if ($detail->alat) {
                    $detail->alat->increment('stok', $detail->jumlah);
                }
            }
        });

        return back()->with('success', 'Barang berhasil dikembalikan. Stok alat telah bertambah.');
    }

    public function cekDenda($id)
    {
        $peminjaman = Peminjaman::with(['user', 'detailPeminjaman.alat'])->findOrFail($id);

        $tgl_kembali_real = now()->startOfDay();
        $tgl_seharusnya = \Carbon\Carbon::parse($peminjaman->tgl_kembali_rencana)->startOfDay();

        $hari_terlambat = 0;
        $denda_terlambat = 0;
        $tarif_denda = 5000;

        if ($tgl_kembali_real->gt($tgl_seharusnya)) {
            $hari_terlambat = $tgl_kembali_real->diffInDays($tgl_seharusnya, true);
            $denda_terlambat = $hari_terlambat * $tarif_denda;
        }

        return view('petugas.pengembalian.cek_denda', compact(
            'peminjaman', 'tgl_kembali_real', 'hari_terlambat', 'denda_terlambat'
        ));
    }

    public function simpanPengembalian(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman.alat')->findOrFail($id);

        try {
            DB::beginTransaction();

            $dendaFinal = max(0, $request->input('denda', 0));
            $catatanManual = $request->input('catatan');

            $peminjaman->update([
                'status' => 'selesai',
                'tgl_kembali_real' => now(),
                'denda' => $dendaFinal,
                'catatan' => $catatanManual,
                'petugas_id' => auth()->id()
            ]);

            foreach ($peminjaman->detailPeminjaman as $detail) {
                if ($detail->alat) {
                    $detail->alat->increment('stok', $detail->jumlah);
                }
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Pengembalian Selesai',
                'deskripsi' => auth()->user()->name . ' memproses pengembalian ' . $peminjaman->kode_peminjaman . ' dengan denda Rp ' . number_format($dendaFinal),
                'ip_address' => request()->ip(),
            ]);

            DB::commit();

            return redirect()->route('petugas.pengembalian.index')->with('success', 'Transaksi berhasil diselesaikan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }
}