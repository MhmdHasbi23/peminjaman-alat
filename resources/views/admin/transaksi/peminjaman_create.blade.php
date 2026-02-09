@extends('layouts.admin')

@section('content')
<div class="container" style="margin-top: 40px; max-width: 800px; font-family: 'Segoe UI', sans-serif;">
    <div
        style="background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 35px; border: 1px solid #e3e6f0;">
        <h4 style="margin-bottom: 30px; color: #3a3b45; font-weight: 700; text-align: center;">Form Peminjaman Alat</h4>

        {{-- Menampilkan Pesan Error jika stok kurang atau validasi gagal [cite: 62] --}}
        @if(session('error'))
        <div
            style="background-color: #f8d7da; color: #842029; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f5c2c7;">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('admin.peminjaman.store') }}" method="POST">
            @csrf

            {{-- Nama Peminjam (User dengan role Peminjam) [cite: 30] --}}
            <div style="margin-bottom: 25px;">
                <label
                    style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: #4e73df; text-transform: uppercase;">Pilih
                    Peminjam</label>
                <select name="user_id"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px; background-color: white;"
                    required>
                    <option value="" disabled selected>-- Pilih Akun Peminjam --</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <hr style="border-top: 1px dashed #d1d3e2; margin-bottom: 25px;">

            {{-- Container untuk baris Alat (Dynamic Rows) --}}
            <div id="container-alat">
                <label
                    style="display: block; margin-bottom: 12px; font-size: 13px; font-weight: 700; color: #4e73df; text-transform: uppercase;">Daftar
                    Alat & Jumlah</label>

                {{-- Baris Alat Pertama --}}
                <div class="item-alat" style="display: flex; gap: 10px; margin-bottom: 15px; align-items: flex-end;">
                    <div style="flex: 2;">
                        <small style="color: #858796;">Pilih Alat</small>
                        <select name="alat_id[]"
                            style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px; background-color: white;"
                            required>
                            <option value="" disabled selected>-- Pilih Alat --</option>
                            @foreach($alats as $alat)
                            <option value="{{ $alat->id }}">{{ $alat->nama_alat }} (Stok: {{ $alat->stok }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <small style="color: #858796;">Jumlah</small>
                        <input type="number" name="jumlah[]" min="1" value="1"
                            style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px;" required>
                    </div>
                    <div style="flex: 0.2;">
                        {{-- Tombol Hapus (Sembunyi di baris pertama) --}}
                        <button type="button" class="btn-hapus"
                            style="background: #e74a3b; color: white; border: none; padding: 12px 15px; border-radius: 6px; cursor: pointer; visibility: hidden;">&times;</button>
                    </div>
                </div>
            </div>

            {{-- Tombol Tambah Baris Alat --}}
            <button type="button" id="tambah-alat"
                style="background: #1cc88a; color: white; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; margin-bottom: 30px;">
                + Tambah Barang Lagi
            </button>

            <hr style="border-top: 1px dashed #d1d3e2; margin-bottom: 25px;">

            {{-- Tanggal Transaksi [cite: 35] --}}
            <div style="display: flex; gap: 20px; margin-bottom: 30px;">
                <div style="flex: 1;">
                    <label
                        style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: #4e73df; text-transform: uppercase;">Tanggal
                        Pinjam</label>
                    <input type="date" name="tgl_pinjam" value="{{ date('Y-m-d') }}"
                        style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px;" required>
                </div>
                <div style="flex: 1;">
                    <label
                        style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: #4e73df; text-transform: uppercase;">Batas
                        Kembali</label>
                    <input type="date" name="tgl_kembali_rencana"
                        style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px;"
                        min="{{ date('Y-m-d') }}" required>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div style="display: flex; gap: 12px;">
                <button type="submit"
                    style="flex: 2; background-color: #4e73df; color: white; border: none; padding: 14px; border-radius: 6px; cursor: pointer; font-weight: 700; font-size: 14px;">Simpan
                    Transaksi</button>
                <a href="{{ route('admin.peminjaman.index') }}"
                    style="flex: 1; text-align: center; background-color: #f8f9fc; color: #4e73df; border: 1px solid #d1d3e2; padding: 14px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 700;">Batal</a>
            </div>
        </form>
    </div>
</div>

{{-- JavaScript untuk Menambah Baris Secara Dinamis --}}
<script>
document.getElementById('tambah-alat').addEventListener('click', function() {
    const container = document.getElementById('container-alat');
    const originalRow = container.querySelector('.item-alat');
    const newRow = originalRow.cloneNode(true);

    // Reset input pada baris baru
    newRow.querySelector('select').value = "";
    newRow.querySelector('input').value = "1";

    // Tampilkan tombol hapus untuk baris tambahan
    const hapusBtn = newRow.querySelector('.btn-hapus');
    hapusBtn.style.visibility = 'visible';

    // Fungsi untuk menghapus baris tersebut
    hapusBtn.addEventListener('click', function() {
        newRow.remove();
    });

    container.appendChild(newRow);
});
</script>
@endsection