@extends('layouts.admin')

@section('content')
<div style="padding:20px;">

    <h4 style="color:#e2e8f0; font-weight:800; margin-bottom:20px;">
        🔍 Hasil pencarian: "{{ $q }}"
    </h4>

    {{-- ===================== DATA ALAT ===================== --}}
    <div style="background: rgba(255,255,255,0.05); padding:20px; border-radius:15px; margin-bottom:20px;">
        <h5 style="color:#60a5fa; margin-bottom:15px;">📦 Data Alat</h5>

        @forelse($alats as $a)
        <a href="{{ route('admin.alat.edit', $a->id) }}" class="search-item">
            <div>
                <b>{{ $a->nama_alat }}</b><br>
                <span>{{ $a->kategori->nama_kategori ?? '-' }}</span>
            </div>
            <i class="fas fa-arrow-right"></i>
        </a>
        @empty
        <p class="empty-text">Tidak ditemukan</p>
        @endforelse
    </div>

    {{-- ===================== KATEGORI ===================== --}}
    <div style="background: rgba(255,255,255,0.05); padding:20px; border-radius:15px; margin-bottom:20px;">
        <h5 style="color:#a78bfa; margin-bottom:15px;">🏷️ Kategori</h5>

        @forelse($kategoris as $k)
        <a href="{{ route('admin.kategori.index') }}" class="search-item">
            <div>
                <b>{{ $k->nama_kategori }}</b>
            </div>
            <i class="fas fa-arrow-right"></i>
        </a>
        @empty
        <p class="empty-text">Tidak ditemukan</p>
        @endforelse
    </div>

    {{-- ===================== PEMINJAMAN ===================== --}}
    <div style="background: rgba(255,255,255,0.05); padding:20px; border-radius:15px;">
        <h5 style="color:#34d399; margin-bottom:15px;">📊 Transaksi</h5>

        @forelse($peminjamans as $p)
        <a href="{{ route('admin.peminjaman.show', $p->id) }}" class="search-item">
            <div>
                <b>#{{ $p->kode_peminjaman }}</b><br>
                <span>{{ $p->user->name ?? '-' }}</span>
            </div>
            <i class="fas fa-arrow-right"></i>
        </a>
        @empty
        <p class="empty-text">Tidak ditemukan</p>
        @endforelse
    </div>
    {{-- ===================== USER ===================== --}}
    <div style="background: rgba(255,255,255,0.05); padding:20px; border-radius:15px; margin-top:20px;">
        <h5 style="color:#facc15; margin-bottom:15px;">👤 Pengguna</h5>

        @forelse($users as $u)
        <a href="{{ route('admin.user.edit', $u->id) }}" class="search-item">
            <div>
                <b>{{ $u->name }}</b><br>
                <span>{{ $u->email }} • {{ $u->role }}</span>
            </div>
            <i class="fas fa-arrow-right"></i>
        </a>
        @empty
        <p class="empty-text">Tidak ditemukan</p>
        @endforelse
    </div>

</div>

{{-- ===================== STYLE ===================== --}}
<style>
.search-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    margin-bottom: 10px;
    border-radius: 12px;
    text-decoration: none;
    background: rgba(255, 255, 255, 0.03);
    transition: all 0.25s ease;
    color: #e2e8f0;
}

.search-item span {
    color: #94a3b8;
    font-size: 12px;
}

/* Hover effect */
.search-item:hover {
    background: rgba(59, 130, 246, 0.15);
    transform: translateX(6px);
    box-shadow: 0 5px 15px rgba(59, 130, 246, 0.2);
}

/* Arrow icon */
.search-item i {
    color: #60a5fa;
    font-size: 13px;
}

/* Empty text */
.empty-text {
    color: #64748b;
    font-size: 13px;
}
</style>
@endsection