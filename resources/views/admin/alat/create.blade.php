@extends('layouts.admin')

@section('title', 'Tambah Alat')

@section('content')
<div style="padding: 30px; font-family: 'Inter', sans-serif; max-width: 700px; margin:auto;">

    {{-- HEADER --}}
    <div style="margin-bottom: 25px;">
        <h4 style="font-weight: 800; color: #e5e7eb;">
            <i class="fas fa-plus-circle me-2" style="color:#60a5fa;"></i>
            Tambah Alat Baru
        </h4>
        <p style="color:#94a3b8; font-size:14px;">
            Masukkan data alat dengan lengkap dan benar.
        </p>
    </div>

    {{-- CARD FORM --}}
    <div style="
        background: rgba(255,255,255,0.03);
        backdrop-filter: blur(14px);
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.08);
        padding: 30px;
    ">

        <form id="formTambahAlat" action="{{ route('admin.alat.store') }}" method="POST">
            @csrf

            {{-- INPUT --}}
            <div class="form-group">
                <label>Nama Alat</label>
                <input type="text" name="nama_alat" value="{{ old('nama_alat') }}" placeholder="Contoh: Laptop"
                    required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Spesifikasi</label>
                <textarea name="spesifikasi" rows="3"
                    placeholder="RAM 8GB, SSD 256GB" required>{{ old('spesifikasi') }}</textarea>
            </div>

            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" min="0" value="{{ old('stok') }}" required>
            </div>

            {{-- BUTTON --}}
            <div style="display:flex; gap:10px; margin-top:20px;">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>

                <a href="{{ route('admin.alat.index') }}" class="btn-secondary">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>

{{-- STYLE --}}
<style>

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display:block;
    margin-bottom:6px;
    font-size:12px;
    color:#60a5fa;
    font-weight:700;
    text-transform:uppercase;
}

.form-group input,
.form-group select,
.form-group textarea {
    width:100%;
    padding:12px;
    border-radius:10px;
    border:1px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.04);
    color:#e5e7eb;
    outline:none;
    transition:0.3s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color:#3b82f6;
    box-shadow:0 0 0 2px rgba(59,130,246,0.2);
}

/* BUTTON */
.btn-primary {
    flex:2;
    background: linear-gradient(135deg,#3b82f6,#2563eb);
    border:none;
    padding:12px;
    border-radius:10px;
    color:white;
    font-weight:700;
    cursor:pointer;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow:0 6px 15px rgba(59,130,246,0.3);
}

.btn-secondary {
    flex:1;
    text-align:center;
    background: rgba(255,255,255,0.05);
    color:#cbd5f5;
    padding:12px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
}

.btn-secondary:hover {
    background: rgba(255,255,255,0.1);
}

</style>
@endsection

@section('scripts')
<script>
document.getElementById('formTambahAlat').addEventListener('submit', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Simpan Data?',
        text: 'Pastikan data sudah benar',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});

@if ($errors->any())
Swal.fire({
    title: 'Validasi Gagal',
    html: `
        <div style="text-align:left;">
        @foreach ($errors->all() as $error)
            <div>• {{ $error }}</div>
        @endforeach
        </div>
    `,
    icon: 'warning'
});
@endif
</script>
@endsection