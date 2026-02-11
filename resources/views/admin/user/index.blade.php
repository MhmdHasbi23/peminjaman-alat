@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', 'Segoe UI', sans-serif;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 style="font-weight: 800; color: #1a202c; margin: 0; letter-spacing: -0.5px;">
                <i class="fas fa-users-cog me-2" style="color: #4e73df;"></i> Manajemen Pengguna
            </h4>
            <p style="color: #718096; font-size: 14px; margin-top: 5px;">Kelola hak akses dan informasi akun seluruh
                staf dan pengguna.</p>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.user.create') }}" class="btn shadow-sm"
            style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; border-radius: 10px; padding: 12px 24px; text-decoration: none; font-weight: 700; font-size: 13px; transition: all 0.3s ease; border: none;">
            <i class="fas fa-plus-circle me-2"></i> Tambah Pengguna
        </a>
    </div>

    @if(session('success'))
    <div class="alert border-0 shadow-sm"
        style="background-color: #def7ec; color: #03543f; border-radius: 12px; padding: 15px 20px; margin-bottom: 25px;"
        role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2"></i>
            <span style="font-weight: 600;">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <div
        style="background: white; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.04); overflow: hidden; border: 1px solid #e2e8f0;">
        <table class="table mb-0"
            style="width: 100%; border-collapse: separate; border-spacing: 0; vertical-align: middle;">
            <thead>
                <tr style="background-color: #f8fafc;">
                    <th
                        style="padding: 20px; text-align: left; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 60px;">
                        No</th>
                    <th
                        style="padding: 20px; text-align: left; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7;">
                        Identitas Pengguna</th>
                    <th
                        style="padding: 20px; text-align: left; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7;">
                        Hak Akses (Role)</th>
                    <th
                        style="padding: 20px; text-align: center; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 220px;">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#fcfdfe'"
                    onmouseout="this.style.backgroundColor='transparent'">
                    <td
                        style="padding: 20px; color: #94a3b8; font-weight: 600; font-size: 14px; border-bottom: 1px solid #f1f5f9;">
                        {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                        <div class="d-flex align-items-center">
                            <div
                                style="width: 40px; height: 40px; background: #f0f7ff; color: #4e73df; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 700; margin-right: 15px; flex-shrink: 0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 700; color: #1e293b; font-size: 15px;">{{ $user->name }}</div>
                                <div style="color: #64748b; font-size: 13px;"><i class="far fa-envelope me-1"></i>
                                    {{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                        @php
                        $roleConfig = [
                        'admin' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'icon' => 'fa-user-shield'],
                        'petugas' => ['bg' => '#fef3c7', 'text' => '#92400e', 'icon' => 'fa-user-tie'],
                        'peminjam'=> ['bg' => '#e0e7ff', 'text' => '#3730a3', 'icon' => 'fa-user'],
                        ];
                        $cfg = $roleConfig[$user->role] ?? ['bg' => '#f3f4f6', 'text' => '#374151', 'icon' =>
                        'fa-user'];
                        @endphp
                        <span
                            style="background-color: {{ $cfg['bg'] }}; color: {{ $cfg['text'] }}; padding: 6px 14px; border-radius: 8px; font-size: 11px; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; white-space: nowrap;">
                            <i class="fas {{ $cfg['icon'] }} me-2"></i> {{ $user->role }}
                        </span>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn-edit"
                                style="display: inline-flex; align-items: center; background-color: white; color: #4e73df; border: 1px solid #e2e8f0; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 700; transition: all 0.2s;">
                                <i class="fas fa-edit me-2"></i> Edit
                            </a>
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirm('Hapus pengguna ini? Tindakan ini tidak dapat dibatalkan.')"
                                style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete"
                                    style="display: inline-flex; align-items: center; background-color: white; color: #e74a3b; border: 1px solid #fee2e2; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 12px; font-weight: 700; transition: all 0.2s;">
                                    <i class="fas fa-trash-alt me-2"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-between align-items-center" style="padding: 0 5px;">
        <p style="color: #94a3b8; font-size: 13px; font-weight: 500;">
            Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari {{ $users->total() }} pengguna
        </p>
        <div>
            {{ $users->links() }}
        </div>
    </div>
</div>

<style>
.btn-edit:hover {
    background-color: #f8fafc !important;
    border-color: #4e73df !important;
    box-shadow: 0 4px 6px -1px rgba(78, 115, 223, 0.1);
}

.btn-delete:hover {
    background-color: #fff1f0 !important;
    border-color: #e74a3b !important;
    box-shadow: 0 4px 6px -1px rgba(231, 74, 59, 0.1);
}

.pagination {
    margin-bottom: 0;
}

.page-item.active .page-link {
    background: #4e73df !important;
    border-radius: 8px;
    border: none;
}
</style>
@endsection