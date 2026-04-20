@extends('layouts.peminjam')

@section('content')
<div class="container-fluid px-4 katalog-wrapper">

    {{-- HEADER --}}
    <div class="header-box">
        <h4 class="title">🛠️ Katalog Alat Tersedia</h4>
        <p class="subtitle">Pilih alat yang ingin kamu pinjam dengan mudah dan cepat.</p>

        @if(session('cart') && count(session('cart')) > 0)
        <a href="{{ route('peminjam.checkout') }}" class="btn-cart">
            <i class="fas fa-shopping-basket"></i>
            Daftar Pinjam ({{ count(session('cart')) }})
        </a>
        @endif
    </div>

    {{-- SEARCH (DIPISAH CARD SENDIRI) --}}
    <div class="glass-card search-card">
        <form action="{{ route('peminjam.alat.index') }}" method="GET" class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" name="search" placeholder="Cari alat berdasarkan nama atau kategori..." value="{{ request('search') }}">
            <button type="submit">Cari</button>
        </form>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert-soft">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert-soft error">{{ session('error') }}</div>
    @endif

    {{-- TABLE --}}
    <div class="glass-card table-card">

        <div class="table-responsive">
            <table class="table-soft">

                <thead>
                    <tr>
                        <th>Alat</th>
                        <th>Kategori</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($alats as $alat)
                    <tr>

                        <td>
                            <div class="alat-name">{{ $alat->nama_alat }}</div>
                            <div class="alat-desc">
                                {{ \Illuminate\Support\Str::limit($alat->spesifikasi, 60) }}
                            </div>
                        </td>

                        <td>
                            <span class="badge-soft">
                                {{ $alat->kategori->nama_kategori }}
                            </span>
                        </td>

                        <td class="text-center">
                            <span class="stok {{ $alat->stok > 0 ? 'ok' : 'no' }}">
                                {{ $alat->stok }}
                            </span>
                        </td>

                        <td class="text-center">
                            <form action="{{ route('peminjam.cart.add') }}" method="POST" class="form-soft">
                                @csrf

                                <input type="hidden" name="alat_id" value="{{ $alat->id }}">

                                <input type="number" name="jumlah" value="1" min="1" max="{{ $alat->stok }}">

                                <button type="submit">Pinjam</button>
                            </form>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-soft">
                            Tidak ada alat yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

<style>

/* BASE */
.katalog-wrapper{
    font-family:'Inter',sans-serif;
}

/* HEADER */
.header-box{
    margin-bottom:15px;
}

.title{
    font-weight:800;
    color:#e2e8f0;
    margin:0;
}

.subtitle{
    color:#94a3b8;
    font-size:13px;
    margin:0;
}

/* GLASS CARD (SAMA DENGAN DASHBOARD KAMU) */
.glass-card{
    background:rgba(255,255,255,0.04);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:16px;
    padding:18px;
    backdrop-filter:blur(10px);
    margin-bottom:15px;
}

/* SEARCH CARD */
.search-card{
    display:flex;
    align-items:center;
}

/* SEARCH BOX */
.search-box{
    display:flex;
    align-items:center;
    gap:10px;
    width:100%;
}

.search-box i{
    color:#94a3b8;
}

.search-box input{
    flex:1;
    background:transparent;
    border:none;
    outline:none;
    color:#e2e8f0;
    font-size:13px;
}

.search-box button{
    background:rgba(255,255,255,0.08);
    border:none;
    color:#e2e8f0;
    padding:6px 12px;
    border-radius:8px;
    font-size:12px;
}

/* TABLE */
.table-soft{
    width:100%;
    border-collapse:collapse;
}

.table-soft th{
    font-size:11px;
    color:#94a3b8;
    text-transform:uppercase;
    padding:12px;
}

.table-soft td{
    padding:12px;
    border-top:1px solid rgba(255,255,255,0.05);
    color:#cbd5e1;
}

/* TEXT */
.alat-name{
    color:#e2e8f0;
    font-weight:600;
}

.alat-desc{
    color:#94a3b8;
    font-size:12px;
}

/* BADGE */
.badge-soft{
    background:rgba(255,255,255,0.06);
    color:#cbd5e1;
    padding:4px 8px;
    border-radius:8px;
    font-size:11px;
}

/* STOK */
.stok{
    font-weight:600;
}

.stok.ok{
    color:#34d399;
}

.stok.no{
    color:#94a3b8;
}

/* FORM */
.form-soft{
    display:flex;
    justify-content:center;
    gap:6px;
}

.form-soft input{
    width:55px;
    background:rgba(255,255,255,0.05);
    border:1px solid rgba(255,255,255,0.08);
    color:#e2e8f0;
    text-align:center;
    border-radius:8px;
}

.form-soft button{
    background:rgba(255,255,255,0.08);
    color:#e2e8f0;
    border:none;
    padding:5px 8px;
    border-radius:8px;
    font-size:12px;
}

/* ALERT */
.alert-soft{
    padding:10px;
    border-radius:10px;
    font-size:13px;
    color:#cbd5e1;
    background:rgba(255,255,255,0.04);
    border:1px solid rgba(255,255,255,0.08);
    margin-bottom:12px;
}

.alert-soft.error{
    color:#fca5a5;
}

/* EMPTY */
.empty-soft{
    text-align:center;
    padding:30px;
    color:#94a3b8;
}

/* CART */
.btn-cart{
    display:inline-block;
    margin-top:10px;
    background:rgba(255,255,255,0.06);
    color:#cbd5e1;
    padding:8px 10px;
    border-radius:10px;
    font-size:12px;
    text-decoration:none;
}

</style>

@endsection