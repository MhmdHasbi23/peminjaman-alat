@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', 'Segoe UI', sans-serif;">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 style="font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -0.5px;">
                <i class="fas fa-bell text-warning me-2"></i> Persetujuan Peminjaman
            </h4>
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Tinjau dan proses permintaan peminjaman alat
                dari siswa.</p>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <span class="badge"
                style="background: #fff3cd; color: #856404; padding: 10px 15px; border-radius: 10px; font-weight: 700;">
                <i class="fas fa-hourglass-half me-1"></i> {{ count($peminjamans) }} Antrean Menunggu
            </span>
        </div>
    </div>

    {{-- Alert Notifications --}}
    @if(session('success'))
    <div class="alert border-0 shadow-sm mb-4"
        style="background-color: #def7ec; color: #03543f; border-radius: 12px; padding: 15px 20px;">
        <i class="fas fa-check-circle me-2"></i> <strong>Berhasil!</strong> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert border-0 shadow-sm mb-4"
        style="background-color: #fde8e8; color: #9b1c1c; border-radius: 12px; padding: 15px 20px;">
        <i class="fas fa-exclamation-triangle me-2"></i> <strong>Peringatan:</strong> {{ session('error') }}
    </div>
    @endif

    {{-- Data Table Card --}}
    <div
        style="background: white; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.04); overflow: hidden; border: 1px solid #e2e8f0;">
        <table class="table mb-0"
            style="width: 100%; border-collapse: separate; border-spacing: 0; vertical-align: middle;">
            <thead>
                <tr style="background-color: #f8fafc;">
                    <th
                        style="padding: 20px; text-align: left; color: #475569; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 25%;">
                        Peminjam</th>
                    <th
                        style="padding: 20px; text-align: left; color: #475569; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 30%;">
                        Daftar Alat</th>
                    <th
                        style="padding: 20px; text-align: left; color: #475569; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 20%;">
                        Periode Pinjam</th>
                    <th
                        style="padding: 20px; text-align: center; color: #475569; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7; width: 25%;">
                        Konfirmasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $p)
                <tr style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#fcfdfe'"
                    onmouseout="this.style.backgroundColor='transparent'">
                    <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                        <div class="d-flex align-items-center">
                            <div
                                style="width: 40px; height: 40px; background: #f1f5f9; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-weight: 800; color: #4e73df;">
                                {{ strtoupper(substr($p->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <span
                                    style="font-weight: 700; color: #1e293b; display: block; font-size: 15px;">{{ $p->user->name }}</span>
                                <span
                                    style="font-family: 'JetBrains Mono', monospace; font-size: 11px; color: #4e73df; font-weight: 700; background: #ebf4ff; padding: 2px 6px; border-radius: 4px;">{{ $p->kode_peminjaman }}</span>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                        @foreach($p->detailPeminjaman as $detail)
                        <div
                            style="margin-bottom: 6px; display: flex; align-items: center; justify-content: space-between; background: #f8fafc; padding: 5px 10px; border-radius: 8px; border: 1px solid #f1f5f9;">
                            <span
                                style="font-size: 13px; color: #334155; font-weight: 500;">{{ $detail->alat->nama_alat }}</span>
                            <span
                                style="font-weight: 800; color: #4e73df; font-size: 12px;">x{{ $detail->jumlah }}</span>
                        </div>
                        @endforeach
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                        <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">
                            <i class="far fa-calendar-check me-1 text-success"></i> <strong>Mulai:</strong>
                            {{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') }}
                        </div>
                        <div style="font-size: 12px; color: #64748b;">
                            <i class="far fa-calendar-times me-1 text-danger"></i> <strong>Kembali:</strong> <span
                                style="color: #e53e3e; font-weight: 700;">{{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d M Y') }}</span>
                        </div>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                        <div style="display: flex; justify-content: center; gap: 10px;">
                            <form action="{{ route('petugas.peminjaman.setujui', $p->id) }}" method="POST"
                                style="margin: 0;">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Setujui peminjaman ini? Stok alat akan berkurang otomatis.')"
                                    style="background-color: #1cc88a; color: white; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 800; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; transition: 0.2s; box-shadow: 0 4px 6px rgba(28, 200, 138, 0.2);">
                                    <i class="fas fa-check me-1"></i> Setujui
                                </button>
                            </form>
                            <form action="{{ route('petugas.peminjaman.tolak', $p->id) }}" method="POST"
                                style="margin: 0;">
                                @csrf
                                <button type="submit" onclick="return confirm('Tolak peminjaman ini?')"
                                    style="background-color: #e74a3b; color: white; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 800; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; transition: 0.2s; box-shadow: 0 4px 6px rgba(231, 74, 59, 0.2);">
                                    <i class="fas fa-times me-1"></i> Tolak
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 80px; text-align: center;">
                        <div style="color: #cbd5e1; font-size: 4rem; margin-bottom: 15px;">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h6 style="color: #1e293b; font-weight: 800; margin-bottom: 5px;">Semua Beres!</h6>
                        <p style="color: #94a3b8; font-size: 14px; font-weight: 500;">Tidak ada antrean persetujuan
                            peminjaman saat ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
/* Tambahan efek hover pada tombol aksi */
button:hover {
    transform: translateY(-2px);
    filter: brightness(1.1);
}

button:active {
    transform: translateY(0);
}
</style>
@endsection