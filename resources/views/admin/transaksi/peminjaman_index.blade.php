@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: 'Segoe UI', sans-serif;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 style="font-weight: 700; color: #333; margin: 0;">🔄 Peminjaman Aktif</h4>
            <p style="color: #718096; font-size: 0.9rem; margin: 0;">Daftar transaksi alat yang sedang dipinjam
                (Terintegrasi per Kode Transaksi).</p>
        </div>
        <a href="{{ route('admin.peminjaman.create') }}" class="btn"
            style="background-color: #4e73df; color: white; border-radius: 6px; padding: 10px 20px; text-decoration: none; font-weight: 600; font-size: 14px;">
            + Pinjam Alat Baru
        </a>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
    <div
        style="background-color: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #badbcc;">
        {{ session('success') }}
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
                        Detail Alat</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Waktu Pinjam</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Batas Kembali</th>
                    <th
                        style="padding: 15px; text-align: center; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop berdasarkan Group Kode Peminjaman --}}
                @forelse($peminjamans as $kode => $groupItems)
                @php
                $first = $groupItems->first();

                // SINKRONISASI: Menghitung total unit dari relasi detailPeminjaman
                $totalUnit = 0;
                foreach($groupItems as $p) {
                // Pastikan memanggil sum dari relasi detail, bukan kolom jumlah di header
                $totalUnit += $p->detailPeminjaman->sum('jumlah');
                }
                @endphp
                <tr style="border-bottom: 1px solid #e3e6f0;">
                    <td style="padding: 15px; vertical-align: top;">
                        <div style="font-weight: bold; color: #4e73df; font-size: 0.75rem; margin-bottom: 4px;">
                            {{ $kode }}
                        </div>
                        <span
                            style="font-weight: 600; color: #3a3b45;">{{ $first->user->name ?? 'User Tidak Ditemukan' }}</span>
                        <br>
                        <small style="color: #1cc88a; font-weight: bold;">Total: {{ $totalUnit }} unit</small>
                    </td>
                    <td style="padding: 15px; color: #6e707e;">
                        <ul style="margin: 0; padding-left: 15px; list-style-type: circle;">
                            @foreach($groupItems as $p)
                            @foreach($p->detailPeminjaman as $detail)
                            <li style="margin-bottom: 3px;">
                                {{-- Menggunakan null coalescing agar tidak error jika alat null --}}
                                {{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}
                                <span style="font-weight: bold; color: #333;">({{ $detail->jumlah }})</span>
                            </li>
                            @endforeach
                            @endforeach
                        </ul>
                    </td>
                    <td style="padding: 15px; color: #6e707e; vertical-align: top; font-size: 0.85rem;">
                        {{ \Carbon\Carbon::parse($first->tgl_pinjam)->format('d M Y') }}
                    </td>
                    <td style="padding: 15px; vertical-align: top; font-size: 0.85rem;">
                        <span
                            style="color: {{ \Carbon\Carbon::parse($first->tgl_kembali_rencana)->isPast() ? '#e74a3b' : '#6e707e' }}; font-weight: 600;">
                            {{ \Carbon\Carbon::parse($first->tgl_kembali_rencana)->format('d M Y') }}
                        </span>
                        @if(\Carbon\Carbon::parse($first->tgl_kembali_rencana)->isPast())
                        <br><small style="color: #e74a3b; font-weight: bold;">(Terlambat)</small>
                        @endif
                    </td>
                    <td style="padding: 15px; text-align: center; vertical-align: middle;">
                        <a href="{{ route('admin.peminjaman.konfirmasi', $kode) }}"
                            style="background-color: #1cc88a; color: white; border: none; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 11px; font-weight: 700; display: inline-block;">
                            Kembalikan Semua
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #a0aec0;">
                        Tidak ada transaksi peminjaman aktif.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection