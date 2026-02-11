@extends('layouts.peminjam') {{-- Sesuaikan dengan layout peminjam Anda --}}

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: 'Inter', sans-serif;">
    
    {{-- Header Sapaan --}}
    <div class="mb-4">
        <h4 style="font-weight: 800; color: #1e293b; margin: 0;">👋 Halo, {{ auth()->user()->name }}!</h4>
        <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Mau pinjam alat apa hari ini? Pastikan untuk menjaga barang dengan baik ya.</p>
    </div>

    {{-- Statistik Singkat --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
        
        {{-- Card Alat Tersedia --}}
        <div style="background: white; padding: 25px; border-radius: 20px; border-bottom: 5px solid #4f46e5; box-shadow: 0 4px 6px rgba(0,0,0,0.02); position: relative;">
            <div style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Alat Tersedia</div>
            <div style="font-size: 2rem; font-weight: 800; color: #1e293b; margin-top: 10px;">{{ $total_alat }}</div>
            <div style="position: absolute; right: 25px; top: 35px; color: #4f46e5; opacity: 0.2; font-size: 30px;">
                <i class="fas fa-boxes-stacked"></i>
            </div>
        </div>

        {{-- Card Menunggu Persetujuan --}}
        <div style="background: white; padding: 25px; border-radius: 20px; border-bottom: 5px solid #f59e0b; box-shadow: 0 4px 6px rgba(0,0,0,0.02); position: relative;">
            <div style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Menunggu Approval</div>
            <div style="font-size: 2rem; font-weight: 800; color: #1e293b; margin-top: 10px;">{{ $pinjam_pending }}</div>
            <div style="position: absolute; right: 25px; top: 35px; color: #f59e0b; opacity: 0.2; font-size: 30px;">
                <i class="fas fa-clock-rotate-left"></i>
            </div>
        </div>

        {{-- Card Sedang Dipinjam --}}
        <div style="background: white; padding: 25px; border-radius: 20px; border-bottom: 5px solid #10b981; box-shadow: 0 4px 6px rgba(0,0,0,0.02); position: relative;">
            <div style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Sedang Dipinjam</div>
            <div style="font-size: 2rem; font-weight: 800; color: #1e293b; margin-top: 10px;">{{ $pinjam_aktif }}</div>
            <div style="position: absolute; right: 25px; top: 35px; color: #10b981; opacity: 0.2; font-size: 30px;">
                <i class="fas fa-hand-holding-box"></i>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Riwayat Terakhir --}}
        <div class="col-lg-8 mb-4">
            <div style="background: white; border-radius: 20px; padding: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #f1f5f9;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 style="font-weight: 800; color: #1e293b; margin: 0;">📜 Riwayat Peminjaman Terakhir</h6>
                    <a href="{{ route('peminjam.riwayat') }}" style="font-size: 12px; font-weight: 700; color: #4f46e5; text-decoration: none;">Lihat Semua</a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-borderless align-middle" style="font-size: 14px;">
                        <thead style="color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">
                            <tr>
                                <th>Kode</th>
                                <th>Alat</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Tgl Pinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_orders as $order)
                            <tr style="border-bottom: 1px solid #f8fafc;">
                                <td style="font-weight: 700; color: #4f46e5;">#{{ $order->kode_peminjaman }}</td>
                                <td style="color: #475569;">
                                    @foreach($order->detailPeminjaman as $d)
                                        <span class="badge bg-light text-dark font-normal" style="font-weight: 500;">{{ $d->alat->nama_alat }}</span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    @php
                                        $bg = ['menunggu'=>'#fef3c7', 'disetujui'=>'#dcfce7', 'ditolak'=>'#fee2e2', 'selesai'=>'#f1f5f9'];
                                        $color = ['menunggu'=>'#b45309', 'disetujui'=>'#15803d', 'ditolak'=>'#b91c1c', 'selesai'=>'#64748b'];
                                    @endphp
                                    <span style="background: {{ $bg[$order->status] }}; color: {{ $color[$order->status] }}; padding: 5px 12px; border-radius: 8px; font-size: 11px; font-weight: 700;">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>
                                <td class="text-end text-muted">{{ \Carbon\Carbon::parse($order->tgl_pinjam)->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada transaksi peminjaman.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Sidebar Action --}}
        <div class="col-lg-4">
            <div style="background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); border-radius: 20px; padding: 30px; color: white; text-align: center; box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2);">
                <i class="fas fa-plus-circle fa-3x mb-3"></i>
                <h5 style="font-weight: 700;">Butuh Alat?</h5>
                <p style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 25px;">Klik tombol di bawah untuk melihat katalog lengkap dan mulai meminjam.</p>
                <a href="{{ route('peminjam.alat.index') }}" class="btn btn-light w-100 py-2" style="border-radius: 12px; font-weight: 800; color: #4f46e5; border: none;">
                    Mulai Pinjam Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection