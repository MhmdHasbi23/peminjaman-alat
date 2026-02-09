@extends('layouts.admin')
@section('content')
<div class="container" style="margin-top: 40px; max-width: 500px;">
    <div
        style="background: white; padding: 30px; border-radius: 12px; border: 1px solid #e3e6f0; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <h5 style="margin-bottom: 20px; font-weight: 700; color: #333;">Tambah Kategori</h5>
        <form action="{{ route('admin.kategori.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom: 8px; font-weight: 600; font-size: 13px;">Nama
                    Kategori</label>
                <input type="text" name="nama_kategori"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px;"
                    placeholder="Contoh: Alat Jaringan" required>
            </div>
            <button type="submit"
                style="width: 100%; background: #4e73df; color: white; padding: 12px; border: none; border-radius: 6px; font-weight: 700; cursor: pointer;">Simpan
                Kategori</button>
            <a href="{{ route('admin.kategori.index') }}"
                style="display: block; text-align: center; margin-top: 15px; color: #858796; text-decoration: none; font-size: 14px;">Batal</a>
        </form>
    </div>
</div>
@endsection