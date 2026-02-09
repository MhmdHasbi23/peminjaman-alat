@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: 'Segoe UI', sans-serif;">
    <div class="mb-4">
        <h4 style="font-weight: 700; color: #333; margin: 0;">🔄 Validasi Pengembalian</h4>
        <p style="color: #858796; font-size: 13px; margin: 0;">Proses pengembalian alat dan verifikasi denda
            keterlambatan.</p>
    </div>

    @if(session('success'))
    <div
        style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
        ✅ {{ session('success') }}
    </div>
    @endif

    <div
        style="background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e3e6f0;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #f8f9fc; border-bottom: 2px solid #e3e6f0;">
                <tr>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Peminjam</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Daftar Alat (Qty)</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Batas Kembali</th>
                    <th
                        style="padding: 15px; text-align: center; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $p)
                <tr style="border-bottom: 1px solid #e3e6f0;">
                    <td style="padding: 15px;">
                        <span style="font-weight: 600; color: #3a3b45;">{{ $p->user->name }}</span><br>
                        <span
                            style="background: #e8f5e9; color: #2e7d32; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 700;">
                            {{ $p->kode_peminjaman }}
                        </span>
                    </td>
                    <td style="padding: 15px;">
                        {{-- PERBAIKAN: Melakukan looping detailPeminjaman karena satu transaksi bisa banyak alat --}}
                        <ul style="margin: 0; padding-left: 15px; color: #4e73df; font-size: 13px;">
                            @foreach($p->detailPeminjaman as $detail)
                            <li>
                                <strong>{{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}</strong>
                                <span style="color: #333;">({{ $detail->jumlah }} unit)</span>
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td style="padding: 15px;">
                        <div
                            style="color: {{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->isPast() ? '#e74a3b' : '#3a3b45' }}; font-weight: 600;">
                            {{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d M Y') }}
                        </div>
                        @if(\Carbon\Carbon::parse($p->tgl_kembali_rencana)->isPast())
                        <small
                            style="color: white; background: #e74a3b; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 700;">TERLAMBAT</small>
                        @endif
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <a href="{{ route('petugas.pengembalian.cek', $p->id) }}"
                            style="background-color: #4e73df; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 700; font-size: 12px; display: inline-block; transition: 0.3s;">
                            <i class="fas fa-calculator"></i> Hitung Denda & Kembali
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 60px; text-align: center; color: #999;">
                        <i class="fas fa-box-open" style="font-size: 30px; margin-bottom: 10px; display: block;"></i>
                        Tidak ada alat yang sedang dipinjam saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Link Pagination --}}
    <div style="margin-top: 20px;">
        {{ $peminjamans->links() }}
    </div>
</div>
@endsection