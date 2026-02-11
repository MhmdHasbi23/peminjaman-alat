@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: 'Inter', sans-serif;">

    {{-- Welcome Header --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h4 style="font-weight: 800; color: #1a202c; margin: 0; letter-spacing: -0.5px;">
                <i class="fas fa-th-large me-2" style="color: #4e73df;"></i> Dashboard Utama
            </h4>
            <p style="color: #718096; font-size: 0.9rem; margin: 5px 0 0 0;">Halo,
                <strong>{{ auth()->user()->name }}</strong>. Berikut adalah ringkasan sistem hari ini.</p>
        </div>
    </div>
    <div class="row mb-4 align-items-center">
        <div class="col-md-4 text-md-end">
            <span class="badge"
                style="background: white; color: #4e73df; padding: 12px 20px; border-radius: 12px; font-weight: 700; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
                <i class="fas fa-calendar-alt me-2"></i> {{ now()->translatedFormat('d F Y') }}
            </span>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">

        {{-- Total Alat --}}
        <div
            style="background: white; padding: 25px; border-radius: 20px; border-left: 6px solid #4e73df; box-shadow: 0 10px 15px rgba(0,0,0,0.03); position: relative; overflow: hidden;">
            <div style="position: absolute; right: 15px; bottom: 15px; opacity: 0.1; font-size: 50px; color: #4e73df;">
                <i class="fas fa-tools"></i>
            </div>
            <div
                style="font-size: 11px; font-weight: 800; color: #4e73df; text-transform: uppercase; letter-spacing: 1px;">
                Total Inventaris</div>
            <div style="font-size: 28px; font-weight: 800; color: #2d3748; margin-top: 5px;">
                {{ $total_alat }} <span style="font-size: 14px; font-weight: 500; color: #718096;">Alat</span>
            </div>
        </div>

        {{-- Menunggu Persetujuan --}}
        <div
            style="background: white; padding: 25px; border-radius: 20px; border-left: 6px solid #f6c23e; box-shadow: 0 10px 15px rgba(0,0,0,0.03); position: relative; overflow: hidden;">
            <div style="position: absolute; right: 15px; bottom: 15px; opacity: 0.1; font-size: 50px; color: #f6c23e;">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div
                style="font-size: 11px; font-weight: 800; color: #f6c23e; text-transform: uppercase; letter-spacing: 1px;">
                Perlu Persetujuan</div>
            <div style="font-size: 28px; font-weight: 800; color: #2d3748; margin-top: 5px;">
                {{ $pinjam_menunggu }} <span style="font-size: 14px; font-weight: 500; color: #718096;">Data</span>
            </div>
        </div>

        {{-- Sedang Dipinjam --}}
        <div
            style="background: white; padding: 25px; border-radius: 20px; border-left: 6px solid #1cc88a; box-shadow: 0 10px 15px rgba(0,0,0,0.03); position: relative; overflow: hidden;">
            <div style="position: absolute; right: 15px; bottom: 15px; opacity: 0.1; font-size: 50px; color: #1cc88a;">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div
                style="font-size: 11px; font-weight: 800; color: #1cc88a; text-transform: uppercase; letter-spacing: 1px;">
                Sedang Dipinjam</div>
            <div style="font-size: 28px; font-weight: 800; color: #2d3748; margin-top: 5px;">
                {{ $pinjam_aktif }} <span style="font-size: 14px; font-weight: 500; color: #718096;">Transaksi</span>
            </div>
        </div>

        <!-- {{-- Kas Denda --}}
        <div
            style="background: white; padding: 25px; border-radius: 20px; border-left: 6px solid #e74a3b; box-shadow: 0 10px 15px rgba(0,0,0,0.03); position: relative; overflow: hidden;">
            <div style="position: absolute; right: 15px; bottom: 15px; opacity: 0.1; font-size: 50px; color: #e74a3b;">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div
                style="font-size: 11px; font-weight: 800; color: #e74a3b; text-transform: uppercase; letter-spacing: 1px;">
                Total Kas Denda</div>
            <div style="font-size: 24px; font-weight: 800; color: #2d3748; margin-top: 5px;">
                Rp {{ number_format($total_denda, 0, ',', '.') }}
            </div>
        </div> -->
    </div>

    {{-- Main Content Row --}}
    <div class="row">
        {{-- Activity Log --}}
        <div class="col-lg-8 mb-4">
            <div
                style="background: white; border-radius: 20px; padding: 25px; box-shadow: 0 10px 15px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; height: 100%;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 style="font-weight: 800; color: #2d3748; margin: 0; font-size: 16px;">📜 Log Aktivitas Terbaru
                    </h5>
                    <a href="{{ route('admin.log.index') }}"
                        style="font-size: 12px; color: #4e73df; text-decoration: none; font-weight: 700; background: #ebf4ff; padding: 6px 12px; border-radius: 8px;">Lihat
                        Semua</a>
                </div>
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                        @forelse($recent_logs as $log)
                        <tr style="border-bottom: 1px solid #f8fafc;">
                            <td style="padding: 15px 0;">
                                <div style="font-weight: 700; color: #4e73df; font-size: 14px;">
                                    {{ $log->user->name ?? 'System' }}</div>
                                <div style="color: #718096; margin-top: 2px;">{{ $log->deskripsi }}</div>
                            </td>
                            <td style="padding: 15px 0; color: #a0aec0; text-align: right; white-space: nowrap;">
                                <i class="far fa-clock me-1"></i> {{ $log->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" style="text-align: center; padding: 40px; color: #a0aec0;">
                                <img src="https://illustrations.popsy.co/gray/not-found.svg"
                                    style="height: 100px; margin-bottom: 15px; opacity: 0.5; display: block; margin-left: auto; margin-right: auto;">
                                Belum ada aktivitas tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>

        {{-- Sidebar Content --}}
        <div class="col-lg-4 mb-4">
            {{-- Stok Menipis --}}
            <div
                style="background: #fff5f5; border-radius: 20px; padding: 25px; border: 1px solid #feb2b2; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(197, 48, 48, 0.05);">
                <h5 style="font-weight: 800; color: #c53030; margin-bottom: 15px; font-size: 15px;">
                    <i class="fas fa-exclamation-triangle me-2"></i> Stok Menipis (< 5) </h5>
                        <div style="max-height: 300px; overflow-y: auto;">
                            @forelse($stok_menipis as $a)
                            <div
                                style="background: white; padding: 12px 15px; border-radius: 12px; margin-bottom: 10px; border: 1px solid #fed7d7; display: flex; justify-content: space-between; align-items: center;">
                                <span
                                    style="font-weight: 600; color: #2d3748; font-size: 13px;">{{ $a->nama_alat }}</span>
                                <span class="badge bg-danger" style="border-radius: 6px; padding: 6px 10px;">Sisa:
                                    {{ $a->stok }}</span>
                            </div>
                            @empty
                            <div style="text-align: center; opacity: 0.7; padding: 20px; color: #c53030;">
                                <i class="fas fa-check-circle fa-2x mb-2" style="display: block;"></i>
                                <span style="font-size: 13px; font-weight: 600;">Semua stok alat aman.</span>
                            </div>
                            @endforelse
                        </div>
            </div>

            {{-- Info Card --}}
            <div style="background: #ebf4ff; border-radius: 20px; padding: 20px; border: 1px solid #bee3f8;">
                <h6 style="font-weight: 700; color: #2b6cb0; font-size: 14px; margin-bottom: 10px;">
                    <i class="fas fa-lightbulb me-2"></i> Tips Admin
                </h6>
                <p style="font-size: 12px; color: #2c5282; line-height: 1.6; margin: 0;">
                    Lakukan pengecekan berkala pada menu <strong>Log Aktivitas</strong> untuk memantau tindakan petugas
                    dan sirkulasi inventaris sekolah.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection