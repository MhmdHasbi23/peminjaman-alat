@extends('layouts.admin')

@section('content')

<div class="page-wrapper">

    {{-- HEADER --}}
    <div class="page-header">
        <div>
            <h4>
                <i class="fas fa-users-cog me-2"></i> Manajemen Pengguna
            </h4>
            <p>Kelola hak akses dan informasi akun seluruh pengguna</p>
        </div>

        <a href="{{ route('admin.user.create') }}" class="btn-primary-soft">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert-success-glass">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- CARD TABLE --}}
    <div class="card-glass">

        <table class="table-modern">

            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Role</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr>

                    {{-- NO --}}
                    <td>
                        {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                    </td>

                    {{-- USER --}}
                    <td>
                        <div class="user-box">
                            <div class="avatar">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>

                            <div>
                                <div class="name">{{ $user->name }}</div>
                                <div class="email">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- ROLE --}}
                    <td>
                        @php
                        $role = [
                            'admin' => 'role-admin',
                            'petugas' => 'role-petugas',
                            'peminjam' => 'role-user'
                        ];
                        @endphp

                        <span class="role-badge {{ $role[$user->role] ?? '' }}">
                            {{ $user->role }}
                        </span>
                    </td>

                    {{-- AKSI --}}
                    <td class="text-center">
                        <div class="action-group">

                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn-action edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn-action delete"
                                    onclick="return confirm('Hapus user ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

    {{-- PAGINATION --}}
    <div class="pagination-wrapper">
        <span>
            {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }}
        </span>

        {{ $users->links() }}
    </div>

</div>

{{-- STYLE --}}
<style>

/* WRAPPER */
.page-wrapper {
    width: 100%;
    color: #cbd5f5;
}

/* HEADER */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.page-header h4 {
    font-weight: 700;
    margin: 0;
}

.page-header p {
    font-size: 13px;
    color: #94a3b8;
}

/* BUTTON */
.btn-primary-soft {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    padding: 10px 18px;
    border-radius: 10px;
    color: white;
    font-size: 13px;
    text-decoration: none;
    font-weight: 600;
}

/* ALERT */
.alert-success-glass {
    background: rgba(34,197,94,0.15);
    border: 1px solid rgba(34,197,94,0.3);
    color: #6ee7b7;
    padding: 12px 16px;
    border-radius: 12px;
    margin-bottom: 20px;
}

/* CARD */
.card-glass {
    background: rgba(255,255,255,0.03);
    border-radius: 20px;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.08);
    overflow: hidden;
}

/* TABLE */
.table-modern {
    width: 100%;
    border-collapse: collapse;
}

.table-modern th {
    padding: 16px;
    text-align: left;
    font-size: 11px;
    color: #64748b;
    text-transform: uppercase;
}

.table-modern td {
    padding: 16px;
    border-top: 1px solid rgba(255,255,255,0.05);
}

.table-modern tr:hover {
    background: rgba(59,130,246,0.08);
}

/* USER */
.user-box {
    display: flex;
    align-items: center;
    gap: 12px;
}

.avatar {
    width: 40px;
    height: 40px;
    background: rgba(59,130,246,0.2);
    color: #60a5fa;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}

.name {
    font-weight: 700;
    color: #e5e7eb;
}

.email {
    font-size: 13px;
    color: #94a3b8;
}

/* ROLE */
.role-badge {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}

.role-admin {
    background: rgba(239,68,68,0.2);
    color: #f87171;
}

.role-petugas {
    background: rgba(251,191,36,0.2);
    color: #fbbf24;
}

.role-user {
    background: rgba(59,130,246,0.2);
    color: #60a5fa;
}

/* ACTION */
.action-group {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.btn-action {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: 0.2s;
}

.btn-action.edit {
    background: rgba(59,130,246,0.2);
    color: #60a5fa;
}

.btn-action.edit:hover {
    background: #3b82f6;
    color: white;
}

.btn-action.delete {
    background: rgba(239,68,68,0.2);
    color: #f87171;
}

.btn-action.delete:hover {
    background: #ef4444;
    color: white;
}

/* PAGINATION */
.pagination-wrapper {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
    color: #94a3b8;
    font-size: 13px;
}

</style>

@endsection