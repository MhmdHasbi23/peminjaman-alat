@extends('layouts.peminjam')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', 'Segoe UI', sans-serif;">

    <div class="mb-4">
        <h4 style="font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -0.5px;">↩️ Pengembalian Alat</h4>
        <p style="color: #64748b; font-size: 0.95rem; margin-top: 5px;">Silakan bawa alat-alat di bawah ini ke petugas
            gudang untuk proses pengembalian.</p>
    </div>

    <div class="row">
        @forelse($pinjamanAktif as $p)
        <div class="col-lg-6 mb-4">
            <div
                style="background: white; border-radius: 20px; border: 1px solid #e2e8f0; padding: 25px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.04); position: relative; overflow: hidden;">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span
                        style="background: #ecfdf5; color: #059669; padding: 6px 14px; border-radius: 10px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center;">
                        <span
                            style="width: 6px; height: 6px; background: #10b981; border-radius: 50%; margin-right: 8px;"></span>
                        Sedang Dipinjam
                    </span>
                    <span
                        style="font-family: 'JetBrains Mono', monospace; font-size: 13px; font-weight: 700; color: #4e73df;">#{{ $p->kode_peminjaman }}</span>
                </div>

                <div class="row align-items-center">
                    <div class="col-sm-7">
                        <h6
                            style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">
                            Item yang harus kembali:</h6>

                        <div
                            style="background: #f8fafc; border-radius: 12px; padding: 15px; border: 1px solid #f1f5f9;">
                            @foreach($p->detailPeminjaman as $detail)
                            <div class="d-flex align-items-center mb-2"
                                style="font-size: 14px; color: #334155; font-weight: 600;">
                                <i class="fas fa-cube text-primary me-2" style="font-size: 10px; opacity: 0.6;"></i>
                                {{ $detail->alat->nama_alat }}
                                <span class="ms-auto badge bg-white border text-primary"
                                    style="font-weight: 800;">{{ $detail->jumlah }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-sm-5 mt-3 mt-sm-0 text-center text-sm-end">
                        <div
                            style="padding: 10px; border-radius: 15px; background: #fff1f2; border: 1px solid #fecdd3;">
                            <div style="font-size: 10px; font-weight: 800; color: #e11d48; text-transform: uppercase;">
                                Batas Kembali</div>
                            <div style="font-size: 1.1rem; font-weight: 800; color: #1e293b; margin: 2px 0;">
                                {{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d M Y') }}
                            </div>
                            @php
                            $isLate = \Carbon\Carbon::parse($p->tgl_kembali_rencana)->isPast();
                            @endphp
                            @if($isLate)
                            <span style="font-size: 10px; color: #e11d48; font-weight: 700;"><i
                                    class="fas fa-exclamation-circle me-1"></i> Terlambat!</span>
                            @else
                            <span style="font-size: 10px; color: #64748b; font-weight: 600;">Sisa
                                {{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->diffForHumans(null, true) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <hr style="border-top: 1px dashed #e2e8f0; margin: 20px 0;">

                <div class="d-flex align-items-center"
                    style="background: #f1f5f9; padding: 12px 18px; border-radius: 12px;">
                    <i class="fas fa-info-circle text-primary me-3"></i>
                    <p style="margin: 0; font-size: 12px; color: #475569; font-weight: 600; line-height: 1.4;">
                        Tunjukkan kode transaksi ini ke petugas gudang untuk validasi pengembalian.
                    </p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div
                style="text-align: center; padding: 80px 20px; background: white; border-radius: 20px; border: 2px dashed #e2e8f0;">
                <div style="font-size: 4rem; color: #e2e8f0; margin-bottom: 20px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h5 style="font-weight: 800; color: #1e293b;">Bebas Pinjaman</h5>
                <p style="color: #94a3b8; font-weight: 500; margin-bottom: 25px;">Anda tidak memiliki alat yang perlu
                    dikembalikan saat ini.</p>
                <a href="{{ route('peminjam.alat.index') }}" class="btn btn-primary"
                    style="border-radius: 12px; padding: 12px 30px; font-weight: 700; box-shadow: 0 4px 12px rgba(78, 115, 223, 0.2);">
                    Mulai Pinjam Alat <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
/* Custom scrollbar untuk kenyamanan */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}
</style>
@endsection