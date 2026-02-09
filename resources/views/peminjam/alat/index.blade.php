@extends('layouts.peminjam')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: sans-serif;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 style="font-weight: 700; color: #333; margin: 0;">🛠️ Katalog Alat Tersedia</h4>
            <p style="color: #858796; font-size: 13px; margin: 0;">Pilih beberapa alat dan masukkan ke daftar pinjam.
            </p>

            @if(session('cart') && count(session('cart')) > 0)
            <a href="{{ route('peminjam.checkout') }}" class="btn btn-sm btn-success mt-2"
                style="border-radius: 20px; font-weight: 600;">
                <i class="fas fa-shopping-basket"></i> Lihat Daftar Pinjam ({{ count(session('cart')) }} Item)
            </a>
            @endif
        </div>

        <form action="{{ route('peminjam.alat.index') }}" method="GET" style="display: flex; gap: 8px;">
            <input type="text" name="search" placeholder="Cari alat..." value="{{ request('search') }}"
                style="padding: 10px 15px; border: 1px solid #d1d3e2; border-radius: 8px; outline: none; width: 250px; font-size: 14px;">
            <button type="submit"
                style="background: #4e73df; color: white; border: none; padding: 10px 18px; border-radius: 8px; cursor: pointer; transition: 0.3s;">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    @if(session('success'))
    <div
        style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb; font-size: 14px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div
        style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb; font-size: 14px;">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
    </div>
    @endif

    <div
        style="background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e3e6f0;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #f8f9fc; border-bottom: 2px solid #e3e6f0;">
                <tr>
                    <th
                        style="padding: 18px 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">
                        Info Alat</th>
                    <th
                        style="padding: 18px 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">
                        Kategori</th>
                    <th
                        style="padding: 18px 15px; text-align: center; color: #4e73df; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">
                        Stok Ready</th>
                    <th
                        style="padding: 18px 15px; text-align: center; color: #4e73df; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alats as $alat)
                <tr style="border-bottom: 1px solid #f1f3f9; transition: 0.2s;"
                    onmouseover="this.style.backgroundColor='#fcfdff'"
                    onmouseout="this.style.backgroundColor='transparent'">
                    <td style="padding: 18px 15px;">
                        <span
                            style="font-weight: 700; color: #3a3b45; font-size: 15px; display: block;">{{ $alat->nama_alat }}</span>
                        <small style="color: #858796; font-size: 12px;">{{ Str::limit($alat->spesifikasi, 60) }}</small>
                    </td>
                    <td style="padding: 18px 15px;">
                        <span
                            style="background: #f0f2f9; color: #4e73df; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;">
                            {{ $alat->kategori->nama_kategori }}
                        </span>
                    </td>
                    <td style="padding: 18px 15px; text-align: center;">
                        <span
                            style="font-size: 16px; font-weight: 700; color: {{ $alat->stok > 0 ? '#1cc88a' : '#e74a3b' }};">
                            {{ $alat->stok }}
                        </span>
                    </td>
                    <td style="padding: 18px 15px; text-align: center;">
                        <form action="{{ route('peminjam.cart.add') }}" method="POST"
                            style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                            @csrf
                            <input type="hidden" name="alat_id" value="{{ $alat->id }}">
                            <input type="number" name="jumlah" value="1" min="1" max="{{ $alat->stok }}"
                                style="width: 65px; padding: 6px; border-radius: 6px; border: 1px solid #d1d3e2; font-size: 13px; text-align: center; outline: none;">
                            <button type="submit"
                                style="background-color: #4e73df; color: white; padding: 8px 14px; border-radius: 8px; border: none; font-size: 12px; font-weight: 700; cursor: pointer; transition: 0.3s;"
                                onmouseover="this.style.backgroundColor='#2e59d9'"
                                onmouseout="this.style.backgroundColor='#4e73df'">
                                <i class="fas fa-plus-circle"></i> Pinjam
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 50px; text-align: center; color: #999;">
                        <i class="fas fa-box-open fa-3x mb-3" style="color: #ddd;"></i><br>
                        Maaf, alat tidak ditemukan atau sedang tidak tersedia.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 25px; display: flex; justify-content: center;">
        {{ $alats->appends(request()->input())->links() }}
    </div>
</div>
@endsection