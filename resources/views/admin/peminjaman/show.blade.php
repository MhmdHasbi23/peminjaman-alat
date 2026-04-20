@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 page-wrapper">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.peminjaman.index') }}" class="btn-back me-3">
                <i class="fas fa-arrow-left"></i>
            </a>

            <div>
                <h4 class="title">📄 Rincian Transaksi</h4>
                <span class="badge-glow">
                    {{ $peminjaman->kode_peminjaman }}
                </span>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- LEFT -->
        <div class="col-lg-7 mb-4">
            <div class="card-glass">

                <!-- USER -->
                <div class="user-box mb-4">
                    <div class="avatar">
                        {{ strtoupper(substr($peminjaman->user->name,0,1)) }}
                    </div>
                    <div>
                        <h6>{{ $peminjaman->user->name }}</h6>
                        <small>{{ $peminjaman->user->email }}</small>
                    </div>
                </div>

                <!-- INFO -->
                <div class="info-grid">
                    <div class="info-card">
                        <span>Tanggal Pinjam</span>
                        <strong>{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d M Y') }}</strong>
                    </div>

                    <div class="info-card danger">
                        <span>Target Kembali</span>
                        <strong>{{ \Carbon\Carbon::parse($peminjaman->tgl_kembali_rencana)->format('d M Y') }}</strong>
                    </div>

                    <div class="info-card">
                        <span>Denda</span>
                        <strong>Rp {{ number_format($peminjaman->denda,0,',','.') }}</strong>
                    </div>

                    <div class="info-card">
                        <span>Petugas</span>
                        <strong>{{ $peminjaman->petugas->name ?? 'Belum ada' }}</strong>
                    </div>
                </div>

                <!-- ITEM -->
                <div class="mt-4">
                    <div class="section-title">📦 Item Dipinjam</div>

                    <div class="row g-3">
                        @foreach($peminjaman->detailPeminjaman as $d)
                        <div class="col-md-6">
                            <div class="item-card">
                                <div class="item-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <strong>{{ $d->alat->nama_alat }}</strong>
                                </div>
                                <span class="badge-soft">
                                    {{ $d->jumlah }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-lg-5">
            <div class="card-glass">

                <div class="section-title">🕒 Timeline Aktivitas</div>

                <div class="timeline">
                    @forelse($peminjaman->logs as $log)
                    <div class="timeline-item">

                        <div class="dot-glow"></div>

                        <div class="timeline-content">
                            <span class="badge-activity">
                                {{ strtoupper($log->aktivitas) }}
                            </span>

                            <p>{{ $log->deskripsi }}</p>

                            <small>
                                {{ $log->created_at->diffForHumans() }}
                                • {{ $log->ip_address }}
                            </small>
                        </div>

                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-clipboard-list empty-icon"></i>
                        <p class="text-muted">Belum ada aktivitas</p>
                    </div>
                    @endforelse
                </div>

            </div>
        </div>

    </div>
</div>

<style>

/* BACKGROUND */
.page-wrapper{
    color:#cbd5f5;
}

/* TITLE */
.title{
    font-weight:800;
    color:#e2e8f0;
}

/* CARD */
.card-glass{
    background: rgba(255,255,255,0.05);
    border-radius:18px;
    padding:25px;
    border:1px solid rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    transition:0.3s;
}

.card-glass:hover{
    transform: translateY(-3px);
    box-shadow:0 15px 30px rgba(0,0,0,0.2);
}

/* BACK BUTTON */
.btn-back{
    background: rgba(255,255,255,0.08);
    color:#cbd5f5;
    padding:8px 12px;
    border-radius:10px;
}

.btn-back:hover{
    background: rgba(255,255,255,0.2);
}

/* BADGE */
.badge-glow{
    background: rgba(59,130,246,0.2);
    color:#60a5fa;
    padding:5px 12px;
    border-radius:8px;
    font-size:12px;
}

/* USER */
.user-box{
    display:flex;
    align-items:center;
    gap:15px;
}

.avatar{
    width:45px;
    height:45px;
    border-radius:12px;
    background: linear-gradient(135deg,#3b82f6,#2563eb);
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    color:white;
}

/* INFO GRID */
.info-grid{
    display:grid;
    grid-template-columns: repeat(2,1fr);
    gap:15px;
}

.info-card{
    background: rgba(255,255,255,0.05);
    padding:12px;
    border-radius:10px;
    font-size:13px;
}

.info-card strong{
    display:block;
    color:#e2e8f0;
}

.info-card.danger{
    background: rgba(239,68,68,0.15);
}

/* ITEM */
.item-card{
    display:flex;
    align-items:center;
    background: rgba(255,255,255,0.05);
    padding:10px;
    border-radius:10px;
    transition:0.3s;
}

.item-card:hover{
    background: rgba(59,130,246,0.1);
}

.item-icon{
    width:32px;
    height:32px;
    border-radius:8px;
    background: rgba(59,130,246,0.2);
    display:flex;
    align-items:center;
    justify-content:center;
}

/* BADGE */
.badge-soft{
    background: rgba(59,130,246,0.2);
    padding:5px 10px;
    border-radius:8px;
}

/* TIMELINE */
.timeline{
    margin-top:10px;
}

.timeline-item{
    position:relative;
    padding-left:20px;
    margin-bottom:20px;
    border-left:2px solid rgba(255,255,255,0.1);
}

.dot-glow{
    position:absolute;
    left:-6px;
    top:5px;
    width:10px;
    height:10px;
    background:#3b82f6;
    border-radius:50%;
    box-shadow:0 0 10px #3b82f6;
}

.timeline-content p{
    font-size:13px;
    margin:5px 0;
}

.timeline-content small{
    font-size:11px;
    color:#64748b;
}

/* BADGE ACTIVITY */
.badge-activity{
    background: rgba(59,130,246,0.2);
    padding:4px 10px;
    border-radius:6px;
    font-size:11px;
}

/* EMPTY */
.empty-icon{
    font-size:35px;
    color:#475569;
}

</style>

@endsection