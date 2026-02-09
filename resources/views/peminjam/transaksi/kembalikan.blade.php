@extends('layouts.peminjam')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: sans-serif;">
    <div class="mb-4">
        <h4 style="font-weight: 700; color: #333; margin: 0;">↩️ Pengembalian Alat</h4>
        <p style="color: #858796; font-size: 0.9rem;">Daftar alat di bawah ini harus segera dikembalikan ke petugas
            gudang.</p>
    </div>

    <div class="grid gap-4">
        @forelse($pinjamanAktif as $p)
        <div
            style="background: white; border-radius: 10px; border: 1px solid #e3e6f0; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div class="flex justify-between items-start">
                <div>
                    <span style="font-size: 11px; font-weight: 800; color: #1cc88a; text-transform: uppercase;">Status:
                        Sedang Dipinjam</span>
                    <h5 style="font-weight: 700; color: #4e73df; margin-top: 5px;">{{ $p->kode_peminjaman }}</h5>
                    <p style="font-size: 13px; color: #5a5c69; margin-bottom: 10px;">
                        Jadwal Kembali:
                        <strong>{{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d M Y') }}</strong>
                    </p>

                    <div style="background: #f8f9fc; border-radius: 8px; padding: 12px; border: 1px solid #eaecf4;">
                        <ul style="margin: 0; padding-left: 20px; font-size: 13px;">
                            @foreach($p->detailPeminjaman as $detail)
                            <li>{{ $detail->alat->nama_alat }} ({{ $detail->jumlah }} unit)</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div style="text-align: right;">
                    <div style="font-size: 11px; color: #858796;">Instruksi:</div>
                    <div style="font-size: 13px; font-weight: 600; color: #333;">Serahkan alat ke petugas <br> untuk
                        divalidasi.</div>
                </div>
            </div>
        </div>
        @empty
        <div
            style="text-align: center; padding: 50px; background: #f8f9fc; border-radius: 10px; border: 2px dashed #e3e6f0;">
            <p style="color: #858796;">Anda tidak memiliki pinjaman aktif yang perlu dikembalikan.</p>
            <a href="{{ route('peminjam.alat.index') }}"
                style="color: #4e73df; text-decoration: none; font-weight: 700;">Pinjam Alat Sekarang →</a>
        </div>
        @endforelse
    </div>
</div>
@endsection