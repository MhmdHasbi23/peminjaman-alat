@extends('layouts.admin')

@section('content')

<div class="container-fluid main-wrapper">

    {{-- HEADER --}}
    <div class="header-section">
        <div>
            <h4 class="title">
                🏷️ Manajemen Kategori
            </h4>
            <p class="subtitle">
                Kelola kategori alat agar lebih terstruktur
            </p>
        </div>

        <a href="{{ route('admin.kategori.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>

    {{-- TABLE --}}
    <div class="card-modern">
        <div class="table-responsive">

            <table class="table-modern">
                <thead>
                    <tr>
                        <th width="80">No</th>
                        <th>Nama Kategori</th>
                        <th class="text-center" width="160">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($kategoris as $kategori)
                    <tr>
                        <td class="number">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            <div class="kategori-item">
                                <div class="icon-box">
                                    <i class="fas fa-tag"></i>
                                </div>

                                <div class="kategori-text">
                                    {{ $kategori->nama_kategori }}
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="action-group">

                                <a href="{{ route('admin.kategori.edit', $kategori->id) }}"
                                    class="btn-action edit">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('admin.kategori.destroy', $kategori->id) }}"
                                    method="POST" class="form-hapus-kategori">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-action delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="empty">
                            <i class="fas fa-tags"></i>
                            <p>Belum ada kategori</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
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

/* NUMBER */
.number {
    color: #94a3b8;
    font-weight: 600;
}

/* ITEM */
.kategori-item {
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

/* TEXT */
.kategori-text {
    font-weight: 600;
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
    font-size: 28px;
    margin-bottom: 10px;
}

/* ALERT */
.swal2-popup {
    border-radius: 12px !important;
}

</style>

@endsection


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// SUCCESS
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    background: '#0f172a',
    color: '#fff',
    confirmButtonColor: '#3b82f6'
});
@endif

// ERROR
@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '{{ session('error') }}',
    background: '#0f172a',
    color: '#fff',
    confirmButtonColor: '#ef4444'
});
@endif

// DELETE CONFIRM
document.querySelectorAll('.form-hapus-kategori').forEach(form => {
    form.addEventListener('submit', function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Hapus kategori?',
            text: 'Data tidak bisa dikembalikan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Hapus',
            background: '#0f172a',
            color: '#fff'
        }).then((result)=>{
            if(result.isConfirmed){
                this.submit();
            }
        });
    });
});

</script>

@endsection