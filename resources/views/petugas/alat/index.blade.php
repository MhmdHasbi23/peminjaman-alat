@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', 'Segoe UI', sans-serif;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 style="font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -0.5px;">
                <i class="fas fa-boxes text-primary me-2"></i> Inventaris Alat
            </h4>
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Manajemen ketersediaan stok barang gudang
                secara real-time.</p>
        </div>
        <div class="d-none d-md-block">
            <div
                style="background: white; padding: 10px 20px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <span style="font-size: 0.8rem; font-weight: 700; color: #475569;">
                    <i class="fas fa-user-tag text-primary me-2"></i> Sesi: Petugas Gudang
                </span>
            </div>
        </div>
    </div>

    <div
        style="background: white; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.04); overflow: hidden; border: 1px solid #e2e8f0;">
        <div class="table-responsive">
            <table class="table mb-0"
                style="width: 100%; border-collapse: separate; border-spacing: 0; vertical-align: middle;">
                <thead>
                    <tr style="background-color: #f8fafc;">
                        <th
                            style="padding: 20px; text-align: left; color: #475569; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 40%;">
                            Informasi Alat</th>
                        <th
                            style="padding: 20px; text-align: left; color: #475569; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 20%;">
                            Kategori</th>
                        <th
                            style="padding: 20px; text-align: center; color: #475569; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 20%;">
                            Jumlah Stok</th>
                        <th
                            style="padding: 20px; text-align: center; color: #475569; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 20%;">
                            Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alats as $a)
                    <tr style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#fcfdfe'"
                        onmouseout="this.style.backgroundColor='transparent'">
                        <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                            <div style="font-weight: 700; color: #1e293b; font-size: 15px; margin-bottom: 4px;">
                                {{ $a->nama_alat }}</div>
                            <div style="color: #64748b; font-size: 12px; line-height: 1.5; font-weight: 500;">
                                <i class="fas fa-info-circle me-1" style="opacity: 0.5;"></i>
                                {{ Str::limit($a->spesifikasi, 80) }}
                            </div>
                        </td>
                        <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                            <span
                                style="background: #f1f5f9; color: #475569; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; display: inline-block;">
                                {{ $a->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </td>
                        <td style="padding: 20px; text-align: center; border-bottom: 1px solid #f1f5f9;">
                            <div style="font-size: 20px; font-weight: 800; color: #1e293b;">{{ $a->stok }}</div>
                            <small
                                style="color: #94a3b8; font-size: 10px; font-weight: 700; text-transform: uppercase;">Unit</small>
                        </td>
                        <td style="padding: 20px; text-align: center; border-bottom: 1px solid #f1f5f9;">
                            @if($a->stok > 10)
                            <span
                                style="background: #dcfce7; color: #166534; padding: 6px 14px; border-radius: 10px; font-size: 10px; font-weight: 800; display: inline-flex; align-items: center;">
                                <span
                                    style="width: 6px; height: 6px; background: #22c55e; border-radius: 50%; margin-right: 8px;"></span>
                                AMAN
                            </span>
                            @elseif($a->stok > 0)
                            <span
                                style="background: #fef3c7; color: #92400e; padding: 6px 14px; border-radius: 10px; font-size: 10px; font-weight: 800; display: inline-flex; align-items: center;">
                                <span
                                    style="width: 6px; height: 6px; background: #f59e0b; border-radius: 50%; margin-right: 8px;"></span>
                                TERBATAS
                            </span>
                            @else
                            <span
                                style="background: #fee2e2; color: #991b1b; padding: 6px 14px; border-radius: 10px; font-size: 10px; font-weight: 800; display: inline-flex; align-items: center;">
                                <span
                                    style="width: 6px; height: 6px; background: #ef4444; border-radius: 50%; margin-right: 8px;"></span>
                                KOSONG
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 80px; text-align: center;">
                            <div style="margin-bottom: 20px;">
                                <img src="https://illustrations.popsy.co/amber/box-opening.svg" alt="Empty"
                                    style="width: 140px; opacity: 0.6;">
                            </div>
                            <h6 style="color: #1e293b; font-weight: 800; margin-bottom: 5px;">Data Inventaris Kosong
                            </h6>
                            <p style="color: #94a3b8; font-size: 14px; font-weight: 500;">Belum ada data barang yang
                                terdaftar di sistem.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-between align-items-center">
        <p style="color: #94a3b8; font-size: 13px; font-weight: 500;">
            Menampilkan <span style="color: #475569; font-weight: 700;">{{ count($alats) }}</span> alat tersedia
        </p>
        <div class="pagination-custom">
            {{-- {{ $alats->links() }} --}}
        </div>
    </div>
</div>

<style>
/* Custom Table Responsive Scrollbar */
.table-responsive::-webkit-scrollbar {
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}
</style>
@endsection