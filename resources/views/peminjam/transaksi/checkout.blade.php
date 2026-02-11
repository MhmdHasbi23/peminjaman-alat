@extends('layouts.peminjam')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', 'Segoe UI', sans-serif;">

    <div class="mb-4 d-flex align-items-center justify-content-between">
        <div>
            <h4 style="font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -0.5px;">📅 Jadwalkan Peminjaman
            </h4>
            <p style="color: #64748b; font-size: 0.95rem; margin-top: 5px;">Lengkapi detail waktu dan periksa kembali
                daftar alat yang akan Anda pinjam.</p>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('peminjam.alat.index') }}" class="btn btn-light"
                style="border-radius: 10px; font-weight: 600; color: #4e73df; border: 1px solid #e2e8f0;">
                <i class="fas fa-plus me-2"></i> Tambah Alat Lagi
            </a>
        </div>
    </div>

    @if(session('error'))
    <div class="alert border-0 shadow-sm mb-4"
        style="background: #fff1f2; color: #e11d48; border-radius: 12px; padding: 15px 20px;">
        <i class="fas fa-exclamation-circle me-2"></i> <span style="font-weight: 600;">Gagal:</span>
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('peminjam.pinjam.store') }}" method="POST">
        @csrf

        <div class="row mb-4">
            <div class="col-lg-12">
                <div
                    style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label
                                style="font-size: 0.75rem; font-weight: 800; color: #4e73df; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 10px;">
                                <i class="fas fa-calendar-plus me-1"></i> Tanggal Mulai Pinjam
                            </label>
                            <input type="date" name="tgl_pinjam" class="form-control" required min="{{ date('Y-m-d') }}"
                                style="border-radius: 12px; border: 1px solid #e2e8f0; padding: 12px; font-weight: 600; color: #1e293b; background: #f8fafc;">
                        </div>
                        <div class="col-md-6">
                            <label
                                style="font-size: 0.75rem; font-weight: 800; color: #e11d48; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 10px;">
                                <i class="fas fa-calendar-check me-1"></i> Rencana Tanggal Kembali
                            </label>
                            <input type="date" name="tgl_kembali_rencana" class="form-control" required
                                min="{{ date('Y-m-d') }}"
                                style="border-radius: 12px; border: 1px solid #e2e8f0; padding: 12px; font-weight: 600; color: #1e293b; background: #f8fafc;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            style="background: white; border-radius: 20px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; overflow: hidden;">
            <div style="padding: 20px 25px; border-bottom: 1px solid #f1f5f9; background: #ffffff;">
                <h6 style="font-weight: 800; color: #1e293b; margin: 0; font-size: 1rem;">
                    <i class="fas fa-shopping-basket text-primary me-2"></i> Konfirmasi Daftar Alat
                </h6>
            </div>

            <div class="table-responsive">
                <table class="table mb-0" style="width: 100%; vertical-align: middle;">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th
                                style="padding: 15px 25px; font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px; border-bottom: 1px solid #f1f5f9;">
                                Nama Alat</th>
                            <th
                                style="padding: 15px 25px; font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                Jumlah Pinjam</th>
                            <th
                                style="padding: 15px 25px; font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cart as $id => $item)
                        <tr style="transition: all 0.2s ease;">
                            <td style="padding: 20px 25px; border-bottom: 1px solid #f1f5f9;">
                                <div class="d-flex align-items-center">
                                    <div
                                        style="width: 40px; height: 40px; background: #f0f7ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 15px; color: #4e73df;">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                    <span
                                        style="font-weight: 700; color: #1e293b; font-size: 0.95rem;">{{ $item['nama'] }}</span>
                                </div>
                            </td>
                            <td style="padding: 20px 25px; text-align: center; border-bottom: 1px solid #f1f5f9;">
                                <span
                                    style="background: #eef2ff; color: #4e73df; padding: 6px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 800; border: 1px solid #e0e7ff;">
                                    {{ $item['jumlah'] }} unit
                                </span>
                            </td>
                            <td style="padding: 20px 25px; text-align: center; border-bottom: 1px solid #f1f5f9;">
                                <a href="{{ route('peminjam.cart.remove', $id) }}" class="btn-delete-item"
                                    style="width: 35px; height: 35px; border-radius: 10px; border: 1px solid #fee2e2; background: white; color: #ef4444; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.2s;">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="padding: 80px; text-align: center;">
                                <div style="color: #cbd5e1; font-size: 4rem; margin-bottom: 15px;"><i
                                        class="fas fa-shopping-cart"></i></div>
                                <h6 style="color: #64748b; font-weight: 700;">Daftar pinjam Anda masih kosong</h6>
                                <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 20px;">Silakan pilih alat
                                    dari katalog terlebih dahulu.</p>
                                <a href="{{ route('peminjam.alat.index') }}" class="btn btn-primary shadow-sm"
                                    style="border-radius: 10px; font-weight: 700; padding: 10px 25px;">
                                    <i class="fas fa-search me-2"></i> Cari Alat Sekarang
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(count($cart) > 0)
        <div class="mt-4">
            <button type="submit" class="btn btn-success w-100"
                style="font-weight: 800; padding: 18px; border-radius: 15px; box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2); border: none; background: linear-gradient(135deg, #10b981 0%, #059669 100%); letter-spacing: 0.5px; transition: 0.3s;"
                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-paper-plane me-2"></i> KIRIM PENGAJUAN PEMINJAMAN
            </button>
            <p style="text-align: center; color: #94a3b8; font-size: 0.8rem; margin-top: 15px;">
                <i class="fas fa-info-circle me-1"></i> Dengan mengirim pengajuan, Anda bersedia menaati syarat dan
                ketentuan peminjaman alat.
            </p>
        </div>
        @endif

        <div class="text-center mt-2 mb-5">
            <a href="{{ route('peminjam.alat.index') }}"
                style="text-decoration: none; color: #64748b; font-size: 0.9rem; font-weight: 600; transition: 0.2s;"
                onmouseover="this.style.color='#4e73df'" onmouseout="this.style.color='#64748b'">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Katalog Alat
            </a>
        </div>
    </form>
</div>

<style>
.btn-delete-item:hover {
    background: #fff1f2 !important;
    color: #e11d48 !important;
    border-color: #fecdd3 !important;
    transform: scale(1.1);
}

input[type="date"]::-webkit-calendar-picker-indicator {
    cursor: pointer;
    filter: invert(0.5) sepia(1) saturate(5) hue-rotate(175deg);
}
</style>
@endsection