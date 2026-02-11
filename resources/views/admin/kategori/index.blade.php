@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', 'Segoe UI', sans-serif;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 style="font-weight: 800; color: #1a202c; margin: 0; letter-spacing: -0.5px;">🏷️ Manajemen Kategori</h4>
            <p style="color: #718096; font-size: 14px; margin-top: 5px;">Kelola pengelompokan alat untuk mempermudah
                pencarian.</p>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.kategori.create') }}" class="btn shadow-sm"
            style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; border-radius: 10px; padding: 12px 24px; text-decoration: none; font-weight: 700; font-size: 13px; transition: all 0.3s ease; border: none;">
            <i class="fas fa-plus me-2"></i> Kategori Baru
        </a>
    </div>

    @if(session('success'))
    <div class="alert border-0 shadow-sm"
        style="background-color: #def7ec; color: #03543f; border-radius: 12px; padding: 15px 20px; margin-bottom: 20px;"
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
                        style="padding: 20px; text-align: left; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 80px;">
                        NO</th>
                    <th
                        style="padding: 20px; text-align: left; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7;">
                        NAMA KATEGORI</th>
                    <th
                        style="padding: 20px; text-align: center; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 220px;">
                        AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $kategori)
                <tr style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#fcfdfe'"
                    onmouseout="this.style.backgroundColor='transparent'">
                    <td
                        style="padding: 20px; color: #94a3b8; font-weight: 600; font-size: 14px; border-bottom: 1px solid #f1f5f9;">
                        {{ $loop->iteration }}
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                        <div style="font-weight: 700; color: #1e293b; font-size: 15px;">{{ $kategori->nama_kategori }}
                        </div>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">

                            <a href="{{ route('admin.kategori.edit', $kategori->id) }}" class="btn-edit"
                                style="display: inline-flex; align-items: center; white-space: nowrap; background-color: white; color: #4e73df; border: 1px solid #e2e8f0; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 700; transition: all 0.2s;">
                                <i class="fas fa-edit" style="margin-right: 8px;"></i> Edit
                            </a>

                            <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST"
                                onsubmit="return confirm('Hapus kategori ini?')" style="margin: 0;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete"
                                    style="display: inline-flex; align-items: center; white-space: nowrap; background-color: white; color: #e74a3b; border: 1px solid #fee2e2; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 12px; font-weight: 700; transition: all 0.2s;">
                                    <i class="fas fa-trash-alt" style="margin-right: 8px;"></i> Hapus
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="padding: 40px; text-align: center; color: #94a3b8;">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.btn-edit:hover {
    background-color: #f8fafc !important;
    border-color: #4e73df !important;
}

.btn-delete:hover {
    background-color: #fff1f0 !important;
    border-color: #e74a3b !important;
}
</style>
@endsection