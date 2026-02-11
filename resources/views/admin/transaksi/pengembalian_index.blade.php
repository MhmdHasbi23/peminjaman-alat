@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: 'Segoe UI', sans-serif;">
    <div class="mb-4">
        <h4 style="font-weight: 700; color: #333; margin: 0;">↩️ Riwayat Pengembalian</h4>
        <p style="color: #718096; font-size: 0.9rem; margin: 0;">Catatan lengkap alat yang sudah dikembalikan ke
            inventaris.</p>
    </div>

    <div
        style="background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e3e6f0; border-top: 4px solid #1cc88a;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #f8f9fc; border-bottom: 2px solid #e3e6f0;">
                <tr>
                    <th
                        style="padding: 15px; text-align: left; color: #1cc88a; font-size: 12px; text-transform: uppercase;">
                        Peminjam</th>
                    <th
                        style="padding: 15px; text-align: left; color: #1cc88a; font-size: 12px; text-transform: uppercase;">
                        Rincian Alat</th>
                    <th
                        style="padding: 15px; text-align: left; color: #1cc88a; font-size: 12px; text-transform: uppercase;">
                        Tgl Kembali</th>
                    <th
                        style="padding: 15px; text-align: left; color: #1cc88a; font-size: 12px; text-transform: uppercase;">
                        Denda</th>
                    <th
                        style="padding: 15px; text-align: left; color: #1cc88a; font-size: 12px; text-transform: uppercase;">
                        Petugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengembalians as $pk)
                <tr style="border-bottom: 1px solid #e3e6f0;">
                    <td style="padding: 15px; vertical-align: top;">
                        <span
                            style="font-size: 10px; font-weight: bold; color: #4e73df; display: block;">{{ $pk->peminjaman->kode_peminjaman }}</span>
                        <span
                            style="font-weight: 600; color: #3a3b45;">{{ $pk->peminjaman->user->name ?? 'User Tidak Ditemukan' }}</span>
                    </td>
                    <td style="padding: 15px; color: #6e707e; vertical-align: top;">
                        {{-- PERBAIKAN: Looping detailPeminjaman karena data alat ada di tabel detail --}}
                        <ul style="margin: 0; padding-left: 15px; font-size: 13px;">
                            @foreach($pk->peminjaman->detailPeminjaman as $detail)
                            <li>{{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}
                                <strong>({{ $detail->jumlah }})</strong></li>
                            @endforeach
                        </ul>
                    </td>
                    <td style="padding: 15px; color: #6e707e; vertical-align: top;">
                        {{ \Carbon\Carbon::parse($pk->tgl_kembali_aktual)->format('d M Y') }}
                    </td>
                    <td style="padding: 15px; vertical-align: top;">
                        <span style="color: {{ $pk->denda > 0 ? '#e74a3b' : '#1cc88a' }}; font-weight: 700;">
                            Rp {{ number_format($pk->denda, 0, ',', '.') }}
                        </span>
                    </td>
                    <td style="padding: 15px; vertical-align: top;">
                        <span
                            style="font-size: 11px; background-color: #f1f4f9; padding: 4px 8px; border-radius: 4px; color: #4e73df; font-weight: 600;">
                            {{ $pk->petugas->name ?? 'Sistem' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #a0aec0;">Belum ada riwayat
                        pengembalian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $pengembalians->links() }}
    </div>
</div>
@endsection