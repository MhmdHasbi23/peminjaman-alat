@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', 'Segoe UI', sans-serif;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 style="font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -0.5px;">
                <i class="fas fa-file-contract text-primary me-2"></i> Laporan Pengembalian Alat
            </h4>
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Rekapitulasi dan audit data transaksi yang
                telah diselesaikan.</p>
        </div>
    </div>

    <div
        style="background: white; padding: 25px; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; margin-bottom: 25px;">
        <form action="{{ route('petugas.laporan.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label
                    style="font-size: 11px; font-weight: 800; color: #4e73df; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 8px;">Mulai
                    Tanggal</label>
                <input type="date" name="tgl_mulai" class="form-control" value="{{ $tgl_mulai }}"
                    style="border-radius: 8px; border: 1px solid #d1d3e2; padding: 10px;">
            </div>
            <div class="col-md-3">
                <label
                    style="font-size: 11px; font-weight: 800; color: #4e73df; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 8px;">Sampai
                    Tanggal</label>
                <input type="date" name="tgl_selesai" class="form-control" value="{{ $tgl_selesai }}"
                    style="border-radius: 8px; border: 1px solid #d1d3e2; padding: 10px;">
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1"
                        style="background: #4e73df; font-weight: 700; border-radius: 8px; padding: 10px; border: none;">
                        <i class="fas fa-filter me-2"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('petugas.laporan.index') }}" class="btn btn-light"
                        style="font-weight: 700; border-radius: 8px; padding: 10px; border: 1px solid #d1d3e2; color: #4e73df;">
                        <i class="fas fa-undo"></i>
                    </a>
                    <a href="{{ route('petugas.laporan.cetak', ['tgl_mulai' => $tgl_mulai, 'tgl_selesai' => $tgl_selesai]) }}"
                        target="_blank" class="btn btn-danger"
                        style="font-weight: 700; border-radius: 8px; padding: 10px 20px; border: none; background: #e74a3b;">
                        <i class="fas fa-file-pdf me-2"></i> Cetak PDF
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div
        style="background: white; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; overflow: hidden;">
        <table class="table mb-0"
            style="width: 100%; border-collapse: separate; border-spacing: 0; vertical-align: middle;">
            <thead>
                <tr style="background-color: #f8fafc;">
                    <th
                        style="padding: 20px; text-align: left; color: #475569; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #edf2f7; width: 50px;">
                        NO</th>
                    <th
                        style="padding: 20px; text-align: left; color: #475569; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #edf2f7;">
                        Peminjam & Kode</th>
                    <th
                        style="padding: 20px; text-align: left; color: #475569; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #edf2f7;">
                        Rincian Alat</th>
                    <th
                        style="padding: 20px; text-align: center; color: #475569; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #edf2f7;">
                        Tgl Kembali</th>
                    <th
                        style="padding: 20px; text-align: right; color: #475569; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #edf2f7;">
                        Denda</th>
                </tr>
            </thead>
            <tbody>
                @php $total_denda = 0; @endphp
                @forelse($laporans as $l)
                <tr style="transition: all 0.2s ease;">
                    <td style="padding: 20px; color: #94a3b8; font-weight: 700; border-bottom: 1px solid #f1f5f9;">
                        {{ $loop->iteration }}</td>
                    <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                        <span
                            style="display: block; font-family: 'JetBrains Mono', monospace; font-size: 11px; color: #4e73df; font-weight: 800;">#{{ $l->kode_peminjaman }}</span>
                        <span
                            style="font-weight: 700; color: #1e293b; font-size: 14px;">{{ $l->user->name ?? 'User Terhapus' }}</span>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                        @foreach($l->detailPeminjaman as $detail)
                        <div
                            style="font-size: 13px; color: #475569; margin-bottom: 4px; display: flex; align-items: center;">
                            <i class="fas fa-caret-right text-primary me-2" style="font-size: 10px;"></i>
                            {{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}
                            <span class="badge ms-2"
                                style="background: #f1f5f9; color: #475569; border-radius: 4px; font-size: 10px;">{{ $detail->jumlah }}
                                unit</span>
                        </div>
                        @endforeach
                    </td>
                    <td style="padding: 20px; text-align: center; border-bottom: 1px solid #f1f5f9;">
                        <div
                            style="font-size: 13px; font-weight: 700; color: #1e293b; background: #f8fafc; padding: 6px 10px; border-radius: 8px; display: inline-block; border: 1px solid #edf2f7;">
                            {{ \Carbon\Carbon::parse($l->tgl_kembali_real)->format('d/m/Y') }}
                        </div>
                    </td>
                    <td style="padding: 20px; text-align: right; border-bottom: 1px solid #f1f5f9;">
                        <span
                            style="font-weight: 800; color: {{ $l->denda > 0 ? '#e74a3b' : '#1cc88a' }}; font-size: 14px;">
                            Rp {{ number_format($l->denda, 0, ',', '.') }}
                        </span>
                    </td>
                </tr>
                @php $total_denda += $l->denda; @endphp
                @empty
                <tr>
                    <td colspan="5" style="padding: 80px; text-align: center;">
                        <div style="color: #cbd5e1; font-size: 3rem; margin-bottom: 15px;">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h6 style="color: #1e293b; font-weight: 800;">Tidak Ada Data</h6>
                        <p style="color: #94a3b8; font-size: 14px;">Tidak ditemukan transaksi selesai untuk periode yang
                            dipilih.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($laporans->count() > 0)
            <tfoot>
                <tr style="background-color: #f8fafc;">
                    <td colspan="4"
                        style="padding: 25px; text-align: right; font-weight: 800; color: #1e293b; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">
                        Total Pendapatan Denda:</td>
                    <td style="padding: 25px; text-align: right; font-weight: 900; color: #e74a3b; font-size: 18px;">
                        Rp {{ number_format($total_denda, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection