@extends('layouts.admin')
@section('content')
<div class="container-fluid px-4" style="margin-top: 25px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 style="font-weight: 700; color: #333;">🏷️ Manajemen Kategori</h4>
        <a href="{{ route('admin.kategori.create') }}"
            style="background: #4e73df; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600;">+
            Kategori Baru</a>
    </div>

    @if(session('success'))
    <div
        style="background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
        {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div
        style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
        {{ session('error') }}</div>
    @endif

    <div
        style="background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e3e6f0;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f8f9fc; border-bottom: 2px solid #e3e6f0;">
                <tr>
                    <th style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px;">NO</th>
                    <th style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px;">NAMA KATEGORI</th>
                    <th style="padding: 15px; text-align: center; color: #4e73df; font-size: 12px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategoris as $kategori)
                <tr style="border-bottom: 1px solid #e3e6f0;">
                    <td style="padding: 15px;">{{ $loop->iteration }}</td>
                    <td style="padding: 15px; font-weight: 600;">{{ $kategori->nama_kategori }}</td>
                    <td style="padding: 15px; text-align: center;">
                        <a href="{{ route('admin.kategori.edit', $kategori->id) }}"
                            style="color: #4e73df; text-decoration: none; margin-right: 15px; font-size: 14px;">Edit</a>
                        <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST"
                            style="display:inline;" onsubmit="return confirm('Hapus kategori?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                style="background:none; border:none; color:#e74a3b; cursor:pointer; font-size:14px;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection