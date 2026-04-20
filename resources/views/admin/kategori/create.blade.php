@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', sans-serif;">

    <!-- HEADER -->
    <div class="mb-4">
        <h4 style="font-weight: 800; color: #e2e8f0; margin-bottom: 5px;">
            ➕ Tambah Kategori
        </h4>
        <p style="color: #94a3b8; font-size: 14px;">
            Tambahkan kategori baru untuk alat
        </p>
    </div>

    <!-- CARD -->
    <div class="card-custom">

        <!-- FORM -->
        <form id="formTambahKategori" action="{{ route('admin.kategori.store') }}" method="POST">
            @csrf

            <!-- INPUT -->
            <div class="mb-4">
                <label class="label-custom">Nama Kategori</label>
                <input 
                    type="text" 
                    name="nama_kategori" 
                    id="nama_kategori"
                    value="{{ old('nama_kategori') }}"
                    class="input-custom"
                    placeholder="Contoh: Alat Jaringan"
                    required
                >

                @error('nama_kategori')
                    <small style="color: #f87171; display:block; margin-top:6px;">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <!-- BUTTON FULL LEFT RIGHT -->
            <div class="d-flex gap-3">
                <button type="submit" class="btn-save w-100">
                    💾 Simpan
                </button>

                <a href="{{ route('admin.kategori.index') }}" class="btn-cancel w-100 text-center">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>

<style>

/* CARD */
.card-custom {
    background: rgba(255,255,255,0.04);
    border-radius: 16px;
    padding: 30px;
    border: 1px solid rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    max-width: 600px;
}

/* LABEL */
.label-custom {
    color: #cbd5f5;
    font-weight: 600;
    font-size: 13px;
    margin-bottom: 6px;
    display: block;
}

/* INPUT */
.input-custom {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.05);
    color: #e2e8f0;
    transition: 0.3s;
}

.input-custom:focus {
    outline: none;
    border-color: #60a5fa;
    box-shadow: 0 0 0 2px rgba(96,165,250,0.3);
}

/* BUTTON SAVE */
.btn-save {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
    padding: 12px;
    border-radius: 10px;
    font-weight: 600;
    color: white;
    transition: 0.3s;
}

.btn-save:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(59,130,246,0.3);
}

/* BUTTON CANCEL */
.btn-cancel {
    background: rgba(255,255,255,0.08);
    padding: 12px;
    border-radius: 10px;
    color: #e2e8f0;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.btn-cancel:hover {
    background: rgba(255,255,255,0.15);
}

</style>

@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// SUCCESS
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    confirmButtonColor: '#3b82f6',
    background: '#0f172a',
    color: '#fff'
});
@endif

// ERROR
@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '{{ session('error') }}',
    confirmButtonColor: '#ef4444',
    background: '#0f172a',
    color: '#fff'
});
@endif

// VALIDASI LARAVEL
@if($errors->any())
Swal.fire({
    icon: 'warning',
    title: 'Validasi Gagal',
    html: `
        @foreach($errors->all() as $error)
            <div style="margin-bottom:5px;">• {{ $error }}</div>
        @endforeach
    `,
    confirmButtonColor: '#facc15',
    background: '#0f172a',
    color: '#fff'
});
@endif

// CONFIRM SUBMIT
document.getElementById('formTambahKategori').addEventListener('submit', function(e){
    e.preventDefault();

    let nama = document.getElementById('nama_kategori').value.trim();

    if(nama === ''){
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Nama kategori wajib diisi!',
            confirmButtonColor: '#facc15'
        });
        return;
    }

    Swal.fire({
        title: 'Simpan Kategori?',
        text: 'Pastikan data sudah benar',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, simpan',
        background: '#0f172a',
        color: '#fff'
    }).then((result)=>{
        if(result.isConfirmed){
            this.submit();
        }
    });
});

</script>
@endsection