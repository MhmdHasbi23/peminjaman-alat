@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: sans-serif;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 style="font-weight: 600; color: #333; margin: 0;">📦 Inventaris Alat</h4>
        <a href="{{ route('admin.alat.create') }}" class="btn"
            style="background-color: #4e73df; color: white; border-radius: 6px; padding: 10px 20px; text-decoration: none; font-weight: 600; font-size: 14px;">
            + Tambah Alat
        </a>
    </div>

    @if(session('success'))
    <div
        style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
        {{ session('success') }}
    </div>
    @endif

    <div
        style="background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e3e6f0;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #f8f9fc; border-bottom: 2px solid #e3e6f0;">
                <tr>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        No</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Nama Alat</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Kategori</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Stok</th>
                    <th
                        style="padding: 15px; text-align: center; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alats as $alat)
                <tr style="border-bottom: 1px solid #e3e6f0;">
                    <td style="padding: 15px; color: #6e707e;">
                        {{ ($alats->currentPage() - 1) * $alats->perPage() + $loop->iteration }}</td>
                    <td style="padding: 15px; font-weight: 600; color: #3a3b45;">
                        {{ $alat->nama_alat }}<br>
                        <small style="color: #999; font-weight: 400;">{{ Str::limit($alat->spesifikasi, 50) }}</small>
                    </td>
                    <td style="padding: 15px; color: #6e707e;">{{ $alat->kategori->nama_kategori }}</td>
                    <td style="padding: 15px;">
                        <span
                            style="background-color: #eaecf4; color: #4e73df; padding: 4px 10px; border-radius: 4px; font-weight: 700;">
                            {{ $alat->stok }}
                        </span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 8px;">
                            <a href="{{ route('admin.alat.edit', $alat->id) }}"
                                style="background-color: #f8f9fc; color: #4e73df; border: 1px solid #d1d3e2; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600;">Edit</a>
                            <form action="{{ route('admin.alat.destroy', $alat->id) }}" method="POST"
                                onsubmit="return confirm('Hapus alat ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    style="background-color: #fff; color: #e74a3b; border: 1px solid #e74a3b; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 600;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 20px;">
        {{ $alats->links() }}
    </div>
</div>
@endsection