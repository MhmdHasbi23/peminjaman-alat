@extends('layouts.admin')

@section('content')
<div class="container" style="margin-top: 40px; max-width: 700px; font-family: 'Segoe UI', sans-serif;">
    <div
        style="background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); padding: 35px; border: 1px solid #e3e6f0;">
        <h4 style="margin-bottom: 25px; color: #3a3b45; font-weight: 700; text-align: center;">📄 Konfirmasi
            Pengembalian</h4>

        <div
            style="background: #f8f9fc; padding: 20px; border-radius: 8px; margin-bottom: 25px; border-left: 5px solid #4e73df;">
            <p><strong>Kode:</strong> {{ $kode }}</p>
            <p><strong>Peminjam:</strong> {{ $first->user->name ?? 'User Tidak Ditemukan' }}</p>

            <hr>
            <p style="font-weight: 700;">Daftar Alat:</p>
            <ul>
                @foreach($items as $peminjaman)
                @foreach($peminjaman->detailPeminjaman as $detail)
                <li>{{ $detail->alat->nama_alat ?? 'Alat Dihapus' }} <strong>({{ $detail->jumlah }} Unit)</strong></li>
                @endforeach
                @endforeach
            </ul>
        </div>

        {{-- Tampilan Denda Otomatis --}}
        <div
            style="text-align: center; margin-bottom: 30px; padding: 20px; border: 2px dashed #e3e6f0; border-radius: 10px;">
            @if($hari_terlambat > 0)
            <div style="color: #e74a3b; font-weight: 700;">⚠️ TERLAMBAT {{ $hari_terlambat }} HARI</div>
            <div style="font-size: 2rem; color: #e74a3b; font-weight: 800;">Rp {{ number_format($denda, 0, ',', '.') }}
            </div>
            @else
            <div style="color: #1cc88a; font-weight: 700;">✅ TEPAT WAKTU</div>
            <div style="font-size: 2rem; color: #1cc88a; font-weight: 800;">Rp 0</div>
            @endif
        </div>

        <form action="{{ route('admin.peminjaman.store_pengembalian', $kode) }}" method="POST">
            @csrf
            <input type="hidden" name="tgl_kembali_aktual" value="{{ $tgl_aktual->format('Y-m-d H:i:s') }}">
            <input type="hidden" name="denda" value="{{ $denda }}">

            <div style="display: flex; gap: 10px;">
                <button type="submit"
                    style="flex: 2; background: #1cc88a; color: white; border: none; padding: 15px; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    Simpan Pengembalian
                </button>
                <a href="{{ route('admin.peminjaman.index') }}"
                    style="flex: 1; text-align: center; background: #f8f9fc; padding: 15px; border-radius: 8px; text-decoration: none; color: #333;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection