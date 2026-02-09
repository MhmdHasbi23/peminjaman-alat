@extends('layouts.peminjam')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: sans-serif;">
    <div class="mb-4">
        <h4 style="font-weight: 700; color: #333; margin: 0;">📜 Riwayat Peminjaman Saya</h4>
        <p style="color: #858796; font-size: 0.9rem;">Pantau status pengajuan dan jadwal pengembalian alat Anda.</p>
    </div>

    <div
        style="background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e3e6f0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #f8f9fc; border-bottom: 2px solid #e3e6f0;">
                <tr>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Kode & Tanggal</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Daftar Alat</th>
                    <th
                        style="padding: 15px; text-align: center; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Status</th>
                    <th
                        style="padding: 15px; text-align: right; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $r)
                <tr style="border-bottom: 1px solid #f1f3f9;">
                    <td style="padding: 15px;">
                        <span style="font-weight: 700; color: #333; display: block;">{{ $r->kode_peminjaman }}</span>
                        <small style="color: #858796;">Pinjam:
                            {{ \Carbon\Carbon::parse($r->tgl_pinjam)->format('d M Y') }}</small><br>
                        <small style="color: #e74a3b;">Kembali:
                            {{ \Carbon\Carbon::parse($r->tgl_kembali_rencana)->format('d M Y') }}</small>
                    </td>
                    <td style="padding: 15px;">
                        <ul style="margin: 0; padding-left: 15px; font-size: 13px; color: #5a5c69;">
                            @foreach($r->detailPeminjaman as $detail)
                            <li>{{ $detail->alat->nama_alat }} ({{ $detail->jumlah }} unit)</li>
                            @endforeach
                        </ul>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        @php
                        $bg = ['menunggu' => '#f6e05e', 'disetujui' => '#1cc88a', 'ditolak' => '#e74a3b', 'selesai' =>
                        '#4e73df'];
                        $color = $r->status == 'menunggu' ? '#856404' : '#fff';
                        @endphp
                        <span
                            style="background: {{ $bg[$r->status] }}; color: {{ $color }}; padding: 5px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; text-transform: uppercase;">
                            {{ $r->status }}
                        </span>
                    </td>
                    <td
                        style="padding: 15px; text-align: right; font-weight: 700; color: {{ $r->denda > 0 ? '#e74a3b' : '#1cc88a' }};">
                        Rp {{ number_format($r->denda, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 50px; text-align: center; color: #999;">
                        Belum ada riwayat peminjaman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection