@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-4" style="margin-top: 40px; font-family: 'Inter', 'Segoe UI', sans-serif;">
    <div
        style="max-width: 600px; margin: auto; background: white; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; overflow: hidden;">

        {{-- Header Gradasi --}}
        <div
            style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); padding: 30px; color: white; text-align: center;">
            <div
                style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                <i class="fas fa-calculator" style="font-size: 24px;"></i>
            </div>
            <h5 style="margin: 0; font-weight: 800; letter-spacing: 1px; text-transform: uppercase;">Kalkulasi
                Pengembalian</h5>
            <p style="margin: 5px 0 0 0; font-size: 0.8rem; opacity: 0.8;">Validasi kondisi barang dan hitung total
                denda</p>
        </div>

        <div style="padding: 35px;">
            <form action="{{ route('petugas.pengembalian.simpan', $peminjaman->id) }}" method="POST"
                id="formPengembalian">
                @csrf

                {{-- Ringkasan Identitas --}}
                <div class="d-flex justify-content-between mb-4 pb-3" style="border-bottom: 1px dashed #e2e8f0;">
                    <div>
                        <small
                            style="display:block; color: #a0aec0; font-weight: 800; font-size: 10px; text-transform: uppercase;">Peminjam</small>
                        <span style="font-weight: 700; color: #2d3748;">{{ $peminjaman->user->name }}</span>
                    </div>
                    <div class="text-end">
                        <small
                            style="display:block; color: #a0aec0; font-weight: 800; font-size: 10px; text-transform: uppercase;">Kode
                            Transaksi</small>
                        <span
                            style="font-family: 'JetBrains Mono', monospace; font-weight: 700; color: #4e73df;">#{{ $peminjaman->kode_peminjaman }}</span>
                    </div>
                </div>

                {{-- Daftar Alat --}}
                <div
                    style="background: #f8fafc; border-radius: 12px; padding: 18px; border: 1px solid #edf2f7; margin-bottom: 25px;">
                    <small
                        style="color: #64748b; font-weight: 800; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 10px;">Item
                        Dikembalikan:</small>
                    @foreach($peminjaman->detailPeminjaman as $detail)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span
                            style="font-size: 14px; color: #334155; font-weight: 500;">{{ $detail->alat->nama_alat }}</span>
                        <span class="badge"
                            style="background: white; border: 1px solid #e2e8f0; color: #4e73df; font-weight: 700;">{{ $detail->jumlah }}
                            Unit</span>
                    </div>
                    @endforeach
                </div>

                {{-- Panel Hitung Denda --}}
                <div style="background: #ffffff; border: 2px solid #f1f5f9; border-radius: 15px; padding: 20px;">

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <label
                                style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">1.
                                Denda Terlambat ({{ $hari_terlambat }} Hari)</label>
                            @if($hari_terlambat > 0)
                            <span class="badge bg-danger" style="font-size: 9px;">Terlambat</span>
                            @else
                            <span class="badge bg-success" style="font-size: 9px;">Tepat Waktu</span>
                            @endif
                        </div>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background: #f8fafc; border-right: none; font-weight: 700; color: #64748b;">Rp</span>
                            <input type="number" id="denda_terlambat" class="form-control"
                                value="{{ $denda_terlambat }}" readonly
                                style="background: #f8fafc; font-weight: 700; border-left: none; color: #64748b;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label
                            style="font-size: 11px; font-weight: 800; color: #e11d48; text-transform: uppercase; display: block; margin-bottom: 8px;">2.
                            Denda Kerusakan / Kehilangan</label>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background: white; border-right: none; color: #e11d48; font-weight: 800;">Rp</span>
                            <input type="number" id="denda_tambahan" name="denda_tambahan" class="form-control"
                                value="0" min="0" placeholder="0"
                                style="border-left: none; font-weight: 700; color: #e11d48;">
                        </div>
                        <small
                            style="font-size: 10px; color: #94a3b8; font-style: italic; margin-top: 5px; display: block;">*Masukkan
                            nominal denda jika barang rusak atau hilang</small>
                    </div>

                    <div style="border-top: 2px dashed #edf2f7; margin: 20px 0;"></div>

                    <div class="text-center">
                        <label
                            style="font-size: 11px; font-weight: 800; color: #1e293b; text-transform: uppercase; letter-spacing: 1px;">Total
                            Bayar Denda</label>
                        <h2 style="color: #1e293b; font-weight: 900; margin: 5px 0; font-size: 2.2rem;"
                            id="display_total">
                            Rp {{ number_format($denda_terlambat, 0, ',', '.') }}
                        </h2>
                        {{-- Input Hidden yang dikirim ke database --}}
                        <input type="hidden" name="denda" id="denda_final" value="{{ $denda_terlambat }}">
                    </div>
                </div>

                <div class="mt-4 mb-4">
                    <label
                        style="font-size: 11px; font-weight: 800; color: #4a5568; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; display: block;">Catatan
                        Alasan Denda</label>
                    <textarea name="catatan" class="form-control" rows="3"
                        placeholder="Contoh: Terlambat 2 hari & obeng hilang 1..."
                        style="border-radius: 12px; font-size: 14px; border: 1px solid #e2e8f0;"></textarea>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex flex-column gap-2">
                    <button type="submit" class="btn btn-success py-3"
                        style="border-radius: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 12px rgba(28, 200, 138, 0.2);"
                        onclick="return confirm('Selesaikan transaksi? Pastikan denda sudah diterima.')">
                        <i class="fas fa-check-circle me-2"></i> Terima & Selesaikan
                    </button>
                    <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-link text-muted"
                        style="font-size: 13px; text-decoration: none; font-weight: 600;">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script Kalkulasi Otomatis --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputTelat = document.getElementById('denda_terlambat');
    const inputTambahan = document.getElementById('denda_tambahan');
    const displayTotal = document.getElementById('display_total');
    const inputFinal = document.getElementById('denda_final');

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function kalkulasi() {
        // Gunakan Math.abs() untuk memaksa angka menjadi positif
        const telat = Math.abs(parseInt(inputTelat.value)) || 0;
        let tambahan = parseInt(inputTambahan.value) || 0;
        
        // Jika petugas menginput angka negatif, otomatis ubah jadi positif
        if (tambahan < 0) {
            tambahan = Math.abs(tambahan);
            inputTambahan.value = tambahan;
        }

        const total = telat + tambahan;

        displayTotal.innerText = formatRupiah(total);
        inputFinal.value = total;
    }

    inputTambahan.addEventListener('input', kalkulasi);
});
</script>

<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance: textfield;
}

.form-control:focus {
    border-color: #4e73df;
    box-shadow: none;
}
</style>
@endsection