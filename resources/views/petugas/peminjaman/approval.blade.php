@extends('layouts.petugas')

@section('content')
<div style="font-family: 'Inter', sans-serif;">

    <!-- HEADER -->
    <div style="margin-bottom: 20px;">
        <h4 style="font-weight: 800; color: #e5e7eb;">
            <i class="fas fa-bell" style="color:#fbbf24;"></i> Persetujuan Peminjaman
        </h4>
        <p style="color: #94a3b8; font-size: 0.9rem;">
            Tinjau dan proses permintaan peminjaman alat
        </p>
    </div>

    <!-- BADGE -->
    <div style="margin-bottom: 20px;">
        <span class="badge-dark">
            {{ count($peminjamans) }} Antrean Menunggu
        </span>
    </div>

    <!-- TABLE -->
    <div class="table-dark">
        <table>

            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Daftar Alat</th>
                    <th>Periode</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($peminjamans as $p)
                <tr>

                    <!-- USER -->
                    <td>
                        <div class="user-box">
                            <div class="avatar">
                                {{ strtoupper(substr($p->user->name, 0, 1)) }}
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
                            <span>{{ $detail->alat->nama_alat }}</span>
                            <b>x{{ $detail->jumlah }}</b>
                        </div>
                        @endforeach
                    </td>

                    <!-- TANGGAL -->
                    <td>
                        <div class="tanggal">
                            Mulai: {{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') }}
                        </div>
                        <div class="tanggal merah">
                            Kembali: {{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d M Y') }}
                        </div>
                    </td>

                    <!-- AKSI -->
                    <td class="center">
                        <div class="aksi">

                            <form action="{{ route('petugas.peminjaman.setujui', $p->id) }}" method="POST"
                                class="form-setujui">
                                @csrf
                                <button class="btn-green">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                            </form>

                            <form action="{{ route('petugas.peminjaman.tolak', $p->id) }}" method="POST"
                                class="form-tolak">
                                @csrf
                                <button class="btn-red">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:60px;">
                        <i class="fas fa-clipboard-check" style="font-size:40px; color:#64748b;"></i>
                        <p style="color:#94a3b8;">Tidak ada antrean</p>
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
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
.user-box {
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
    font-size: 12px;
    color: #94a3b8;
}

.merah {
    color: #f87171;
}

/* BUTTON */
.aksi {
    display: flex;
    gap: 10px;
    justify-content: center;
}

button {
    border: none;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
}

.btn-green {
    background: #065f46;
    color: white;
}

.btn-red {
    background: #7f1d1d;
    color: white;
}

button:hover {
    transform: translateY(-2px);
    filter: brightness(1.2);
}

/* BADGE */
.badge-dark {
    background: rgba(251, 191, 36, 0.1);
    color: #fbbf24;
    padding: 8px 15px;
    border-radius: 10px;
    font-weight: 700;
}
</style>
@endsection