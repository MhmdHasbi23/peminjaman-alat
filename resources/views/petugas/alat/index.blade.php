@extends('layouts.petugas')

@section('content')
<div style="font-family: 'Inter', sans-serif;">

    <!-- HEADER -->
    <div style="margin-bottom: 25px;">
        <h4 style="font-weight: 800; color: #e5e7eb; margin: 0;">
            <i class="fas fa-boxes" style="color:#60a5fa;"></i> Inventaris Alat
        </h4>
        <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 5px;">
            Manajemen stok barang gudang secara real-time
        </p>
    </div>

    <!-- CARD TABLE -->
    <div class="table-dark">

        <div class="table-header">
            <span>Data Inventaris</span>
            <span class="badge-dark">{{ count($alats) }} Item</span>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Informasi Alat</th>
                        <th>Kategori</th>
                        <th style="text-align:center;">Stok</th>
                        <th style="text-align:center;">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($alats as $a)
                    <tr>

                        <!-- INFO -->
                        <td>
                            <div class="nama">{{ $a->nama_alat }}</div>
                            <div class="desc">
                                {{ Str::limit($a->spesifikasi, 80) }}
                            </div>
                        </td>

                        <!-- KATEGORI -->
                        <td>
                            <span class="badge">
                                {{ $a->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </td>

                        <!-- STOK -->
                        <td class="center">
                            <div class="stok">{{ $a->stok }}</div>
                            <small>Unit</small>
                        </td>

                        <!-- STATUS -->
                        <td class="center">
                            @if($a->stok > 10)
                            <span class="status aman">AMAN</span>
                            @elseif($a->stok > 0)
                            <span class="status terbatas">TERBATAS</span>
                            @else
                            <span class="status kosong">KOSONG</span>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center; padding:60px;">
                            <i class="fas fa-box-open" style="font-size:40px; color:#64748b;"></i>
                            <p style="color:#94a3b8;">Data inventaris kosong</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- FOOTER -->
    <div style="margin-top:15px; color:#64748b; font-size:13px;">
        Menampilkan <b style="color:#e5e7eb;">{{ count($alats) }}</b> alat tersedia
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

/* HEADER */
.table-header {
    display: flex;
    justify-content: space-between;
    padding: 15px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    color: #e5e7eb;
    font-weight: 700;
}

.badge-dark {
    background: rgba(255, 255, 255, 0.05);
    padding: 5px 10px;
    border-radius: 8px;
    font-size: 12px;
}

/* TABLE */
table {
    width: 100%;
}

th {
    text-align: left;
    padding: 15px 20px;
    font-size: 11px;
    text-transform: uppercase;
    color: #64748b;
}

td {
    padding: 15px 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
}

tr:hover {
    background: rgba(255, 255, 255, 0.03);
}

/* TEXT */
.nama {
    font-weight: 700;
    color: #e5e7eb;
}

.desc {
    font-size: 12px;
    color: #94a3b8;
}

/* BADGE */
.badge {
    background: rgba(255, 255, 255, 0.05);
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 12px;
}

/* STOK */
.center {
    text-align: center;
}

.stok {
    font-size: 20px;
    font-weight: 800;
}

/* STATUS */
.status {
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 800;
}

.aman {
    background: #064e3b;
}

.terbatas {
    background: #78350f;
}

.kosong {
    background: #7f1d1d;
}

/* SCROLL */
.table-responsive::-webkit-scrollbar {
    height: 6px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
}
</style>
@endsection