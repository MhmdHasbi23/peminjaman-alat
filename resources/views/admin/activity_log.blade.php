@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', 'Segoe UI', sans-serif;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 style="font-weight: 800; color: #1a202c; margin: 0; letter-spacing: -0.5px;">
                <i class="fas fa-history me-2" style="color: #4e73df;"></i> Log Aktivitas Sistem
            </h4>
            <p style="color: #718096; font-size: 14px; margin-top: 5px;">Rekaman jejak aktivitas pengguna untuk
                keperluan audit dan keamanan.</p>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-none d-md-block">
            <button onclick="window.location.reload()" class="btn btn-white shadow-sm border-0"
                style="border-radius: 10px; padding: 10px 20px; font-weight: 600; font-size: 13px; background: white;">
                <i class="fas fa-sync-alt text-primary me-2"></i> Refresh Data
            </button>
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
                            style="padding: 20px; text-align: left; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 180px;">
                            Waktu</th>
                        <th
                            style="padding: 20px; text-align: left; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 200px;">
                            User</th>
                        <th
                            style="padding: 20px; text-align: left; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 150px;">
                            Aktivitas</th>
                        <th
                            style="padding: 20px; text-align: left; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7;">
                            Deskripsi</th>
                        <th
                            style="padding: 20px; text-align: left; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 130px;">
                            IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#fcfdfe'"
                        onmouseout="this.style.backgroundColor='transparent'">
                        <td style="padding: 18px 20px; border-bottom: 1px solid #f1f5f9;">
                            <div style="font-weight: 600; color: #1e293b; font-size: 13px;">
                                {{ $log->created_at->format('d M Y') }}</div>
                            <div style="font-size: 11px; color: #94a3b8; font-weight: 500;">
                                {{ $log->created_at->format('H:i:s') }} WIB</div>
                        </td>
                        <td style="padding: 18px 20px; border-bottom: 1px solid #f1f5f9;">
                            <div class="d-flex align-items-center">
                                <div
                                    style="width: 32px; height: 32px; background: #f1f5f9; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-weight: 700; color: #475569; font-size: 11px;">
                                    {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                </div>
                                <span
                                    style="font-weight: 700; color: #334155; font-size: 13px;">{{ $log->user->name ?? 'System' }}</span>
                            </div>
                        </td>
                        <td style="padding: 18px 20px; border-bottom: 1px solid #f1f5f9;">
                            @php
                            $color = match(strtolower($log->aktivitas)) {
                            'login' => ['bg' => '#dcfce7', 'text' => '#166534'],
                            'logout' => ['bg' => '#fef2f2', 'text' => '#991b1b'],
                            'create' => ['bg' => '#dff6ff', 'text' => '#0369a1'],
                            'update' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                            'delete' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                            default => ['bg' => '#f1f5f9', 'text' => '#475569']
                            };
                            @endphp
                            <span
                                style="background: {{ $color['bg'] }}; color: {{ $color['text'] }}; padding: 5px 12px; border-radius: 6px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; border: 1px solid rgba(0,0,0,0.03);">
                                {{ $log->aktivitas }}
                            </span>
                        </td>
                        <td style="padding: 18px 20px; border-bottom: 1px solid #f1f5f9;">
                            <div style="color: #475569; font-size: 13px; line-height: 1.5; font-weight: 500;">
                                {{ $log->deskripsi }}
                            </div>
                        </td>
                        <td style="padding: 18px 20px; border-bottom: 1px solid #f1f5f9;">
                            <span
                                style="font-family: 'JetBrains Mono', 'Fira Code', monospace; font-size: 11px; color: #94a3b8; background: #f8fafc; padding: 4px 8px; border-radius: 5px; border: 1px solid #edf2f7;">
                                {{ $log->ip_address }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 60px; text-align: center;">
                            <div style="font-size: 3rem; color: #e2e8f0; margin-bottom: 15px;">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <p style="color: #94a3b8; font-weight: 500; font-size: 15px;">Belum ada riwayat aktivitas
                                yang tercatat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        <div class="pagination-modern">
            {{ $logs->links() }}
        </div>
    </div>
</div>

<style>
/* Styling Pagination agar lebih clean */
.pagination-modern .pagination {
    gap: 5px;
}

.pagination-modern .page-link {
    border: none;
    border-radius: 8px !important;
    color: #64748b;
    font-weight: 600;
    padding: 8px 16px;
    transition: 0.2s;
}

.pagination-modern .page-item.active .page-link {
    background-color: #4e73df;
    color: white;
    box-shadow: 0 4px 10px rgba(78, 115, 223, 0.2);
}

.pagination-modern .page-link:hover:not(.active) {
    background-color: #f1f5f9;
    color: #4e73df;
}

/* Scrollbar untuk tabel responsive */
.table-responsive::-webkit-scrollbar {
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}
</style>
@endsection