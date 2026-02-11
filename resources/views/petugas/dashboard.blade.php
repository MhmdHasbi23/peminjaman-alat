@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', 'Segoe UI', sans-serif;">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 style="font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -0.5px;">👋 Selamat Datang, Petugas!
            </h4>
            <p style="color: #64748b; font-size: 0.95rem; margin-top: 5px;">Ringkasan operasional gudang alat hari ini —
                <span style="font-weight: 600; color: #4e73df;">{{ now()->format('d M Y') }}</span>
            </p>
        </div>
        <div class="d-none d-md-block">
            <div
                style="background: white; padding: 10px 20px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0;">
                <span style="font-size: 0.85rem; font-weight: 600; color: #4e73df;"><i
                        class="fas fa-sync-alt fa-spin me-2"></i> Sistem Aktif</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div
                    style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; position: relative; overflow: hidden; height: 100%;">
                    <div
                        style="position: absolute; top: -10px; right: -10px; opacity: 0.05; font-size: 80px; color: #4e73df;">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div
                        style="font-size: 0.75rem; font-weight: 800; color: #4e73df; text-transform: uppercase; letter-spacing: 1px;">
                        Antrean Approval
                    </div>
                    <div style="font-size: 2.5rem; font-weight: 800; color: #1e293b; margin: 10px 0;">
                        {{ $perlu_approval }}</div>
                    <a href="{{ route('petugas.peminjaman.index') }}" class="btn btn-sm"
                        style="background: #eef2ff; color: #4e73df; font-weight: 700; border-radius: 8px; font-size: 0.75rem; padding: 8px 20px;">
                        Lihat Antrean <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div
                    style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; position: relative; overflow: hidden; height: 100%;">
                    <div
                        style="position: absolute; top: -10px; right: -10px; opacity: 0.05; font-size: 80px; color: #1cc88a;">
                        <i class="fas fa-hand-holding"></i>
                    </div>
                    <div
                        style="font-size: 0.75rem; font-weight: 800; color: #1cc88a; text-transform: uppercase; letter-spacing: 1px;">
                        Sedang Dipinjam
                    </div>
                    <div style="font-size: 2.5rem; font-weight: 800; color: #1e293b; margin: 10px 0;">
                        {{ $sedang_dipinjam }}</div>
                    <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-sm"
                        style="background: #ecfdf5; color: #1cc88a; font-weight: 700; border-radius: 8px; font-size: 0.75rem; padding: 8px 20px;">
                        Validasi Kembali <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div
                    style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; position: relative; overflow: hidden; height: 100%;">
                    <div
                        style="position: absolute; top: -10px; right: -10px; opacity: 0.05; font-size: 80px; color: #f6c23e;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div
                        style="font-size: 0.75rem; font-weight: 800; color: #f6c23e; text-transform: uppercase; letter-spacing: 1px;">
                        Jatuh Tempo
                    </div>
                    <div style="font-size: 2.5rem; font-weight: 800; color: #1e293b; margin: 10px 0;">
                        {{ $kembali_hari_ini }}</div>
                    <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">
                        <i class="fas fa-exclamation-circle me-1"></i> Segera cek pengembalian
                    </span>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div
                    style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; position: relative; overflow: hidden; height: 100%;">
                    <div
                        style="position: absolute; top: -10px; right: -10px; opacity: 0.05; font-size: 80px; color: #36b9cc;">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div
                        style="font-size: 0.75rem; font-weight: 800; color: #36b9cc; text-transform: uppercase; letter-spacing: 1px;">
                        Inventaris Siap
                    </div>
                    <div style="font-size: 2.5rem; font-weight: 800; color: #1e293b; margin: 10px 0;">{{ $total_alat }}
                    </div>
                    <a href="{{ route('petugas.alat.index') }}" class="btn btn-sm"
                        style="background: #e1f5fe; color: #36b9cc; font-weight: 700; border-radius: 8px; font-size: 0.75rem; padding: 8px 20px;">
                        Cek Inventaris <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div
        style="background: white; border-radius: 20px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; overflow: hidden; margin-top: 10px;">
        <div
            style="padding: 20px 25px; border-bottom: 1px solid #f1f5f9; background: #ffffff; display: flex; align-items: center; justify-content: space-between;">
            <h6 style="font-weight: 800; color: #1e293b; margin: 0; font-size: 1rem;"><i
                    class="fas fa-bolt text-warning me-2"></i> Aktivitas Terbaru</h6>
            <span class="badge"
                style="background: #f1f5f9; color: #475569; padding: 8px 12px; border-radius: 8px; font-weight: 600;">{{ count($recent_activities) }}
                Aktivitas</span>
        </div>

        <div class="table-responsive">
            <table class="table mb-0" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                <tbody style="background: white;">
                    @forelse($recent_activities as $ra)
                    <tr style="transition: all 0.2s ease;" onmouseover="this.style.background='#f8fafc'"
                        onmouseout="this.style.background='white'">
                        <td style="padding: 20px 25px; vertical-align: middle;">
                            <div class="d-flex align-items-center">
                                <div
                                    style="width: 45px; height: 45px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-weight: 800; color: #4e73df; font-size: 1.2rem;">
                                    {{ substr($ra->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <span
                                        style="font-weight: 700; color: #1e293b; display: block; font-size: 0.95rem;">{{ $ra->user->name }}</span>
                                    <span style="color: #64748b; font-size: 0.85rem;">Peminjaman: <span
                                            style="font-weight: 700; color: #4e73df;">#{{ $ra->kode_peminjaman }}</span></span>
                                </div>
                            </div>
                            <div style="margin-top: 12px; display: flex; flex-wrap: wrap; gap: 8px;">
                                @foreach($ra->detailPeminjaman as $detail)
                                <span
                                    style="background: #ffffff; color: #334155; padding: 4px 12px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; border: 1px solid #e2e8f0; display: inline-flex; align-items: center;">
                                    <i class="fas fa-cube me-1 text-primary" style="font-size: 0.6rem;"></i>
                                    {{ $detail->alat->nama_alat }} ({{ $detail->jumlah }})
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td style="padding: 20px 25px; text-align: right; vertical-align: middle;">
                            @php
                            $status_bg = $ra->status == 'menunggu' ? '#fef3c7' : ($ra->status == 'disetujui' ? '#d1fae5'
                            : '#fee2e2');
                            $status_color = $ra->status == 'menunggu' ? '#92400e' : ($ra->status == 'disetujui' ?
                            '#065f46' : '#991b1b');
                            @endphp
                            <span
                                style="background: {{ $status_bg }}; color: {{ $status_color }}; padding: 6px 16px; border-radius: 8px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                                {{ $ra->status }}
                            </span>
                        </td>
                        <td
                            style="padding: 20px 25px; text-align: right; color: #94a3b8; font-size: 0.8rem; vertical-align: middle; white-space: nowrap;">
                            <i class="far fa-clock me-1"></i> {{ $ra->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding: 60px; text-align: center;">
                            <div style="color: #cbd5e1; font-size: 4rem; margin-bottom: 15px;"><i
                                    class="fas fa-folder-open"></i></div>
                            <p style="color: #94a3b8; font-weight: 600;">Belum ada aktivitas peminjaman hari ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection