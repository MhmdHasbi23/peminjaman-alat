@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', sans-serif;">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 style="font-weight:800; color:#e5e7eb;">
                <i class="fas fa-file-contract me-2 text-primary"></i> Laporan Pengembalian Alat
            </h4>
            <p style="color:#94a3b8; font-size:0.9rem;">
                Rekapitulasi transaksi yang telah diselesaikan
            </p>
        </div>
    </div>

    <!-- FILTER -->
    <div style="
    background: rgba(15,23,42,0.65);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius:18px;
    overflow:hidden;
    box-shadow: 0 12px 30px rgba(0,0,0,0.25);
">

        {{-- ================= HEADER ================= --}}
        <div style="
        padding:18px 22px;
        border-bottom:1px solid rgba(255,255,255,0.06);
        background: rgba(2,6,23,0.4);
    ">
            <h5 style="margin:0; font-weight:800; color:#e2e8f0;">
                📊 Filter Laporan
            </h5>
            <p style="margin:4px 0 0; font-size:12px; color:#94a3b8;">
                Gunakan filter untuk menampilkan data berdasarkan rentang waktu
            </p>
        </div>

        {{-- ================= FORM ================= --}}
        <form action="{{ route('petugas.laporan.index') }}" method="GET">

            <div style="padding:22px;">

                {{-- GRID INPUT --}}
                <div class="row g-3">

                    {{-- MULAI --}}
                    <div class="col-md-4">
                        <label style="font-size:11px; color:#94a3b8; font-weight:600;">
                            Mulai Tanggal
                        </label>
                        <input type="date" name="tgl_mulai" value="{{ $tgl_mulai }}" style="
                            width:100%;
                            margin-top:8px;
                            padding:11px 12px;
                            border-radius:12px;
                            background: rgba(2,6,23,0.9);
                            border:1px solid rgba(255,255,255,0.08);
                            color:#e2e8f0;
                            outline:none;
                        ">
                    </div>

                    {{-- SAMPAI --}}
                    <div class="col-md-4">
                        <label style="font-size:11px; color:#94a3b8; font-weight:600;">
                            Sampai Tanggal
                        </label>
                        <input type="date" name="tgl_selesai" value="{{ $tgl_selesai }}" style="
                            width:100%;
                            margin-top:8px;
                            padding:11px 12px;
                            border-radius:12px;
                            background: rgba(2,6,23,0.9);
                            border:1px solid rgba(255,255,255,0.08);
                            color:#e2e8f0;
                            outline:none;
                        ">
                    </div>

                    {{-- ACTION PANEL --}}
                    <div class="col-md-4">

                        <label style="font-size:11px; color:#94a3b8; font-weight:600;">
                            Aksi
                        </label>

                        <div style="
                        margin-top:8px;
                        display:flex;
                        gap:10px;
                    ">

                            {{-- FILTER BUTTON --}}
                            <button type="submit" style="
                                flex:1;
                                padding:11px;
                                border:none;
                                border-radius:12px;
                                background:linear-gradient(135deg,#3b82f6,#2563eb);
                                color:white;
                                font-weight:700;
                                display:flex;
                                justify-content:center;
                                align-items:center;
                                gap:8px;
                                transition:0.2s;
                                cursor:pointer;
                            " onmouseover="this.style.transform='translateY(-2px)'"
                                onmouseout="this.style.transform='translateY(0)'">
                                <i class="fas fa-filter"></i>
                                Filter
                            </button>

                            {{-- RESET --}}
                            <a href="{{ route('petugas.laporan.index') }}" style="
                                width:42px;
                                height:42px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                border-radius:12px;
                                background: rgba(2,6,23,0.9);
                                border:1px solid rgba(255,255,255,0.08);
                                color:#94a3b8;
                                text-decoration:none;
                                transition:0.2s;
                            " onmouseover="this.style.background='rgba(255,255,255,0.05)'"
                                onmouseout="this.style.background='rgba(2,6,23,0.9)'">
                                <i class="fas fa-rotate-left"></i>
                            </a>

                            {{-- PDF --}}
                            <a href="{{ route('petugas.laporan.cetak', ['tgl_mulai'=>$tgl_mulai,'tgl_selesai'=>$tgl_selesai]) }}"
                                target="_blank" style="
                                padding:11px 14px;
                                border-radius:12px;
                                background:linear-gradient(135deg,#ef4444,#dc2626);
                                color:white;
                                font-weight:700;
                                text-decoration:none;
                                display:flex;
                                align-items:center;
                                gap:8px;
                                transition:0.2s;
                            " onmouseover="this.style.transform='translateY(-2px)'"
                                onmouseout="this.style.transform='translateY(0)'">
                                <i class="fas fa-file-pdf"></i>
                                PDF
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <!-- TABLE -->
    <div style="
        background: rgba(15,23,42,0.7);
        backdrop-filter: blur(12px);
        border-radius:16px;
        border:1px solid rgba(255,255,255,0.08);
        overflow:hidden;
    ">

        <table class="table mb-0" style="color:#e5e7eb; width:100%; table-layout: fixed;">
            <thead>
                <tr style="background: rgba(255,255,255,0.03);">
                    <th style="width:5%; padding:20px;">NO</th>
                    <th style="width:20%;">Peminjam</th>
                    <th style="width:35%;">Alat</th>
                    <th style="width:20%;" class="text-center">Tanggal</th>
                    <th style="width:20%;" class="text-end">Denda</th>
                </tr>
            </thead>

            <tbody>
                @php $total_denda = 0; @endphp

                @forelse($laporans as $l)
                <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">

                    <td style="padding:20px;">{{ $loop->iteration }}</td>

                    <td>
                        <div style="font-weight:700; color:#e5e7eb;">
                            {{ $l->user->name ?? 'User' }}
                        </div>
                        <small style="color:#60a5fa;">#{{ $l->kode_peminjaman }}</small>
                    </td>

                    <td style="word-wrap: break-word;">
                        @foreach($l->detailPeminjaman as $detail)
                        <div style="font-size:13px; color:#94a3b8; margin-bottom:3px;">
                            • {{ $detail->alat->nama_alat ?? '-' }} ({{ $detail->jumlah }})
                        </div>
                        @endforeach
                    </td>

                    <td class="text-center">
                        <span style="background:#020617; padding:6px 10px; border-radius:8px;">
                            {{ \Carbon\Carbon::parse($l->tgl_kembali_real)->format('d/m/Y') }}
                        </span>
                    </td>

                    <td class="text-end">
                        <span style="
                            font-weight:800;
                            color: {{ $l->denda > 0 ? '#f87171' : '#22c55e' }};
                        ">
                            Rp {{ number_format($l->denda, 0, ',', '.') }}
                        </span>
                    </td>

                </tr>

                @php $total_denda += $l->denda; @endphp

                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:60px; color:#64748b;">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>

            @if($laporans->count() > 0)
            <tfoot>
                <tr style="background: rgba(255,255,255,0.03);">
                    <td colspan="4" class="text-end" style="padding:20px;">
                        Total Denda
                    </td>
                    <td class="text-end" style="padding:20px; color:#f87171; font-weight:900;">
                        Rp {{ number_format($total_denda, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
            @endif

        </table>
    </div>

</div>
@endsection