@extends('layouts.peminjam')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: sans-serif;">
    <div class="mb-4">
        <h4 style="font-weight: 700; color: #333; margin: 0;">📅 Jadwalkan Peminjaman</h4>
        <p style="color: #858796; font-size: 13px;">Tentukan jadwal dan periksa kembali daftar alat Anda.</p>
    </div>

    @if(session('error'))
    <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 8px;">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('peminjam.pinjam.store') }}" method="POST">
        @csrf
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label style="font-size: 12px; font-weight: 700; color: #4e73df; letter-spacing: 0.5px;">TANGGAL MULAI
                    PINJAM</label>
                <input type="date" name="tgl_pinjam" class="form-control" required min="{{ date('Y-m-d') }}"
                    style="border-radius: 8px; border: 1px solid #d1d3e2; padding: 10px;">
            </div>
            <div class="col-md-6 mb-3">
                <label style="font-size: 12px; font-weight: 700; color: #4e73df; letter-spacing: 0.5px;">RENCANA TANGGAL
                    KEMBALI</label>
                <input type="date" name="tgl_kembali_rencana" class="form-control" required min="{{ date('Y-m-d') }}"
                    style="border-radius: 8px; border: 1px solid #d1d3e2; padding: 10px;">
            </div>
        </div>

        <div
            style="background: white; border-radius: 12px; border: 1px solid #e3e6f0; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f8f9fc; border-bottom: 2px solid #e3e6f0;">
                    <tr>
                        <th
                            style="padding: 15px; text-align: left; font-size: 12px; color: #4e73df; text-transform: uppercase;">
                            Nama Alat</th>
                        <th
                            style="padding: 15px; text-align: center; font-size: 12px; color: #4e73df; text-transform: uppercase;">
                            Jumlah</th>
                        <th
                            style="padding: 15px; text-align: center; font-size: 12px; color: #4e73df; text-transform: uppercase;">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cart as $id => $item)
                    <tr style="border-bottom: 1px solid #f1f3f9;">
                        <td style="padding: 15px;">
                            <span style="font-weight: 700; color: #3a3b45;">{{ $item['nama'] }}</span>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <span class="badge"
                                style="background: #eaecf4; color: #4e73df; padding: 6px 12px; border-radius: 6px; font-size: 13px;">
                                {{ $item['jumlah'] }} unit
                            </span>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <a href="{{ route('peminjam.cart.remove', $id) }}" class="btn btn-sm btn-outline-danger"
                                style="border-radius: 6px; padding: 5px 10px;" title="Hapus dari daftar">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding: 50px; text-align: center; color: #858796;">
                            <i class="fas fa-shopping-cart fa-3x mb-3" style="color: #ddd;"></i><br>
                            Daftar pinjam Anda masih kosong. <br>
                            <a href="{{ route('peminjam.alat.index') }}" class="btn btn-primary btn-sm mt-3">Cari
                                Alat</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(count($cart) > 0)
        <button type="submit" class="btn btn-success mt-4 w-100"
            style="font-weight: 700; padding: 15px; border-radius: 10px; box-shadow: 0 4px 10px rgba(28, 200, 138, 0.3); border: none;">
            <i class="fas fa-paper-plane"></i> KIRIM PENGAJUAN PINJAM
        </button>
        @endif

        <div class="text-center mt-3">
            <a href="{{ route('peminjam.alat.index') }}"
                style="text-decoration: none; color: #858796; font-size: 13px;">
                <i class="fas fa-arrow-left"></i> Kembali ke Katalog
            </a>
        </div>
    </form>
</div>
@endsection