@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', sans-serif;">

    <!-- HEADER -->
    <div class="mb-4">
        <h4 style="font-weight: 800; color: #e2e8f0; margin-bottom: 5px;">
            🏷️ Edit Kategori
        </h4>
        <p style="color: #94a3b8; font-size: 14px;">
            Perbarui nama kategori dengan benar
        </p>
    </div>

    <!-- CARD -->
    <div class="card-custom">

        {{-- ERROR --}}
        @if ($errors->any())
        <div class="alert-error">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- FORM -->
        <form id="formEditKategori" action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="label-custom">Nama Kategori</label>
                <input 
                    type="text" 
                    name="nama_kategori" 
                    id="nama_kategori"
                    value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                    class="input-custom"
                    required
                >
            </div>

            <!-- BUTTON FULL -->
            <div class="d-flex gap-3 mt-3">

                <button type="submit" class="btn-save w-100">
                    💾 Update Kategori
                </button>

                <a href="{{ route('admin.kategori.index') }}" class="btn-cancel w-100 text-center">
                    ⬅️ Kembali
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
    backdrop-filter: blur(8px);
    max-width: 600px;
    margin: auto;
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
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.05);
    color: #e2e8f0;
    transition: 0.2s;
}

.input-custom:focus {
    outline: none;
    border-color: #60a5fa;
    box-shadow: 0 0 0 2px rgba(96,165,250,0.3);
}

/* BUTTON */
.btn-save {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 12px;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    transition: 0.3s;
}

.btn-save:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(59,130,246,0.3);
}

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

/* ERROR */
.alert-error {
    background: rgba(239,68,68,0.15);
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    color: #f87171;
}

</style>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// ERROR ALERT
@if($errors->any())
Swal.fire({
    icon: 'warning',
    title: 'Validasi Gagal',
    html: `
        @foreach($errors->all() as $error)
            <div style="margin-bottom:5px;">• {{ $error }}</div>
        @endforeach
    `,
    background: '#0f172a',
    color: '#fff',
    confirmButtonColor: '#f59e0b'
});
@endif

// SUBMIT CONFIRM
document.getElementById('formEditKategori').addEventListener('submit', function(e) {
    e.preventDefault();

    let nama = document.getElementById('nama_kategori').value.trim();

    if(nama === ''){
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Nama kategori wajib diisi!',
            background: '#0f172a',
            color: '#fff',
            confirmButtonColor: '#f59e0b'
        });
        return;
    }

    Swal.fire({
        title: 'Update Kategori?',
        text: 'Pastikan data sudah benar',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, update',
        background: '#0f172a',
        color: '#fff'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});

</script>
@endsection