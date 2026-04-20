@extends('layouts.peminjam')

@section('content')
<div class="container-fluid px-4" style="margin-top:25px; font-family:'Inter',sans-serif;">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 style="font-weight:800; color:#e2e8f0;">
            👋 Halo, {{ auth()->user()->name }}!
        </h4>
        <p style="color:#94a3b8; font-size:13px;">
            Mau pinjam alat apa hari ini? Pastikan untuk menjaga barang dengan baik ya.
        </p>
    </div>

    {{-- STAT CARD --}}
    <div class="grid-stat">

        <div class="card-stat blue">
            <div class="label">Alat Tersedia</div>
            <div class="value">{{ $total_alat }}</div>
            <i class="fas fa-boxes-stacked icon"></i>
        </div>

        <div class="card-stat yellow">
            <div class="label">Menunggu Approval</div>
            <div class="value">{{ $pinjam_pending }}</div>
            <i class="fas fa-clock-rotate-left icon"></i>
        </div>

        <div class="card-stat green">
            <div class="label">Sedang Dipinjam</div>
            <div class="value">{{ $pinjam_aktif }}</div>
            <i class="fas fa-hand-holding-box icon"></i>
        </div>

    </div>

    <div class="row mt-4">

        {{-- RIWAYAT --}}
        <div class="col-12 mb-4">

            <div class="glass-card-table">

                <div class="card-header-flex">

                    <div>
                        <h6 class="title">📜 Riwayat Peminjaman</h6>
                        <small class="subtitle">Aktivitas terbaru peminjaman alat</small>
                    </div>

                    <a href="{{ route('peminjam.riwayat') }}" class="link-btn">
                        Lihat Semua →
                    </a>

                </div>

                <div class="table-responsive mt-3">

                    <table class="custom-table">

                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Alat</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Tanggal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($recent_orders as $order)
                            <tr class="row-hover">

                                <td class="kode">
                                    #{{ $order->kode_peminjaman }}
                                </td>

                                <td>
                                    <div class="alat-wrapper">
                                        @foreach($order->detailPeminjaman as $d)
                                        <span class="badge-item">
                                            {{ $d->alat->nama_alat }}
                                        </span>
                                        @endforeach
                                    </div>
                                </td>

                                <td class="text-center">
                                    @php
                                    $statusClass = [
                                        'menunggu' => 'warning',
                                        'disetujui' => 'success',
                                        'ditolak' => 'danger',
                                        'selesai' => 'secondary'
                                    ];
                                    @endphp

                                    <span class="badge-status {{ $statusClass[$order->status] ?? 'secondary' }}">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>

                                <td class="text-end date-text">
                                    {{ \Carbon\Carbon::parse($order->tgl_pinjam)->format('d M Y') }}
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    Belum ada transaksi peminjaman.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- ================= FULL WIDTH CTA CARD ================= --}}
        <div class="col-12">

            <div class="card-action">

                <i class="fas fa-plus-circle icon-big"></i>

                <h5>Butuh Alat?</h5>

                <p>
                    Klik tombol di bawah untuk melihat katalog dan mulai meminjam alat yang kamu butuhkan.
                </p>

                <a href="{{ route('peminjam.alat.index') }}" class="btn-action">
                    Mulai Pinjam Sekarang
                </a>

            </div>

        </div>

    </div>
</div>

<style>

/* GRID */
.grid-stat {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}

.card-stat {
    background: rgba(255,255,255,0.04);
    border-radius: 16px;
    padding: 20px;
    position: relative;
    border: 1px solid rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
}

.card-stat .label {
    font-size: 11px;
    text-transform: uppercase;
    color: #94a3b8;
    font-weight: 600;
}

.card-stat .value {
    font-size: 26px;
    font-weight: 800;
    color: #e2e8f0;
    margin-top: 10px;
}

.card-stat .icon {
    position: absolute;
    right: 20px;
    top: 25px;
    font-size: 28px;
    opacity: 0.15;
}

/* RIWAYAT */
.glass-card-table {
    background: rgba(255,255,255,0.04);
    border-radius: 16px;
    padding: 20px;
    border: 1px solid rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
}

.card-header-flex {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
}

.title {
    font-weight: 700;
    color: #e2e8f0;
}

.subtitle {
    color: #94a3b8;
    font-size: 12px;
}

.link-btn {
    font-size: 12px;
    color: #60a5fa;
    text-decoration: none;
}

/* TABLE */
.custom-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
}

.custom-table thead th {
    font-size: 11px;
    text-transform: uppercase;
    color: #64748b;
    padding: 10px;
}

.custom-table tbody tr {
    background: rgba(255,255,255,0.03);
    transition: 0.2s;
}

.row-hover:hover {
    background: rgba(59,130,246,0.08);
    transform: scale(1.01);
}

.custom-table td {
    padding: 12px 10px;
    color: #cbd5e1;
}

/* BADGE */
.badge-item {
    background: rgba(255,255,255,0.06);
    padding: 5px 10px;
    border-radius: 8px;
    font-size: 11px;
}

/* STATUS */
.badge-status {
    font-size: 11px;
    padding: 5px 10px;
    border-radius: 999px;
    font-weight: 600;
}

.badge-status.warning { background: rgba(250,204,21,0.15); color: #facc15; }
.badge-status.success { background: rgba(34,197,94,0.15); color: #22c55e; }
.badge-status.danger { background: rgba(239,68,68,0.15); color: #ef4444; }
.badge-status.secondary { background: rgba(100,116,139,0.15); color: #94a3b8; }

/* EMPTY */
.empty-state {
    text-align: center;
    padding: 20px;
    color: #64748b;
}

/* DATE */
.date-text {
    color: #94a3b8;
    font-size: 13px;
}

/* FULL WIDTH CTA CARD */
.card-action {
    width: 100%;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border-radius: 16px;
    padding: 35px 25px;
    color: white;
    box-shadow: 0 10px 25px rgba(59,130,246,0.3);

    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.card-action h5 {
    margin-top: 10px;
    font-weight: 700;
}

.card-action p {
    max-width: 500px;
    font-size: 13px;
    line-height: 1.6;
    opacity: 0.9;
}

.icon-big {
    font-size: 40px;
}

.btn-action {
    display: inline-block;
    background: white;
    color: #3b82f6;
    padding: 10px 18px;
    border-radius: 10px;
    font-weight: 700;
    text-decoration: none;
    margin-top: 12px;
}

.btn-action:hover {
    background: #e0f2fe;
}

</style>

@endsection