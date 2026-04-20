@extends('layouts.admin')

@section('content')

<div class="page-wrapper">

    {{-- HEADER --}}
    <div class="page-header">
        <div>
            <h4>
                <i class="fas fa-history me-2"></i> Log Aktivitas Sistem
            </h4>
            <p>Rekaman aktivitas pengguna untuk audit dan keamanan</p>
        </div>

        <button onclick="window.location.reload()" class="btn-refresh">
            <i class="fas fa-sync-alt me-2"></i> Refresh
        </button>
    </div>

    {{-- CARD --}}
    <div class="card-glass">

        <div class="table-responsive">
            <table class="table-modern">

                {{-- HEADER --}}
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th>Deskripsi</th>
                        <th>IP</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>
                    @forelse($logs as $log)
                    <tr>

                        {{-- WAKTU --}}
                        <td>
                            <div class="time-main">
                                {{ $log->created_at->format('d M Y') }}
                            </div>
                            <div class="time-sub">
                                {{ $log->created_at->format('H:i:s') }} WIB
                            </div>
                        </td>

                        {{-- USER --}}
                        <td>
                            <div class="user-box">
                                <div class="avatar">
                                    {{ strtoupper(substr($log->user->name ?? 'S',0,1)) }}
                                </div>

                                <span class="user-name">
                                    {{ $log->user->name ?? 'System' }}
                                </span>
                            </div>
                        </td>

                        {{-- AKTIVITAS --}}
                        <td>
                            @php
                            $color = match(strtolower($log->aktivitas)) {
                                'login' => 'green',
                                'logout' => 'red',
                                'create' => 'blue',
                                'update' => 'yellow',
                                'delete' => 'red',
                                default => 'gray'
                            };
                            @endphp

                            <span class="badge-activity {{ $color }}">
                                {{ $log->aktivitas }}
                            </span>
                        </td>

                        {{-- DESKRIPSI --}}
                        <td class="desc">
                            {{ $log->deskripsi }}
                        </td>

                        {{-- IP --}}
                        <td>
                            <span class="ip-box">
                                {{ $log->ip_address }}
                            </span>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            <i class="fas fa-clipboard-list"></i>
                            <p>Belum ada aktivitas</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    {{-- PAGINATION --}}
    <div class="pagination-wrapper">
        {{ $logs->links() }}
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
.btn-refresh {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    padding: 10px 18px;
    border-radius: 10px;
    color: #cbd5f5;
    font-size: 13px;
    cursor: pointer;
    transition: 0.2s;
}

.btn-refresh:hover {
    background: rgba(59,130,246,0.2);
    color: #93c5fd;
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
    font-size: 11px;
    text-transform: uppercase;
    color: #64748b;
    text-align: left;
}

.table-modern td {
    padding: 16px;
    border-top: 1px solid rgba(255,255,255,0.05);
}

.table-modern tr:hover {
    background: rgba(59,130,246,0.08);
}

/* TIME */
.time-main {
    font-weight: 600;
    color: #e5e7eb;
}

.time-sub {
    font-size: 11px;
    color: #64748b;
}

/* USER */
.user-box {
    display: flex;
    align-items: center;
    gap: 10px;
}

.avatar {
    width: 32px;
    height: 32px;
    background: rgba(59,130,246,0.2);
    color: #60a5fa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}

.user-name {
    font-weight: 600;
}

/* BADGE */
.badge-activity {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
}

/* COLORS */
.green { background: rgba(34,197,94,0.2); color: #4ade80; }
.red { background: rgba(239,68,68,0.2); color: #f87171; }
.blue { background: rgba(59,130,246,0.2); color: #60a5fa; }
.yellow { background: rgba(251,191,36,0.2); color: #fbbf24; }
.gray { background: rgba(255,255,255,0.1); color: #cbd5f5; }

/* DESC */
.desc {
    color: #cbd5f5;
}

/* IP */
.ip-box {
    font-family: monospace;
    font-size: 11px;
    background: rgba(255,255,255,0.05);
    padding: 4px 8px;
    border-radius: 6px;
    color: #94a3b8;
}

/* EMPTY */
.empty-state {
    text-align: center;
    padding: 60px;
    color: #64748b;
}

.empty-state i {
    font-size: 40px;
    margin-bottom: 10px;
}

/* PAGINATION */
.pagination-wrapper {
    margin-top: 20px;
    text-align: center;
}

.page-link {
    background: transparent;
    border: none;
    color: #94a3b8;
}

.page-item.active .page-link {
    background: #3b82f6;
    color: white;
    border-radius: 8px;
}

</style>

@endsection