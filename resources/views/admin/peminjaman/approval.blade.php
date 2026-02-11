@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: 'Segoe UI', sans-serif;">
    <div class="mb-4">
        <h4 style="font-weight: 700; color: #333;">⚖️ Persetujuan Peminjaman</h4>
        <p style="color: #858796; font-size: 13px;">Tinjau dan proses permintaan peminjaman alat dari user.</p>
    </div>

    <div class="row">
        @forelse($peminjamans as $p)
        <div class="col-md-6 mb-4">
            <div
                style="background: white; border-radius: 10px; border-left: 5px solid #f6c23e; box-shadow: 0 4px 6px rgba(0,0,0,0.05); padding: 20px;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 style="font-weight: 700; color: #4e73df; margin-bottom: 2px;">{{ $p->kode_peminjaman }}</h6>
                        <p style="font-size: 14px; color: #333; margin-bottom: 10px;">Peminjam:
                            <strong>{{ $p->user->name }}</strong></p>
                    </div>
                    <span class="badge bg-warning text-dark" style="font-size: 10px;">PENDING</span>
                </div>

                <div style="background: #f8f9fc; padding: 10px; border-radius: 6px; margin-bottom: 15px;">
                    <small class="text-muted d-block mb-1">Daftar Alat:</small>
                    <ul class="list-unstyled mb-0" style="font-size: 13px;">
                        @foreach($p->detailPeminjaman as $d)
                        <li><i class="fas fa-tools text-secondary mr-2"></i> {{ $d->alat->nama_alat }} ({{ $d->jumlah }}
                            unit)</li>
                        @endforeach
                    </ul>
                </div>

                <div class="d-flex gap-2">
                    <form action="{{ route('admin.peminjaman.setujui', $p->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm w-100"
                            onclick="return confirm('Setujui peminjaman ini?')">
                            <i class="fas fa-check"></i> Setujui
                        </button>
                    </form>
                    <form action="{{ route('admin.peminjaman.tolak', $p->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm w-100"
                            onclick="return confirm('Tolak peminjaman ini?')">
                            <i class="fas fa-times"></i> Tolak
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" style="opacity: 0.3;">
            <p class="mt-3 text-muted">Tidak ada permohonan yang butuh persetujuan saat ini.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection