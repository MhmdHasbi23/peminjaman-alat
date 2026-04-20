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
            📜 Riwayat Peminjaman Saya
        </h4>
        <p style="color:#94a3b8; font-size:0.9rem; margin-top:6px;">
            Pantau status, jadwal, dan denda peminjaman Anda.
        </p>
    </div>

    {{-- ================= TABLE CARD ================= --}}
    <div style="
        background: rgba(255,255,255,0.03);
        border:1px solid rgba(255,255,255,0.06);
        border-radius:18px;
        overflow:hidden;
    ">

        <div class="table-responsive">

            <table style="width:100%; border-collapse:collapse; color:#cbd5e1;">

                {{-- ================= HEADER TABLE ================= --}}
                <thead>
                    <tr style="
                        background: rgba(255,255,255,0.02);
                        color:#94a3b8;
                        font-size:11px;
                        text-transform:uppercase;
                        letter-spacing:1px;
                    ">
                        <th style="padding:16px; text-align:left;">Kode & Periode</th>
                        <th style="padding:16px; text-align:left;">Alat</th>
                        <th style="padding:16px; text-align:center;">Status</th>
                        <th style="padding:16px; text-align:right;">Denda</th>
                    </tr>
                </thead>

                {{-- ================= BODY ================= --}}
                <tbody>

                    @forelse($riwayat as $r)

                    <tr style="
                        border-top:1px solid rgba(255,255,255,0.05);
                        transition:0.2s;
                    "
                    onmouseover="this.style.backgroundColor='rgba(255,255,255,0.02)'"
                    onmouseout="this.style.backgroundColor='transparent'">

                        {{-- KODE --}}
                        <td style="padding:16px;">

                            <div style="color:#93c5fd; font-weight:800;">
                                #{{ $r->kode_peminjaman }}
                            </div>

                            <div style="font-size:11px; color:#94a3b8; margin-top:5px;">
                                📅 {{ \Carbon\Carbon::parse($r->tgl_pinjam)->format('d M Y') }}
                                <br>
                                ↩ {{ \Carbon\Carbon::parse($r->tgl_kembali_rencana)->format('d M Y') }}
                            </div>

                        </td>

                        {{-- ALAT --}}
                        <td style="padding:16px;">

                            @foreach($r->detailPeminjaman as $detail)
                            <div style="
                                display:flex;
                                justify-content:space-between;
                                font-size:13px;
                                margin-bottom:4px;
                            ">
                                <span>
                                    <i class="fas fa-circle"
                                       style="font-size:6px; color:#60a5fa; margin-right:8px;"></i>
                                    {{ $detail->alat->nama_alat }}
                                </span>

                                <span style="
                                    background: rgba(96,165,250,0.12);
                                    color:#93c5fd;
                                    padding:2px 8px;
                                    border-radius:8px;
                                    font-size:11px;
                                    font-weight:600;">
                                    {{ $detail->jumlah }}x
                                </span>
                            </div>
                            @endforeach

                        </td>

                        {{-- STATUS --}}
                        <td style="padding:16px; text-align:center;">

                            @php
                            $statusStyle = match($r->status) {
                                'menunggu' => ['bg'=>'rgba(245,158,11,0.15)','text'=>'#fbbf24','icon'=>'fa-hourglass-half'],
                                'disetujui' => ['bg'=>'rgba(16,185,129,0.15)','text'=>'#34d399','icon'=>'fa-check-circle'],
                                'selesai' => ['bg'=>'rgba(99,102,241,0.15)','text'=>'#818cf8','icon'=>'fa-history'],
                                'ditolak' => ['bg'=>'rgba(239,68,68,0.15)','text'=>'#f87171','icon'=>'fa-times-circle'],
                                default => ['bg'=>'rgba(148,163,184,0.15)','text'=>'#cbd5e1','icon'=>'fa-info-circle']
                            };
                            @endphp

                            <span style="
                                background: {{ $statusStyle['bg'] }};
                                color: {{ $statusStyle['text'] }};
                                padding:6px 10px;
                                border-radius:10px;
                                font-size:10px;
                                font-weight:800;
                                text-transform:uppercase;
                                display:inline-flex;
                                align-items:center;
                                gap:6px;">
                                <i class="fas {{ $statusStyle['icon'] }}"></i>
                                {{ $r->status }}
                            </span>

                        </td>

                        {{-- DENDA --}}
                        <td style="padding:16px; text-align:right;">

                            <div style="
                                font-weight:800;
                                color: {{ $r->denda > 0 ? '#f87171' : '#34d399' }};
                                font-size:14px;">
                                Rp {{ number_format($r->denda, 0, ',', '.') }}
                            </div>

                            <div style="font-size:11px; color:#94a3b8;">
                                {{ $r->denda > 0 ? 'Terkena denda' : 'Bebas denda' }}
                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="4" style="padding:60px; text-align:center; color:#94a3b8;">

                            <i class="fas fa-history" style="font-size:40px; color:#334155;"></i>

                            <h5 style="color:#e2e8f0; margin-top:10px;">
                                Belum Ada Riwayat
                            </h5>

                            <p style="font-size:13px;">
                                Anda belum melakukan peminjaman alat.
                            </p>

                            <a href="{{ route('peminjam.alat.index') }}"
                                style="
                                    display:inline-block;
                                    margin-top:10px;
                                    padding:10px 16px;
                                    border-radius:12px;
                                    background: linear-gradient(135deg,#3b82f6,#2563eb);
                                    color:white;
                                    text-decoration:none;
                                    font-weight:700;">
                                Pinjam Sekarang
                            </a>

                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection