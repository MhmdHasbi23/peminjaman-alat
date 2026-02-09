@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: 'Segoe UI', sans-serif;">
    <h4 style="font-weight: 700; color: #333; margin-bottom: 20px;">🔔 Persetujuan Peminjaman</h4>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
    <div
        style="background-color: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #badbcc;">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Notifikasi Error (Penting jika stok tiba-tiba habis) --}}
    @if(session('error'))
    <div
        style="background-color: #f8d7da; color: #842029; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f5c2c7;">
        ⚠️ {{ session('error') }}
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
                        Daftar Alat & Jumlah</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Jadwal Pinjam</th>
                    <th
                        style="padding: 15px; text-align: center; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $p)
                <tr style="border-bottom: 1px solid #e3e6f0;">
                    <td style="padding: 15px;">
                        <span style="font-weight: 600; color: #3a3b45; font-size: 15px;">{{ $p->user->name }}</span><br>
                        <span
                            style="background: #f1f3f9; color: #5a5c69; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700;">
                            {{ $p->kode_peminjaman }}
                        </span>
                    </td>
                    <td style="padding: 15px;">
                        <ul style="margin: 0; padding-left: 18px; color: #333; font-size: 14px;">
                            @foreach($p->detailPeminjaman as $detail)
                            <li style="margin-bottom: 3px;">
                                {{ $detail->alat->nama_alat }}
                                <span style="font-weight: 700; color: #4e73df;">x{{ $detail->jumlah }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td style="padding: 15px; font-size: 13px; color: #5a5c69;">
                        <div style="margin-bottom: 4px;"><strong>Mulai:</strong>
                            {{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') }}</div>
                        <div><strong>Kembali:</strong> <span
                                style="color: #e74a3b; font-weight: 600;">{{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d M Y') }}</span>
                        </div>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 8px;">
                            <form action="{{ route('petugas.peminjaman.setujui', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Apakah Anda yakin ingin MENYETUJUI peminjaman ini? Stok akan otomatis berkurang.')"
                                    style="background-color: #1cc88a; color: white; border: none; padding: 8px 15px; border-radius: 6px; font-weight: 700; font-size: 12px; cursor: pointer; transition: 0.3s;">
                                    Setujui
                                </button>
                            </form>
                            <form action="{{ route('petugas.peminjaman.tolak', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Apakah Anda yakin ingin MENOLAK peminjaman ini?')"
                                    style="background-color: #e74a3b; color: white; border: none; padding: 8px 15px; border-radius: 6px; font-weight: 700; font-size: 12px; cursor: pointer; transition: 0.3s;">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 60px; text-align: center;">
                        <div style="color: #d1d3e2; font-size: 40px; margin-bottom: 10px;"><i
                                class="fas fa-clipboard-check"></i></div>
                        <span style="color: #b7b9cc; font-weight: 600;">Tidak ada antrean persetujuan saat ini.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection