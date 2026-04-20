@extends('layouts.peminjam')

@section('content')
<div style="
    width: 100%;
    min-height: calc(100vh - 70px);
    padding: 25px;
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
">

    {{-- ================= HEADER ================= --}}
    <div style="margin-bottom: 20px;">

        <h4 style="font-weight: 800; color: #e2e8f0; margin: 0;">
            📅 Jadwalkan Peminjaman
        </h4>

        <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 6px;">
            Atur waktu dan cek kembali alat sebelum mengajukan peminjaman.
        </p>

    </div>

    <form action="{{ route('peminjam.pinjam.store') }}" method="POST">
        @csrf

        {{-- ================= GRID LAYOUT (FULL WIDTH TERSTRUKTUR) ================= --}}
        <div style="display: grid; grid-template-columns: 1fr; gap: 18px;">

            {{-- ================= CARD 1: DATE ================= --}}
            <div style="
                background: rgba(255,255,255,0.03);
                border: 1px solid rgba(255,255,255,0.06);
                border-radius: 18px;
                padding: 20px;
            ">

                <h6 style="color:#e2e8f0; margin-bottom:15px; font-weight:700;">
                    🗓️ Jadwal Peminjaman
                </h6>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">

                    <div>
                        <label style="color:#93c5fd; font-size:11px; font-weight:700;">
                            Tanggal Pinjam
                        </label>

                        <input type="date" name="tgl_pinjam" required min="{{ date('Y-m-d') }}"
                            style="width:100%; margin-top:8px;
                            background: rgba(255,255,255,0.05);
                            border:1px solid rgba(255,255,255,0.08);
                            color:#e2e8f0;
                            padding:12px;
                            border-radius:12px;">
                    </div>

                    <div>
                        <label style="color:#fca5a5; font-size:11px; font-weight:700;">
                            Tanggal Kembali
                        </label>

                        <input type="date" name="tgl_kembali_rencana" required min="{{ date('Y-m-d') }}"
                            style="width:100%; margin-top:8px;
                            background: rgba(255,255,255,0.05);
                            border:1px solid rgba(255,255,255,0.08);
                            color:#e2e8f0;
                            padding:12px;
                            border-radius:12px;">
                    </div>

                </div>
            </div>

            {{-- ================= CARD 2: CART ================= --}}
            <div style="
                background: rgba(255,255,255,0.03);
                border: 1px solid rgba(255,255,255,0.06);
                border-radius: 18px;
                overflow: hidden;
            ">

                <div style="padding:18px; border-bottom:1px solid rgba(255,255,255,0.06);">
                    <h6 style="color:#e2e8f0; margin:0; font-weight:700;">
                        🧾 Daftar Alat Dipinjam
                    </h6>
                </div>

                <div class="table-responsive">

                    <table class="table mb-0" style="color:#cbd5e1; width:100%;">

                        <thead>
                            <tr style="color:#94a3b8; font-size:12px;">
                                <th style="padding:14px;">Nama Alat</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($cart as $id => $item)
                            <tr style="border-top:1px solid rgba(255,255,255,0.05);">

                                <td style="padding:16px;">
                                    <i class="fas fa-toolbox" style="color:#60a5fa; margin-right:8px;"></i>
                                    {{ $item['nama'] }}
                                </td>

                                <td class="text-center">
                                    <span style="
                                        background: rgba(96,165,250,0.12);
                                        padding:6px 12px;
                                        border-radius:10px;
                                        color:#93c5fd;
                                        font-weight:600;">
                                        {{ $item['jumlah'] }} unit
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('peminjam.cart.remove', $id) }}"
                                        style="color:#f87171;">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-5" style="color:#64748b;">
                                    <i class="fas fa-box-open fa-2x mb-2"></i><br>
                                    Keranjang kosong
                                </td>
                            </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>
            </div>

        </div>

        {{-- ================= ACTION BUTTON ================= --}}
        @if(count($cart) > 0)
        <div style="margin-top:20px;">
            <button type="submit"
                style="
                    width:100%;
                    padding:15px;
                    border:none;
                    border-radius:14px;
                    background: linear-gradient(135deg,#3b82f6,#2563eb);
                    color:white;
                    font-weight:700;
                ">
                🚀 Kirim Pengajuan Peminjaman
            </button>
        </div>
        @endif

    </form>
</div>
@endsection