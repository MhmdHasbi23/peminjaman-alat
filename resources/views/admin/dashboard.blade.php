@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: 'Inter', sans-serif; color:#cbd5f5;">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 style="font-weight: 700; margin: 0;">
                <i class="fas fa-th-large me-2" style="color:#93c5fd;"></i> Dashboard
            </h4>
            <small style="color:#94a3b8;">Halo, {{ auth()->user()->name }}</small>
        </div>

        <div style="
            background: rgba(255,255,255,0.05);
            padding:10px 16px;
            border-radius:12px;
            font-size:13px;
            border:1px solid rgba(255,255,255,0.05);
        ">
            <i class="fas fa-calendar-alt me-2"></i>
            {{ now()->translatedFormat('d F Y') }}
        </div>
    </div>

    {{-- STAT --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;margin-bottom:30px;">

        @php
        $cards = [
        ['title'=>'Total Inventaris','value'=>$total_alat,'icon'=>'tools','color'=>'#60a5fa'],
        ['title'=>'Menunggu','value'=>$pinjam_menunggu,'icon'=>'hourglass-half','color'=>'#fbbf24'],
        ['title'=>'Dipinjam','value'=>$pinjam_aktif,'icon'=>'exchange-alt','color'=>'#34d399'],
        ];
        @endphp

        @foreach($cards as $c)
        <div class="stat-card" style="
            background: rgba(255,255,255,0.05);
            border-radius:18px;
            padding:22px;
            border:1px solid rgba(255,255,255,0.05);
            position:relative;
            overflow:hidden;
            transition:0.3s;
        ">

            {{-- glow --}}
            <div style="
                position:absolute;
                width:120px;
                height:120px;
                background: {{ $c['color'] }};
                filter: blur(70px);
                opacity:0.15;
                top:-30px;
                right:-30px;
            "></div>

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div style="font-size:11px;color:#94a3b8;">
                        {{ $c['title'] }}
                    </div>
                    <div style="font-size:28px;font-weight:700;">
                        {{ $c['value'] }}
                    </div>
                </div>

                <div style="
                    width:45px;
                    height:45px;
                    border-radius:12px;
                    background: rgba(255,255,255,0.08);
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:18px;
                    color: {{ $c['color'] }};
                ">
                    <i class="fas fa-{{ $c['icon'] }}"></i>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    {{-- MAIN --}}
    <div class="row">

        {{-- LOG --}}
        <div class="col-lg-8 mb-4">
            <div class="glass-card">
                <div class="d-flex justify-content-between mb-3">
                    <h5 style="font-size:15px;">📜 Aktivitas</h5>
                    <a href="{{ route('admin.log.index') }}" class="btn-soft">Lihat</a>
                </div>

                @forelse($recent_logs as $log)
                <div style="
                    display:flex;
                    justify-content:space-between;
                    padding:12px 0;
                    border-bottom:1px solid rgba(255,255,255,0.05);
                ">
                    <div>
                        <div style="font-weight:600;">{{ $log->user->name ?? 'System' }}</div>
                        <div style="color:#94a3b8;font-size:13px;">{{ $log->deskripsi }}</div>
                    </div>
                    <div style="font-size:12px;color:#64748b;">
                        {{ $log->created_at->diffForHumans() }}
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:25px;color:#64748b;">
                    Belum ada aktivitas
                </div>
                @endforelse
            </div>
        </div>

        {{-- SIDE --}}
        <div class="col-lg-4 mb-4">

            {{-- STOK --}}
            <div class="glass-card danger">
                <h6 style="margin-bottom:12px;">
                    <i class="fas fa-exclamation-triangle me-2"></i> Stok Menipis
                </h6>

                @forelse($stok_menipis as $a)
                <div class="mini-card">
                    <span>{{ $a->nama_alat }}</span>
                    <span class="badge-soft">{{ $a->stok }}</span>
                </div>
                @empty
                <div style="text-align:center;font-size:12px;">Aman</div>
                @endforelse
            </div>

            {{-- TIPS --}}
            <div class="glass-card info">
                <h6>💡 Tips</h6>
                <p style="font-size:12px;color:#94a3b8;">
                    Pantau log aktivitas untuk kontrol sistem lebih baik.
                </p>
            </div>

        </div>
    </div>
</div>

<style>
/* reusable */
.glass-card{
    background: rgba(255,255,255,0.05);
    padding:20px;
    border-radius:16px;
    border:1px solid rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    margin-bottom:20px;
}

.glass-card:hover{
    transform: translateY(-3px);
}

.btn-soft{
    background: rgba(59,130,246,0.15);
    padding:6px 10px;
    border-radius:8px;
    font-size:12px;
    color:#93c5fd;
    text-decoration:none;
}

.mini-card{
    display:flex;
    justify-content:space-between;
    background: rgba(255,255,255,0.05);
    padding:10px;
    border-radius:10px;
    margin-bottom:8px;
    font-size:13px;
}

.badge-soft{
    background: rgba(248,113,113,0.2);
    padding:4px 8px;
    border-radius:6px;
    font-size:12px;
}

.stat-card:hover{
    transform: translateY(-5px) scale(1.01);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

/* color variant */
.danger{
    border:1px solid rgba(248,113,113,0.2);
}
.info{
    border:1px solid rgba(59,130,246,0.2);
}
</style>

@endsection