@extends('layouts.peminjam')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', 'Segoe UI', sans-serif;">

    <div class="mb-4">
        <h4 style="font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -0.5px;">📜 Riwayat Peminjaman Saya</h4>
        <p style="color: #64748b; font-size: 0.95rem; margin-top: 5px;">Pantau status pengajuan, riwayat denda, dan
            jadwal pengembalian alat Anda secara transparan.</p>
    </div>

    <div
        style="background: white; border-radius: 20px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; overflow: hidden;">
        <div class="table-responsive">
            <table class="table mb-0"
                style="width: 100%; border-collapse: separate; border-spacing: 0; vertical-align: middle;">
                <thead>
                    <tr style="background-color: #f8fafc;">
                        <th
                            style="padding: 20px; text-align: left; color: #475569; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #edf2f7;">
                            Kode & Periode</th>
                        <th
                            style="padding: 20px; text-align: left; color: #475569; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #edf2f7;">
                            Alat yang Dipinjam</th>
                        <th
                            style="padding: 20px; text-align: center; color: #475569; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #edf2f7;">
                            Status</th>
                        <th
                            style="padding: 20px; text-align: right; color: #475569; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #edf2f7;">
                            Biaya Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $r)
                    <tr style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#fcfdfe'"
                        onmouseout="this.style.backgroundColor='transparent'">
                        <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                            <span
                                style="display: block; font-family: 'JetBrains Mono', monospace; font-size: 14px; font-weight: 800; color: #4e73df; margin-bottom: 6px;">#{{ $r->kode_peminjaman }}</span>
                            <div style="font-size: 12px; color: #64748b;">
                                <i class="far fa-calendar-alt me-1"></i> Pinjam: <span
                                    style="font-weight: 600; color: #1e293b;">{{ \Carbon\Carbon::parse($r->tgl_pinjam)->format('d M Y') }}</span>
                            </div>
                            <div style="font-size: 12px; color: #e11d48; margin-top: 2px;">
                                <i class="far fa-clock me-1"></i> Kembali: <span
                                    style="font-weight: 600;">{{ \Carbon\Carbon::parse($r->tgl_kembali_rencana)->format('d M Y') }}</span>
                            </div>
                        </td>
                        <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                            @foreach($r->detailPeminjaman as $detail)
                            <div
                                style="font-size: 13px; color: #475569; margin-bottom: 4px; display: flex; align-items: center;">
                                <div
                                    style="width: 4px; height: 4px; background: #cbd5e1; border-radius: 50%; margin-right: 10px;">
                                </div>
                                {{ $detail->alat->nama_alat }}
                                <span
                                    style="font-weight: 800; color: #4e73df; font-size: 11px; margin-left: 8px;">({{ $detail->jumlah }}x)</span>
                            </div>
                            @endforeach
                        </td>
                        <td style="padding: 20px; text-align: center; border-bottom: 1px solid #f1f5f9;">
                            @php
                            $statusStyle = match($r->status) {
                            'menunggu' => ['bg' => '#fef3c7', 'text' => '#92400e', 'icon' => 'fa-hourglass-half'],
                            'disetujui' => ['bg' => '#dcfce7', 'text' => '#166534', 'icon' => 'fa-check-circle'],
                            'selesai' => ['bg' => '#e0e7ff', 'text' => '#3730a3', 'icon' => 'fa-history'],
                            'ditolak' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'icon' => 'fa-times-circle'],
                            default => ['bg' => '#f1f5f9', 'text' => '#475569', 'icon' => 'fa-info-circle']
                            };
                            @endphp
                            <span
                                style="background: {{ $statusStyle['bg'] }}; color: {{ $statusStyle['text'] }}; padding: 6px 14px; border-radius: 10px; font-size: 10px; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; letter-spacing: 0.5px;">
                                <i class="fas {{ $statusStyle['icon'] }} me-2"></i> {{ $r->status }}
                            </span>
                        </td>
                        <td style="padding: 20px; text-align: right; border-bottom: 1px solid #f1f5f9;">
                            <div
                                style="font-weight: 800; color: {{ $r->denda > 0 ? '#e11d48' : '#10b981' }}; font-size: 15px;">
                                Rp {{ number_format($r->denda, 0, ',', '.') }}
                            </div>
                            @if($r->denda > 0)
                            <small style="color: #94a3b8; font-size: 10px; font-weight: 600;">Terhitung Denda</small>
                            @else
                            <small style="color: #94a3b8; font-size: 10px; font-weight: 600;">Bebas Denda</small>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 80px; text-align: center;">
                            <div
                                style="background: #f8fafc; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                <i class="fas fa-history" style="font-size: 40px; color: #cbd5e1;"></i>
                            </div>
                            <h6 style="color: #1e293b; font-weight: 800; margin-bottom: 8px;">Belum Ada Riwayat</h6>
                            <p style="color: #94a3b8; font-size: 14px; font-weight: 500;">Anda belum pernah melakukan
                                peminjaman alat sebelumnya.</p>
                            <a href="{{ route('peminjam.alat.index') }}" class="btn btn-primary"
                                style="border-radius: 10px; font-weight: 700; padding: 10px 25px; margin-top: 15px;">Pinjam
                                Alat Sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Custom Scrollbar for responsiveness */
.table-responsive::-webkit-scrollbar {
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}
</style>
@endsection