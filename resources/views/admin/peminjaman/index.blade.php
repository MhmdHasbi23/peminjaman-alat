@extends('layouts.admin')

@section('content')

<div class="container-fluid main-wrapper">

    {{-- HEADER --}}
    <div class="header-section">
        <div>
            <h4 class="title">
                <i class="fas fa-chart-line me-2"></i>
                Monitoring Transaksi
            </h4>
            <p class="subtitle">
                Pantau aktivitas peminjaman alat secara real-time
            </p>
        </div>

        <div class="header-right">
            <span class="badge-time">
                <i class="fas fa-clock me-1"></i> {{ now()->format('H:i') }} WIB
            </span>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card-modern">
        <div class="table-responsive">

            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Kode & Peminjam</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Petugas</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($peminjamans as $p)
                    <tr>

                        {{-- KODE --}}
                        <td>
                            <div class="kode-box">
                                <div class="icon-box">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <div class="kode">
                                        #{{ $p->kode_peminjaman }}
                                    </div>
                                    <div class="user">
                                        {{ $p->user->name ?? 'Guest' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- STATUS --}}
                        <td>
                            @php
                            $status = [
                                'menunggu' => ['bg'=>'rgba(250,204,21,0.15)','text'=>'#facc15','label'=>'Pending'],
                                'disetujui' => ['bg'=>'rgba(96,165,250,0.15)','text'=>'#60a5fa','label'=>'Dipinjam'],
                                'selesai' => ['bg'=>'rgba(52,211,153,0.15)','text'=>'#34d399','label'=>'Selesai'],
                                'ditolak' => ['bg'=>'rgba(248,113,113,0.15)','text'=>'#f87171','label'=>'Ditolak'],
                            ];
                            $s = $status[$p->status] ?? ['bg'=>'rgba(148,163,184,0.15)','text'=>'#94a3b8','label'=>$p->status];
                            @endphp

                            <span class="status-badge"
                                style="background:{{ $s['bg'] }}; color:{{ $s['text'] }}">
                                ● {{ $s['label'] }}
                            </span>
                        </td>

                        {{-- TANGGAL --}}
                        <td>
                            <div class="tanggal">
                                <i class="far fa-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') }}
                            </div>
                        </td>

                        {{-- PETUGAS --}}
                        <td>
                            <span class="petugas">
                                {{ $p->petugas->name ?? '-' }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td>
                            <div class="action-group">

                                <a href="{{ route('admin.peminjaman.show',$p->id) }}"
                                    class="btn-action view">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <form action="{{ route('admin.peminjaman.destroy',$p->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn-action delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty">
                            <i class="fas fa-inbox"></i>
                            <p>Tidak ada transaksi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="pagination-wrap">
        <small>
            {{ $peminjamans->total() }} data
        </small>
        {{ $peminjamans->links() }}
    </div>

</div>

{{-- STYLE --}}
<style>

/* WRAPPER */
.main-wrapper {
    padding: 25px;
}

/* HEADER */
.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.title {
    font-weight: 700;
    color: #e2e8f0;
}

.subtitle {
    font-size: 13px;
    color: #94a3b8;
}

/* TIME BADGE */
.badge-time {
    background: rgba(59,130,246,0.15);
    color: #93c5fd;
    padding: 8px 14px;
    border-radius: 10px;
    font-size: 12px;
}

/* CARD */
.card-modern {
    background: rgba(255,255,255,0.04);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.05);
    backdrop-filter: blur(12px);
}

/* TABLE */
.table-modern {
    width: 100%;
    border-collapse: collapse;
}

.table-modern th {
    padding: 15px;
    font-size: 11px;
    color: #94a3b8;
    text-transform: uppercase;
}

.table-modern td {
    padding: 15px;
    border-top: 1px solid rgba(255,255,255,0.05);
    color: #e2e8f0;
}

.table-modern tr:hover {
    background: rgba(255,255,255,0.03);
}

/* KODE */
.kode-box {
    display: flex;
    align-items: center;
    gap: 12px;
}

.icon-box {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: rgba(59,130,246,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #93c5fd;
}

.kode {
    font-weight: 600;
}

.user {
    font-size: 12px;
    color: #94a3b8;
}

/* STATUS */
.status-badge {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}

/* TANGGAL */
.tanggal {
    font-size: 13px;
    color: #cbd5f5;
}

/* PETUGAS */
.petugas {
    font-size: 13px;
    color: #cbd5f5;
}

/* ACTION */
.action-group {
    display: flex;
    justify-content: center;
    gap: 8px;
}

.btn-action {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
}

.btn-action.view {
    background: rgba(59,130,246,0.15);
    color: #93c5fd;
}

.btn-action.delete {
    background: rgba(248,113,113,0.15);
    color: #f87171;
}

.btn-action:hover {
    transform: scale(1.1);
}

/* EMPTY */
.empty {
    text-align: center;
    padding: 50px;
    color: #94a3b8;
}

.empty i {
    font-size: 28px;
    margin-bottom: 10px;
}

/* PAGINATION */
.pagination-wrap {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    color: #94a3b8;
}

</style>

@endsection