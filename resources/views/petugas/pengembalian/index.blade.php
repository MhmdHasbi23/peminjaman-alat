@extends('layouts.petugas')

@section('content')
<div style="font-family: 'Inter', sans-serif;">

    <!-- HEADER -->
    <div style="margin-bottom: 20px;">
        <h4 style="font-weight: 800; color: #e5e7eb;">
            🔄 Validasi Pengembalian
        </h4>
        <p style="color: #94a3b8; font-size: 0.9rem;">
            Proses pengembalian alat dan verifikasi denda keterlambatan
        </p>
    </div>

    <!-- ALERT -->
    @if(session('success'))
    <div class="alert-dark success">
        {{ session('success') }}
    </div>
    @endif

    <!-- TABLE -->
    <div class="table-dark">

        <table>
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Daftar Alat</th>
                    <th>Batas Kembali</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($peminjamans as $p)
                <tr>

                    <!-- USER -->
                    <td>
                        <div class="user">
                            <div class="avatar">
                                {{ strtoupper(substr($p->user->name,0,1)) }}
                            </div>
                            <div>
                                <div class="name">{{ $p->user->name }}</div>
                                <div class="kode">{{ $p->kode_peminjaman }}</div>
                            </div>
                        </div>
                    </td>

                    <!-- ALAT -->
                    <td>
                        @foreach($p->detailPeminjaman as $detail)
                        <div class="alat-item">
                            <span>{{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}</span>
                            <b>{{ $detail->jumlah }} unit</b>
                        </div>
                        @endforeach
                    </td>

                    <!-- TANGGAL -->
                    <td>
                        @php
                        $terlambat = \Carbon\Carbon::parse($p->tgl_kembali_rencana)->isPast();
                        @endphp

                        <div class="tanggal {{ $terlambat ? 'merah' : '' }}">
                            {{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d M Y') }}
                        </div>

                        @if($terlambat)
                        <span class="badge-terlambat">TERLAMBAT</span>
                        @endif
                    </td>

                    <!-- AKSI -->
                    <td class="center">
                        <a href="{{ route('petugas.pengembalian.cek', $p->id) }}" class="btn-aksi">
                            <i class="fas fa-calculator"></i> Proses
                        </a>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:60px;">
                        <i class="fas fa-box-open" style="font-size:40px; color:#64748b;"></i>
                        <p style="color:#94a3b8;">Tidak ada alat dipinjam</p>
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <!-- PAGINATION -->
    <div style="margin-top:20px;">
        {{ $peminjamans->links() }}
    </div>

</div>

<!-- STYLE -->
<style>
.table-dark {
    background: rgba(255, 255, 255, 0.03);
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

/* TABLE */
table {
    width: 100%;
}

th {
    padding: 15px;
    text-align: left;
    font-size: 11px;
    color: #64748b;
    text-transform: uppercase;
}

td {
    padding: 15px;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
}

tr:hover {
    background: rgba(255, 255, 255, 0.03);
}

/* USER */
.user {
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
    color: #e5e7eb;
}

.kode {
    font-size: 12px;
    color: #60a5fa;
}

/* ALAT */
.alat-item {
    display: flex;
    justify-content: space-between;
    background: rgba(255, 255, 255, 0.05);
    padding: 5px 10px;
    border-radius: 8px;
    margin-bottom: 5px;
    font-size: 12px;
}

/* TANGGAL */
.tanggal {
    font-size: 13px;
    color: #94a3b8;
}

.merah {
    color: #f87171;
    font-weight: 700;
}

/* BADGE */
.badge-terlambat {
    background: #7f1d1d;
    color: white;
    font-size: 10px;
    padding: 3px 8px;
    border-radius: 6px;
    font-weight: 700;
}

/* BUTTON */
.center {
    text-align: center;
}

.btn-aksi {
    background: #1e3a8a;
    color: white;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
}

.btn-aksi:hover {
    transform: translateY(-2px);
    filter: brightness(1.2);
}

/* ALERT */
.alert-dark {
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.success {
    background: #064e3b;
    color: #6ee7b7;
}
</style>
@endsection