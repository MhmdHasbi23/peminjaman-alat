@extends('layouts.admin')

@section('content')
<div class="container" style="margin-top: 40px; max-width: 600px; font-family: sans-serif;">
    <div
        style="background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 35px; border: 1px solid #e3e6f0;">
        <h4
            style="margin-bottom: 25px; color: #3a3b45; font-weight: 700; border-bottom: 2px solid #f8f9fc; padding-bottom: 10px;">
            Tambah Alat Baru</h4>

        <form action="{{ route('admin.alat.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label
                    style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: #4e73df; text-transform: uppercase;">Nama
                    Alat</label>
                <input type="text" name="nama_alat"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px;"
                    placeholder="PC Client / Laptop" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label
                    style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: #4e73df; text-transform: uppercase;">Kategori</label>
                <select name="kategori_id"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px; background: white;"
                    required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label
                    style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: #4e73df; text-transform: uppercase;">Spesifikasi</label>
                <textarea name="spesifikasi" rows="3"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px;"
                    placeholder="Contoh: RAM 4GB, Processor 2.0 GHz" required></textarea>
            </div>

            <div style="margin-bottom: 25px;">
                <label
                    style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: #4e73df; text-transform: uppercase;">Stok
                    Alat</label>
                <input type="number" name="stok" min="0"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px;" required>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit"
                    style="flex: 2; background-color: #4e73df; color: white; border: none; padding: 14px; border-radius: 6px; cursor: pointer; font-weight: 700;">Simpan
                    Alat</button>
                <a href="{{ route('admin.alat.index') }}"
                    style="flex: 1; text-align: center; background-color: #eaecf4; color: #333; padding: 14px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 700;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection