@extends('layouts.admin')

@section('content')
<div class="container" style="margin-top: 40px; max-width: 700px; font-family: 'Segoe UI', sans-serif;">
    <div
        style="background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 35px; border: 1px solid #e3e6f0;">

        <h4 style="margin-bottom: 25px; color: #3a3b45; font-weight: 700; text-align: center;">
            📄 Konfirmasi Pengembalian Massal
        </h4>

        {{-- Kotak Informasi Transaksi --}}
        <div
            style="background: #f8f9fc; padding: 20px; border-radius: 8px; margin-bottom: 25px; border-left: 5px solid #4e73df;">
            <p style="margin: 5px 0;">
                <strong>Kode Transaksi:</strong> <span style="color: #4e73df;">{{ $kode }}</span>
            </p>
            <p style="margin: 5px 0;">
                <strong>Nama Peminjam:</strong> {{ $first->user->name ?? 'User Tidak Ditemukan' }}
            </p>

            <hr style="border: 0; border-top: 1px solid #d1d3e2; margin: 15px 0;">

            <p style="margin: 5px 0; font-weight: 700; color: #3a3b45;">Daftar Alat yang Dikembalikan:</p>
            <ul style="margin: 10px 0; padding-left: 20px; color: #6e707e;">
                {{-- Membongkar detail peminjaman agar nama alat muncul benar --}}
                @foreach($items as $peminjaman)
                @foreach($peminjaman->detailPeminjaman as $detail)
                <li style="margin-bottom: 5px;">
                    <span style="color: #333; font-weight: 500;">
                        {{ $detail->alat->nama_alat ?? 'Alat tidak ditemukan' }}
                    </span>
                    <strong style="color: #4e73df;">({{ $detail->jumlah }} Unit)</strong>
                </li>
                @endforeach
                @endforeach
            </ul>

            <hr style="border: 0; border-top: 1px solid #d1d3e2; margin: 15px 0;">

            <div style="display: flex; justify-content: space-between; font-size: 0.9rem;">
                <div>
                    <span style="color: #858796;">Batas Kembali:</span><br>
                    <strong style="color: #e74a3b;">
                        {{ \Carbon\Carbon::parse($first->tgl_kembali_rencana)->format('d M Y') }}
                    </strong>
                </div>
                <div style="text-align: right;">
                    <span style="color: #858796;">Tanggal Kembali (Sistem):</span><br>
                    <strong style="color: #1cc88a;">
                        {{ $tgl_aktual->format('d M Y') }}
                    </strong>
                </div>
            </div>
        </div>

        {{-- Area Tampilan Kalkulasi Denda --}}
        <div
            style="text-align: center; margin-bottom: 30px; padding: 20px; border: 2px dashed #e3e6f0; border-radius: 10px;">
            @if($hari_terlambat > 0)
            <div style="color: #e74a3b; font-size: 1.1rem; font-weight: 700; text-transform: uppercase;">
                ⚠️ Terlambat {{ $hari_terlambat }} Hari
            </div>
            <div style="font-size: 2.2rem; color: #e74a3b; font-weight: 800; margin-top: 5px;">
                Rp {{ number_format($denda, 0, ',', '.') }}
            </div>
            <p style="color: #858796; font-size: 0.8rem; margin: 0;">(Denda otomatis dihitung Rp 5.000 / hari per
                transaksi)</p>
            @else
            <div style="color: #1cc88a; font-size: 1.1rem; font-weight: 700; text-transform: uppercase;">
                ✅ Pengembalian Tepat Waktu
            </div>
            <div style="font-size: 2.2rem; color: #1cc88a; font-weight: 800; margin-top: 5px;">
                Rp 0
            </div>
            @endif
        </div>

        {{-- Form Konfirmasi --}}
        <form action="{{ route('admin.peminjaman.store_pengembalian', $kode) }}" method="POST">
            @csrf
            {{-- Mengirim denda dan tgl aktual ke controller --}}
            <input type="hidden" name="tgl_kembali_aktual" value="{{ $tgl_aktual->format('Y-m-d H:i:s') }}">
            <input type="hidden" name="denda" value="{{ $denda }}">

            <div style="display: flex; gap: 12px;">
                <button type="submit"
                    style="flex: 2; background-color: #1cc88a; color: white; border: none; padding: 15px; border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer; transition: 0.3s;"
                    onclick="return confirm('Apakah barang sudah diterima lengkap dan denda sudah lunas? Stok akan otomatis bertambah.')">
                    Konfirmasi & Simpan Pengembalian
                </button>
                <a href="{{ route('admin.peminjaman.index') }}"
                    style="flex: 1; text-align: center; background-color: #f8f9fc; color: #4e73df; border: 1px solid #d1d3e2; padding: 15px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 15px;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection