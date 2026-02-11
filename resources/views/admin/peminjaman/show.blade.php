@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', 'Segoe UI', sans-serif;">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-white shadow-sm border-0 me-3"
                style="border-radius: 10px; padding: 8px 15px; background: white;">
                <i class="fas fa-arrow-left text-primary"></i>
            </a>
            <div>
                <h4 style="font-weight: 800; color: #1a202c; margin: 0; letter-spacing: -0.5px;">Rincian Transaksi</h4>
                <span class="badge bg-primary-soft text-primary"
                    style="font-weight: 700; font-size: 13px;">{{ $peminjaman->kode_peminjaman }}</span>
            </div>
        </div>
        <div>
            <button class="btn btn-primary shadow-sm"
                style="border-radius: 10px; font-weight: 700; font-size: 13px; padding: 10px 20px;"
                onclick="window.print()">
                <i class="fas fa-print me-2"></i> Cetak Bukti
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div
                style="background: white; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.04); padding: 30px; border: 1px solid #f1f5f9;">

                <div class="d-flex align-items-center mb-4">
                    <div
                        style="width: 45px; height: 45px; background: #ebf4ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <i class="fas fa-info-circle text-primary"></i>
                    </div>
                    <h6
                        style="color: #1e293b; font-weight: 800; text-transform: uppercase; font-size: 14px; margin: 0; letter-spacing: 0.5px;">
                        Informasi Utama</h6>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless align-middle">
                        <tr class="border-bottom-faded">
                            <td width="40%" class="py-3 text-muted" style="font-size: 14px;">Nama Peminjam</td>
                            <td class="py-3" style="font-weight: 700; color: #1e293b;">{{ $peminjaman->user->name }}
                            </td>
                        </tr>
                        <tr class="border-bottom-faded">
                            <td class="py-3 text-muted" style="font-size: 14px;">Kontak / Email</td>
                            <td class="py-3" style="color: #475569;">{{ $peminjaman->user->email }}</td>
                        </tr>
                        <tr class="border-bottom-faded">
                            <td class="py-3 text-muted" style="font-size: 14px;">Jadwal Pinjam</td>
                            <td class="py-3" style="color: #1e293b; font-weight: 600;">
                                <i class="far fa-calendar-alt text-muted me-2"></i>
                                {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d M Y') }}
                            </td>
                        </tr>
                        <tr class="border-bottom-faded">
                            <td class="py-3 text-muted" style="font-size: 14px;">Target Pengembalian</td>
                            <td class="py-3" style="color: #e53e3e; font-weight: 600;">
                                <i class="far fa-clock me-2"></i>
                                {{ \Carbon\Carbon::parse($peminjaman->tgl_kembali_rencana)->format('d M Y') }}
                            </td>
                        </tr>
                        <tr class="border-bottom-faded">
                            <td class="py-3 text-muted" style="font-size: 14px;">Status Denda</td>
                            <td class="py-3">
                                <span
                                    style="background: #fff5f5; color: #c53030; padding: 6px 15px; border-radius: 8px; font-weight: 800; font-size: 14px;">
                                    Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3 text-muted" style="font-size: 14px;">Petugas Lapangan</td>
                            <td class="py-3">
                                <div class="d-flex align-items-center">
                                    <div
                                        style="width: 28px; height: 28px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px; font-size: 10px; font-weight: 800; color: #64748b;">
                                        {{ strtoupper(substr($peminjaman->petugas->name ?? '?', 0, 1)) }}
                                    </div>
                                    <span
                                        style="font-weight: 600; color: #475569;">{{ $peminjaman->petugas->name ?? 'Belum ada' }}</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="mt-5">
                    <h6 style="font-size: 13px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1px;"
                        class="mb-3">Item yang Dipinjam</h6>
                    <div class="row g-3">
                        @foreach($peminjaman->detailPeminjaman as $d)
                        <div class="col-md-6">
                            <div
                                style="background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 12px; padding: 15px; display: flex; align-items: center; justify-content: space-between;">
                                <div class="d-flex align-items-center">
                                    <div
                                        style="width: 35px; height: 35px; background: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                                        <i class="fas fa-box text-primary" style="font-size: 12px;"></i>
                                    </div>
                                    <span
                                        style="font-weight: 700; color: #334155; font-size: 14px;">{{ $d->alat->nama_alat }}</span>
                                </div>
                                <span class="badge bg-primary"
                                    style="border-radius: 6px; padding: 6px 10px;">{{ $d->jumlah }} Unit</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div
                style="background: #ffffff; border-radius: 20px; padding: 30px; border: 1px solid #f1f5f9; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.04);">
                <h6 style="font-weight: 800; font-size: 14px; color: #1e293b;" class="mb-4">
                    <i class="fas fa-stream text-primary me-2"></i> RIWAYAT SISTEM
                </h6>

                <div style="max-height: 550px; overflow-y: auto; padding-right: 10px;" class="custom-scrollbar">
                    @forelse($peminjaman->logs as $log)
                    <div
                        style="margin-bottom: 25px; border-left: 3px solid #e2e8f0; padding-left: 20px; position: relative;">
                        <div
                            style="position: absolute; width: 11px; height: 11px; background: #cbd5e1; border-radius: 50%; left: -7px; top: 5px; border: 2px solid white;">
                        </div>
                        <span
                            style="font-weight: 800; color: #4e73df; display: block; font-size: 13px;">{{ strtoupper($log->aktivitas) }}</span>
                        <p style="font-size: 13px; color: #475569; margin: 4px 0 8px 0; line-height: 1.5;">
                            {{ $log->deskripsi }}</p>
                        <div class="d-flex align-items-center">
                            <small style="font-size: 11px; color: #94a3b8; font-weight: 600;">
                                <i class="far fa-clock me-1"></i> {{ $log->created_at->diffForHumans() }}
                            </small>
                            <span style="margin: 0 10px; color: #e2e8f0;">•</span>
                            <small style="font-size: 10px; color: #cbd5e1; font-family: monospace;">IP:
                                {{ $log->ip_address }}</small>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/5058/5058432.png"
                            style="width: 50px; opacity: 0.2;" class="mb-3">
                        <p class="text-muted" style="font-size: 13px;">Belum ada riwayat aktivitas.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-primary-soft {
    background-color: #ebf4ff;
}

.text-primary {
    color: #4e73df !important;
}

.border-bottom-faded {
    border-bottom: 1px solid #f8fafc;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 5px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}

.btn-white:hover {
    background: #f8fafc;
    transform: translateY(-2px);
    transition: 0.2s;
}
</style>
@endsection