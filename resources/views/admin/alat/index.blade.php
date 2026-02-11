@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', 'Segoe UI', sans-serif;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 style="font-weight: 800; color: #1a202c; margin: 0; letter-spacing: -0.5px;">📦 Inventaris Alat</h4>
            <p style="color: #718096; font-size: 14px; margin-top: 5px;">Kelola stok dan ketersediaan peralatan sarana
                prasarana.</p>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.alat.create') }}" class="btn shadow-sm"
            style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; border-radius: 10px; padding: 12px 24px; text-decoration: none; font-weight: 700; font-size: 13px; transition: all 0.3s ease; border: none;">
            <i class="fas fa-plus me-2"></i> Tambah Alat Baru
        </a>
    </div>

    @if(session('success'))
    <div class="alert border-0 shadow-sm"
        style="background-color: #def7ec; color: #03543f; border-radius: 12px; padding: 15px 20px;" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2"></i>
            <span style="font-weight: 600;">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <div
        style="background: white; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.04), 0 8px 10px -6px rgba(0,0,0,0.04); overflow: hidden; border: 1px solid #e2e8f0;">
        <table class="table mb-0"
            style="width: 100%; border-collapse: separate; border-spacing: 0; vertical-align: middle;">
            <thead>
                <tr style="background-color: #f8fafc;">
                    <th
                        style="padding: 20px; text-align: left; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 60px;">
                        No</th>
                    <th
                        style="padding: 20px; text-align: left; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7;">
                        Detail Alat</th>
                    <th
                        style="padding: 20px; text-align: left; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7;">
                        Kategori</th>
                    <th
                        style="padding: 20px; text-align: center; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7;">
                        Stok</th>
                    <th
                        style="padding: 20px; text-align: center; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7;">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alats as $alat)
                <tr style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#fcfdfe'"
                    onmouseout="this.style.backgroundColor='transparent'">
                    <td
                        style="padding: 20px; color: #94a3b8; font-weight: 600; font-size: 14px; border-bottom: 1px solid #f1f5f9;">
                        {{ ($alats->currentPage() - 1) * $alats->perPage() + $loop->iteration }}
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                        <div style="font-weight: 700; color: #1e293b; font-size: 15px; margin-bottom: 4px;">
                            {{ $alat->nama_alat }}</div>
                        <div style="color: #64748b; font-size: 12px; line-height: 1.5;">
                            {{ Str::limit($alat->spesifikasi, 60) }}</div>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                        <span
                            style="background-color: #f1f5f9; color: #475569; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 600;">
                            {{ $alat->kategori->nama_kategori }}
                        </span>
                    </td>
                    <td style="padding: 20px; text-align: center; border-bottom: 1px solid #f1f5f9;">
                        @php
                        $stokColor = $alat->stok < 5 ? '#e74a3b' : '#4e73df' ; $stokBg=$alat->stok < 5 ? '#fff1f0'
                                : '#f0f7ff' ; @endphp <span
                                style="background-color: {{ $stokBg }}; color: {{ $stokColor }}; padding: 8px 16px; border-radius: 10px; font-weight: 800; font-size: 13px; border: 1px solid rgba(0,0,0,0.02);">
                                {{ $alat->stok }}
                                </span>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                        <div style="display: flex; justify-content: center; gap: 10px;">
                            <a href="{{ route('admin.alat.edit', $alat->id) }}" class="btn-edit"
                                style="background-color: white; color: #4e73df; border: 1px solid #e2e8f0; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 700; transition: all 0.2s;">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.alat.destroy', $alat->id) }}" method="POST"
                                onsubmit="return confirm('Hapus alat ini secara permanen?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete"
                                    style="background-color: white; color: #e74a3b; border: 1px solid #fee2e2; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 12px; font-weight: 700; transition: all 0.2s;">
                                    <i class="fas fa-trash-alt me-1"></i> Hapus
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
            Menampilkan {{ $alats->firstItem() }} sampai {{ $alats->lastItem() }} dari {{ $alats->total() }} alat
        </p>
        <div>
            {{ $alats->links() }}
        </div>
    </div>
</div>

<style>
/* Tambahan efek hover pada tombol */
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

.page-link {
    border: none;
    background: transparent;
    color: #4a5568;
    font-weight: 600;
    padding: 8px 16px;
}

.page-item.active .page-link {
    background: #4e73df !important;
    border-radius: 8px;
    color: white;
}
</style>
@endsection