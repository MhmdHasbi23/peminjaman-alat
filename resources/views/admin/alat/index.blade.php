@extends('layouts.admin')

@section('content')
<div class="container-fluid main-wrapper">

    {{-- HEADER --}}
    <div class="header-section">
        <div>
            <h4 class="title">
                📦 Inventaris Alat
            </h4>
            <p class="subtitle">
                Kelola stok dan ketersediaan alat secara real-time
            </p>
        </div>

        <a href="{{ route('admin.alat.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Tambah Alat
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert-modern">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- CARD TABLE --}}
    <div class="card-modern">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Detail Alat</th>
                        <th>Kategori</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($alats as $alat)
                    <tr>
                        <td>
                            {{ ($alats->currentPage() - 1) * $alats->perPage() + $loop->iteration }}
                        </td>

                        <td>
                            <div class="alat-info">
                                <div class="icon-box">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div>
                                    <div class="nama">
                                        {{ $alat->nama_alat }}
                                    </div>
                                    <div class="desc">
                                        {{ Str::limit($alat->spesifikasi, 60) }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="badge-kategori">
                                {{ $alat->kategori->nama_kategori }}
                            </span>
                        </td>

                        <td class="text-center">
                            @php $danger = $alat->stok < 5; @endphp
                            <span class="stok {{ $danger ? 'danger' : '' }}">
                                {{ $alat->stok }}
                            </span>
                        </td>

                        <td>
                            <div class="action-group">

                                <a href="{{ route('admin.alat.edit', $alat->id) }}" class="btn-action edit">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form id="delete-form-{{ $alat->id }}" method="POST"
                                    action="{{ route('admin.alat.destroy', $alat->id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        onclick="confirmDelete('{{ $alat->id }}','{{ $alat->nama_alat }}')"
                                        class="btn-action delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty">
                            <i class="fas fa-box-open"></i>
                            <p>Belum ada data alat</p>
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
            {{ $alats->firstItem() ?? 0 }} - {{ $alats->lastItem() ?? 0 }} dari {{ $alats->total() }}
        </small>

        {{ $alats->links() }}
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

/* BUTTON */
.btn-add {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    padding: 10px 18px;
    border-radius: 10px;
    color: white;
    font-size: 13px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: 0.3s;
}

.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(59,130,246,0.3);
}

/* ALERT */
.alert-modern {
    background: rgba(34,197,94,0.15);
    border: 1px solid rgba(34,197,94,0.3);
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 15px;
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

/* INFO */
.alat-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.icon-box {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(59,130,246,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #93c5fd;
}

/* TEXT */
.nama {
    font-weight: 600;
}

.desc {
    font-size: 12px;
    color: #94a3b8;
}

/* BADGE */
.badge-kategori {
    background: rgba(255,255,255,0.08);
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
}

/* STOK */
.stok {
    padding: 6px 12px;
    border-radius: 8px;
    background: rgba(59,130,246,0.15);
    font-weight: 600;
}

.stok.danger {
    background: rgba(248,113,113,0.2);
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

.btn-action.edit {
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
    font-size: 30px;
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