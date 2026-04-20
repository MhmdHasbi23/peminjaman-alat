@extends('layouts.peminjam')

@section('content')
<div style="
    width: 100%;
    min-height: calc(100vh - 70px);
    padding: 25px;
    font-family: 'Inter', sans-serif;
">

    {{-- ================= HEADER ================= --}}
    <div style="margin-bottom: 20px;">
        <h4 style="font-weight: 800; color: #e2e8f0; margin: 0;">
            ↩️ Pengembalian Alat
        </h4>
        <p style="color:#94a3b8; font-size:0.9rem; margin-top:6px;">
            Silakan kembalikan alat sesuai jadwal ke petugas gudang.
        </p>
    </div>

    {{-- ================= LIST ================= --}}
    <div style="display:flex; flex-direction:column; gap:16px;">

        @forelse($pinjamanAktif as $p)

        <div style="
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 18px;
            padding: 20px;
        ">

            {{-- HEADER CARD --}}
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">

                <span style="
                    background: rgba(16,185,129,0.10);
                    color:#34d399;
                    padding:6px 12px;
                    border-radius:10px;
                    font-size:11px;
                    font-weight:700;">
                    ● Sedang Dipinjam
                </span>

                <span style="color:#93c5fd; font-weight:700; font-size:13px;">
                    #{{ $p->kode_peminjaman }}
                </span>

            </div>

            {{-- ================= ITEM LIST (VERTICAL) ================= --}}
            <div style="margin-top:10px;">

                <div style="color:#94a3b8; font-size:11px; font-weight:700; margin-bottom:10px;">
                    ITEM YANG HARUS DIKEMBALIKAN
                </div>

                <div style="
                    background: rgba(255,255,255,0.02);
                    border:1px solid rgba(255,255,255,0.05);
                    border-radius:12px;
                    padding:12px;
                ">

                    @foreach($p->detailPeminjaman as $detail)
                    <div style="
                        display:flex;
                        justify-content:space-between;
                        padding:8px 0;
                        border-bottom:1px solid rgba(255,255,255,0.05);
                        color:#cbd5e1;
                        font-size:14px;
                        font-weight:600;
                    ">
                        <span>
                            <i class="fas fa-cube" style="color:#60a5fa; margin-right:8px;"></i>
                            {{ $detail->alat->nama_alat }}
                        </span>

                        <span style="
                            background: rgba(96,165,250,0.12);
                            color:#93c5fd;
                            padding:3px 10px;
                            border-radius:8px;
                            font-size:12px;">
                            {{ $detail->jumlah }}
                        </span>
                    </div>
                    @endforeach

                </div>
            </div>

            {{-- ================= DEADLINE (FULL WIDTH BAWAH) ================= --}}
            <div style="
                margin-top:15px;
                background: rgba(239,68,68,0.10);
                border:1px solid rgba(239,68,68,0.15);
                border-radius:14px;
                padding:12px;
            ">

                <div style="font-size:10px; font-weight:800; color:#f87171;">
                    BATAS PENGEMBALIAN
                </div>

                <div style="font-size:16px; font-weight:800; color:#e2e8f0; margin:4px 0;">
                    {{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d M Y') }}
                </div>

                @php
                $isLate = \Carbon\Carbon::parse($p->tgl_kembali_rencana)->isPast();
                @endphp

                @if($isLate)
                <span style="color:#f87171; font-size:11px; font-weight:700;">
                    ⚠ Terlambat
                </span>
                @else
                <span style="color:#94a3b8; font-size:11px;">
                    {{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->diffForHumans(null, true) }} lagi
                </span>
                @endif

            </div>

            {{-- ================= INFO ================= --}}
            <div style="
                margin-top:15px;
                padding:12px;
                border-radius:12px;
                background: rgba(255,255,255,0.02);
                border:1px solid rgba(255,255,255,0.05);
                display:flex;
                gap:10px;
                align-items:flex-start;
                color:#94a3b8;
                font-size:12px;
            ">
                <i class="fas fa-info-circle" style="color:#60a5fa; margin-top:2px;"></i>
                <span>
                    Tunjukkan kode transaksi <b style="color:#e2e8f0;">#{{ $p->kode_peminjaman }}</b> ke petugas
                    gudang.
                </span>
            </div>

        </div>

        @empty

        {{-- ================= EMPTY ================= --}}
        <div style="
            text-align:center;
            padding:60px 20px;
            background: rgba(255,255,255,0.03);
            border:1px dashed rgba(255,255,255,0.1);
            border-radius:18px;
        ">

            <div style="font-size:50px; color:#334155;">
                <i class="fas fa-check-circle"></i>
            </div>

            <h5 style="color:#e2e8f0; font-weight:800; margin-top:10px;">
                Tidak Ada Pinjaman Aktif
            </h5>

            <p style="color:#94a3b8; font-size:13px; margin-top:6px;">
                Anda sudah bebas dari semua pinjaman.
            </p>

            <a href="{{ route('peminjam.alat.index') }}"
                style="
                    display:inline-block;
                    margin-top:15px;
                    padding:10px 18px;
                    border-radius:12px;
                    background: linear-gradient(135deg,#3b82f6,#2563eb);
                    color:white;
                    text-decoration:none;
                    font-weight:700;
                ">
                Pinjam Alat
            </a>

        </div>

        @endforelse

    </div>

</div>
@endsection