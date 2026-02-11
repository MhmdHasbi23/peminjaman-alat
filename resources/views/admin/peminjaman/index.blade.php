@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', 'Segoe UI', sans-serif;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 style="font-weight: 800; color: #1a202c; margin: 0; letter-spacing: -0.5px;">
                <i class="fas fa-chart-line me-2" style="color: #4e73df;"></i> Monitoring Transaksi
            </h4>
            <p style="color: #718096; font-size: 14px; margin: 5px 0 0 0;">Kelola dan pantau seluruh aktivitas sirkulasi
                alat secara real-time.</p>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-none d-md-block">
            <span class="badge"
                style="background: #ebf4ff; color: #3182ce; padding: 10px 15px; border-radius: 8px; font-weight: 600; border: 1px solid #bee3f8;">
                <i class="fas fa-clock me-1"></i> Update: {{ now()->format('H:i') }} WIB
            </span>
        </div>
    </div>

    @if(session('success'))
    <div class="alert border-0 shadow-sm mb-4" style="background: #def7ec; color: #03543f; border-radius: 12px;"
        role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <div
        style="background: white; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; overflow: hidden;">
        <div class="table-responsive">
            <table class="table mb-0" style="width: 100%; vertical-align: middle; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8fafc;">
                        <th
                            style="width: 25%; padding: 20px; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7;">
                            Kode & Peminjam</th>
                        <th
                            style="width: 15%; padding: 20px; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7;">
                            Status</th>
                        <th
                            style="width: 15%; padding: 20px; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7;">
                            Tgl Pinjam</th>
                        <th
                            style="width: 15%; padding: 20px; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7;">
                            Petugas</th>
                        <th
                            style="width: 30%; padding: 20px; text-align: center; color: #4a5568; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #edf2f7;">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $p)
                    <tr class="table-row-hover">
                        <td style="padding: 20px; border-bottom: 1px solid #edf2f7;">
                            <div class="d-flex align-items-center">
                                <div
                                    style="width: 40px; height: 40px; background: #f0f7ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                                    <i class="fas fa-file-invoice" style="color: #4299e1;"></i>
                                </div>
                                <div style="overflow: hidden;">
                                    <span
                                        style="display: block; font-weight: 700; color: #2d3748; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">#{{ $p->kode_peminjaman }}</span>
                                    <span
                                        style="display: block; font-size: 12px; color: #718096; font-weight: 500;">{{ $p->user->name ?? 'Guest' }}</span>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 20px; border-bottom: 1px solid #edf2f7;">
                            @php
                            $statusConfig = [
                            'menunggu' => ['bg' => '#fef3c7', 'text' => '#92400e', 'label' => 'Pending'],
                            'disetujui' => ['bg' => '#e0e7ff', 'text' => '#3730a3', 'label' => 'Dipinjam'],
                            'selesai' => ['bg' => '#d1fae5', 'text' => '#065f46', 'label' => 'Selesai'],
                            'ditolak' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'label' => 'Ditolak'],
                            ];
                            $style = $statusConfig[$p->status] ?? ['bg' => '#f3f4f6', 'text' => '#374151', 'label' =>
                            $p->status];
                            @endphp
                            <span
                                style="background-color: {{ $style['bg'] }}; color: {{ $style['text'] }}; padding: 6px 14px; border-radius: 8px; font-size: 11px; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; white-space: nowrap;">
                                <span
                                    style="width: 6px; height: 6px; background-color: currentColor; border-radius: 50%; margin-right: 8px;"></span>
                                {{ $style['label'] }}
                            </span>
                        </td>
                        <td style="padding: 20px; border-bottom: 1px solid #edf2f7;">
                            <div style="color: #4a5568; font-size: 13px; font-weight: 600; white-space: nowrap;">
                                <i class="far fa-calendar-check me-2" style="color: #cbd5e0;"></i>
                                {{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M, Y') }}
                            </div>
                        </td>
                        <td style="padding: 20px; border-bottom: 1px solid #edf2f7;">
                            <span
                                style="font-size: 13px; color: #4a5568; font-weight: 500; white-space: nowrap;">{{ $p->petugas->name ?? '—' }}</span>
                        </td>
                        <td style="padding: 20px; border-bottom: 1px solid #edf2f7;">
                            <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: nowrap;">
                                <a href="{{ route('admin.peminjaman.show', $p->id) }}" class="btn-action-view"
                                    title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                    <span>Detail</span>
                                </a>

                                <form action="{{ route('admin.peminjaman.destroy', $p->id) }}" method="POST"
                                    style="margin: 0; display: inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus transaksi ini?')"
                                        class="btn-action-delete" title="Hapus Data">
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 80px; text-align: center;">
                            <img src="https://illustrations.popsy.co/amber/empty-folder.svg" alt="Empty"
                                style="width: 120px; margin-bottom: 20px; opacity: 0.5;">
                            <p style="color: #a0aec0; font-size: 16px; font-weight: 500;">Belum ada data ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-between align-items-center">
        <p style="font-size: 13px; color: #718096; margin: 0;">Menampilkan {{ $peminjamans->firstItem() ?? 0 }} -
            {{ $peminjamans->lastItem() ?? 0 }} dari {{ $peminjamans->total() }} data</p>
        <div>{{ $peminjamans->links() }}</div>
    </div>
</div>

<style>
.table-row-hover:hover {
    background-color: #fcfdfe !important;
}

/* Desain tombol aksi dengan Flexbox agar Ikon & Teks Sejajar */
.btn-action-view,
.btn-action-delete {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 16px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    transition: all 0.2s;
    text-decoration: none;
    cursor: pointer;
    white-space: nowrap;
    /* Mencegah teks turun ke bawah */
}

/* Memberi jarak antara ikon dan teks */
.btn-action-view i,
.btn-action-delete i {
    margin-right: 8px;
    font-size: 14px;
}

/* Ukuran font keterangan */
.btn-action-view span,
.btn-action-delete span {
    font-size: 12px;
    font-weight: 700;
}

/* Warna Tombol Detail */
.btn-action-view {
    color: #4e73df;
}

.btn-action-view:hover {
    background: #4e73df !important;
    color: white !important;
    border-color: #4e73df;
    box-shadow: 0 4px 10px rgba(78, 115, 223, 0.15);
}

/* Warna Tombol Hapus */
.btn-action-delete {
    color: #e53e3e;
}

.btn-action-delete:hover {
    background: #e53e3e !important;
    color: white !important;
    border-color: #e53e3e;
    box-shadow: 0 4px 10px rgba(229, 62, 62, 0.15);
}
</style>
@endsection