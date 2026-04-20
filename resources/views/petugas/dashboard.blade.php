@extends('layouts.petugas')

@section('content')
<div style="font-family: 'Inter', sans-serif;">

    <!-- HEADER -->
    <div style="margin-bottom: 25px;">
        <h4 style="font-weight: 800; color: #e5e7eb; margin: 0;">
            👋 Selamat Datang, Petugas!
        </h4>
        <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 5px;">
            Ringkasan operasional hari ini —
            <span style="font-weight: 600; color: #60a5fa;">
                {{ now()->format('d M Y') }}
            </span>
        </p>
    </div>

    <!-- CARD GRID -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit,minmax(250px,1fr)); gap: 20px;">

        <!-- CARD -->
        <div class="card-dark">
            <i class="fas fa-clipboard-check bg-icon"></i>
            <div class="label">Antrean Approval</div>
            <div class="value">{{ $perlu_approval }}</div>
            <a href="{{ route('petugas.peminjaman.index') }}" class="btn-dark">
                Lihat Antrean <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="card-dark green">
            <i class="fas fa-hand-holding bg-icon"></i>
            <div class="label">Sedang Dipinjam</div>
            <div class="value">{{ $sedang_dipinjam }}</div>
            <a href="{{ route('petugas.pengembalian.index') }}" class="btn-dark">
                Validasi Kembali <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="card-dark yellow">
            <i class="fas fa-clock bg-icon"></i>
            <div class="label">Jatuh Tempo</div>
            <div class="value">{{ $kembali_hari_ini }}</div>
            <span class="note">
                <i class="fas fa-exclamation-circle"></i> Segera cek pengembalian
            </span>
        </div>

        <div class="card-dark cyan">
            <i class="fas fa-boxes bg-icon"></i>
            <div class="label">Inventaris Siap</div>
            <div class="value">{{ $total_alat }}</div>
            <a href="{{ route('petugas.alat.index') }}" class="btn-dark">
                Cek Inventaris <i class="fas fa-arrow-right"></i>
            </a>
        </div>

    </div>

    <!-- AKTIVITAS -->
    <div class="table-dark">

        <div class="table-header">
            <h6><i class="fas fa-bolt"></i> Aktivitas Terbaru</h6>
            <span>{{ count($recent_activities) }} Aktivitas</span>
        </div>

        <table>
            <tbody>
                @forelse($recent_activities as $ra)
                <tr>
                    <td>
                        <div class="user-info">
                            <div class="avatar">
                                {{ substr($ra->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="name">{{ $ra->user->name }}</div>
                                <div class="kode">
                                    Peminjaman:
                                    <b>#{{ $ra->kode_peminjaman }}</b>
                                </div>
                            </div>
                        </div>

                        <div class="items">
                            @foreach($ra->detailPeminjaman as $detail)
                            <span>
                                <i class="fas fa-cube"></i>
                                {{ $detail->alat->nama_alat }} ({{ $detail->jumlah }})
                            </span>
                            @endforeach
                        </div>
                    </td>

                    <td class="status">
                        @php
                        $status_bg = $ra->status == 'menunggu' ? '#78350f' : ($ra->status == 'disetujui' ? '#064e3b' :
                        '#7f1d1d');
                        @endphp
                        <span style="background: {{ $status_bg }}">
                            {{ $ra->status }}
                        </span>
                    </td>

                    <td class="time">
                        {{ $ra->created_at->diffForHumans() }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align:center; padding:50px; color:#64748b;">
                        <i class="fas fa-folder-open" style="font-size:40px;"></i>
                        <p>Belum ada aktivitas hari ini</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- STYLE -->
<style>
.card-dark {
    position: relative;
    padding: 25px;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.card-dark .label {
    font-size: 12px;
    color: #60a5fa;
    font-weight: 700;
    text-transform: uppercase;
}

.card-dark .value {
    font-size: 32px;
    font-weight: 800;
    margin: 10px 0;
}

.card-dark .btn-dark {
    display: inline-block;
    font-size: 12px;
    background: rgba(59, 130, 246, 0.2);
    color: #60a5fa;
    padding: 6px 15px;
    border-radius: 8px;
    font-weight: 700;
}

.card-dark .note {
    font-size: 12px;
    color: #fbbf24;
}

.bg-icon {
    position: absolute;
    right: 10px;
    top: 10px;
    font-size: 60px;
    opacity: 0.05;
}

/* TABLE */
.table-dark {
    margin-top: 25px;
    border-radius: 16px;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.table-header {
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.table-header h6 {
    margin: 0;
    color: #e5e7eb;
}

.table-header span {
    font-size: 12px;
    background: rgba(255, 255, 255, 0.05);
    padding: 5px 10px;
    border-radius: 8px;
}

table {
    width: 100%;
}

tr {
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

td {
    padding: 15px 20px;
}

.user-info {
    display: flex;
    align-items: center;
}

.avatar {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
}

.name {
    font-weight: 700;
}

.kode {
    font-size: 12px;
    color: #94a3b8;
}

.items span {
    display: inline-block;
    font-size: 11px;
    background: rgba(255, 255, 255, 0.05);
    padding: 4px 10px;
    border-radius: 6px;
    margin-top: 5px;
    margin-right: 5px;
}

.status span {
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}

.time {
    font-size: 12px;
    color: #64748b;
}
</style>
@endsection