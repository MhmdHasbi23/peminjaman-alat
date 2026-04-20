@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', sans-serif;">

    <div style="max-width: 650px; margin: auto;">

        <!-- HEADER -->
        <div style="margin-bottom:20px;">
            <h4 style="font-weight:800; color:#e5e7eb;">
                <i class="fas fa-calculator text-primary me-2"></i> Kalkulasi Pengembalian
            </h4>
            <p style="color:#94a3b8; font-size:0.9rem;">
                Validasi kondisi barang dan hitung total denda
            </p>
        </div>

        <!-- CARD -->
        <div style="
            background: rgba(15,23,42,0.7);
            backdrop-filter: blur(12px);
            border-radius:20px;
            border:1px solid rgba(255,255,255,0.08);
            box-shadow:0 20px 40px rgba(0,0,0,0.4);
            overflow:hidden;
        ">

            <!-- HEADER -->
            <div style="
                background: linear-gradient(135deg,#3b82f6,#2563eb);
                padding:25px;
                text-align:center;
                color:white;
            ">
                <i class="fas fa-calculator" style="font-size:28px;"></i>
                <h5 style="margin:10px 0 0;font-weight:800;">Kalkulasi Pengembalian</h5>
            </div>

            <div style="padding:30px;">
                <form action="{{ route('petugas.pengembalian.simpan', $peminjaman->id) }}" method="POST" id="formPengembalian">
                    @csrf

                    <!-- IDENTITAS -->
                    <div class="d-flex justify-content-between mb-4 pb-3" style="border-bottom:1px dashed rgba(255,255,255,0.1);">
                        <div>
                            <small style="color:#64748b;">Peminjam</small><br>
                            <span style="font-weight:700; color:#e5e7eb;">{{ $peminjaman->user->name }}</span>
                        </div>
                        <div class="text-end">
                            <small style="color:#64748b;">Kode</small><br>
                            <span style="color:#60a5fa; font-weight:700;">#{{ $peminjaman->kode_peminjaman }}</span>
                        </div>
                    </div>

                    <!-- DAFTAR ALAT -->
                    <div style="background: rgba(255,255,255,0.03); padding:15px; border-radius:12px; margin-bottom:20px;">
                        @foreach($peminjaman->detailPeminjaman as $detail)
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color:#cbd5f5;">{{ $detail->alat->nama_alat }}</span>
                            <span style="color:#60a5fa; font-weight:700;">{{ $detail->jumlah }} unit</span>
                        </div>
                        @endforeach
                    </div>

                    <!-- DENDA -->
                    <div style="background: rgba(255,255,255,0.02); border-radius:15px; padding:20px;">

                        <div class="mb-4">
                            <label style="font-size:12px; color:#94a3b8;">
                                Denda Terlambat ({{ $hari_terlambat }} Hari)
                            </label>
                            <input type="number" id="denda_terlambat"
                                class="form-control mt-2"
                                value="{{ $denda_terlambat }}" readonly
                                style="background:#020617; color:#94a3b8; border:none;">
                        </div>

                        <div class="mb-4">
                            <label style="font-size:12px; color:#f87171;">
                                Denda Kerusakan / Kehilangan
                            </label>
                            <input type="number" id="denda_tambahan" name="denda_tambahan"
                                class="form-control mt-2"
                                value="0"
                                style="background:#020617; color:#f87171; border:none;">
                        </div>

                        <div class="text-center mt-4">
                            <small style="color:#94a3b8;">Total Denda</small>
                            <h2 id="display_total" style="color:white; font-weight:800;">
                                Rp {{ number_format($denda_terlambat, 0, ',', '.') }}
                            </h2>

                            <input type="hidden" name="denda" id="denda_final"
                                value="{{ $denda_terlambat }}">
                        </div>
                    </div>

                    <!-- CATATAN -->
                    <div class="mt-4">
                        <textarea name="catatan" id="catatan"
                            class="form-control"
                            placeholder="Catatan alasan denda..."
                            style="background:#020617; color:white; border:none; border-radius:12px;"></textarea>
                    </div>

                    <!-- BUTTON -->
                    <div class="mt-4">
                        <button type="submit" id="btnSimpanPengembalian"
                            style="width:100%; padding:12px; border:none; border-radius:12px;
                            background: linear-gradient(135deg,#22c55e,#16a34a);
                            color:white; font-weight:700;">
                            ✔ Selesaikan
                        </button>

                        <a href="{{ route('petugas.pengembalian.index') }}"
                            id="btnKembali"
                            style="display:block; text-align:center; margin-top:10px; color:#94a3b8;">
                            Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    const inputTelat = document.getElementById('denda_terlambat');
    const inputTambahan = document.getElementById('denda_tambahan');
    const displayTotal = document.getElementById('display_total');
    const inputFinal = document.getElementById('denda_final');
    const formPengembalian = document.getElementById('formPengembalian');
    const btnSimpan = document.getElementById('btnSimpanPengembalian');
    const btnKembali = document.getElementById('btnKembali');
    const catatan = document.getElementById('catatan');

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function kalkulasi() {
        const telat = Math.abs(parseInt(inputTelat.value)) || 0;
        let tambahan = parseInt(inputTambahan.value) || 0;

        if (tambahan < 0) {
            tambahan = Math.abs(tambahan);
            inputTambahan.value = tambahan;
        }

        const total = telat + tambahan;

        displayTotal.innerText = formatRupiah(total);
        inputFinal.value = total;
    }

    inputTambahan.addEventListener('input', kalkulasi);

    // SweetAlert submit
    btnSimpan.addEventListener('click', function(e) {
        e.preventDefault();

        const totalDenda = parseInt(inputFinal.value) || 0;
        const isiCatatan = catatan.value.trim();
        const dendaTambahan = parseInt(inputTambahan.value) || 0;

        if (dendaTambahan > 0 && isiCatatan === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Catatan wajib diisi!',
                text: 'Isi alasan denda tambahan.',
                confirmButtonColor: '#e11d48'
            });
            return;
        }

        Swal.fire({
            title: 'Selesaikan Transaksi?',
            text: 'Total Denda: ' + formatRupiah(totalDenda),
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#22c55e',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Selesaikan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                formPengembalian.submit();
            }
        });
    });

});
</script>
@endsection