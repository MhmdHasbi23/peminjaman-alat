@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: sans-serif;">
    <div class="mb-4">
        <h4 style="font-weight: 700; color: #333; margin: 0;">👋 Selamat Datang, Petugas!</h4>
        <p style="color: #858796; font-size: 0.9rem;">Berikut adalah ringkasan operasional gudang alat hari ini.</p>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div
                style="background: white; border-left: 5px solid #4e73df; border-radius: 8px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <div style="font-size: 11px; font-weight: 800; color: #4e73df; text-transform: uppercase;">Perlu
                    Persetujuan</div>
                <div style="font-size: 24px; font-weight: 700; color: #5a5c69;">{{ $perlu_approval }}</div>
                <a href="{{ route('petugas.peminjaman.index') }}"
                    style="font-size: 12px; color: #4e73df; text-decoration: none;">Lihat Antrean →</a>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div
                style="background: white; border-left: 5px solid #1cc88a; border-radius: 8px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <div style="font-size: 11px; font-weight: 800; color: #1cc88a; text-transform: uppercase;">Sedang
                    Dipinjam</div>
                <div style="font-size: 24px; font-weight: 700; color: #5a5c69;">{{ $sedang_dipinjam }}</div>
                <a href="{{ route('petugas.pengembalian.index') }}"
                    style="font-size: 12px; color: #1cc88a; text-decoration: none;">Validasi Kembali →</a>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div
                style="background: white; border-left: 5px solid #f6e05e; border-radius: 8px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <div style="font-size: 11px; font-weight: 800; color: #f6c23e; text-transform: uppercase;">Jatuh Tempo
                    Hari Ini</div>
                <div style="font-size: 24px; font-weight: 700; color: #5a5c69;">{{ $kembali_hari_ini }}</div>
                <div style="font-size: 12px; color: #858796;">Segera cek pengembalian</div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div
                style="background: white; border-left: 5px solid #36b9cc; border-radius: 8px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <div style="font-size: 11px; font-weight: 800; color: #36b9cc; text-transform: uppercase;">Total Stok
                    Tersedia</div>
                <div style="font-size: 24px; font-weight: 700; color: #5a5c69;">{{ $total_alat }}</div>
                <a href="{{ route('petugas.alat.index') }}"
                    style="font-size: 12px; color: #36b9cc; text-decoration: none;">Cek Inventaris →</a>
            </div>
        </div>
    </div>

    <div
        style="background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e3e6f0; overflow: hidden; margin-top: 10px;">
        <div
            style="background: #f8f9fc; padding: 15px; border-bottom: 1px solid #e3e6f0; font-weight: 700; color: #4e73df;">
            ⚡ Aktivitas Peminjaman Terbaru
        </div>
        <table style="width: 100%; border-collapse: collapse;">
            <tbody>
                @forelse($recent_activities as $ra)
                <tr style="border-bottom: 1px solid #f1f3f9;">
                    <td style="padding: 15px;">
                        <span style="font-weight: 600; color: #3a3b45; display: block;">{{ $ra->user->name }}</span>
                        <span style="color: #858796; font-size: 13px;">mengajukan peminjaman dengan kode: </span>
                        <span style="font-weight: 700; color: #333; font-size: 13px;">{{ $ra->kode_peminjaman }}</span>

                        <div style="margin-top: 8px; display: flex; flex-wrap: wrap; gap: 5px;">
                            @foreach($ra->detailPeminjaman as $detail)
                            <span
                                style="background: #eaecf4; color: #4e73df; padding: 3px 10px; border-radius: 4px; font-size: 11px; font-weight: 700; border: 1px solid #d1d3e2;">
                                {{ $detail->alat->nama_alat }} ({{ $detail->jumlah }})
                            </span>
                            @endforeach
                        </div>
                    </td>
                    <td style="padding: 15px; text-align: right; vertical-align: middle;">
                        <span
                            style="background: {{ $ra->status == 'menunggu' ? '#f6e05e' : ($ra->status == 'disetujui' ? '#1cc88a' : '#e74a3b') }}; 
                                     color: {{ $ra->status == 'menunggu' ? '#856404' : '#fff' }}; 
                                     padding: 5px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; text-transform: uppercase;">
                            {{ $ra->status }}
                        </span>
                    </td>
                    <td
                        style="padding: 15px; text-align: right; color: #858796; font-size: 12px; vertical-align: middle; white-space: nowrap;">
                        <i class="far fa-clock"></i> {{ $ra->created_at->diffForHumans() }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="padding: 40px; text-align: center; color: #858796;">
                        Belum ada aktivitas peminjaman terbaru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection