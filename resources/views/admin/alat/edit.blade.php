@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', sans-serif;">

    <!-- HEADER -->
    <div class="mb-4">
        <h4 style="font-weight: 800; color: #e2e8f0; margin-bottom: 5px;">
            ✏️ Edit Data Alat
        </h4>
        <p style="color: #94a3b8; font-size: 14px;">
            Perbarui data alat dengan benar
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
        <form action="{{ route('admin.alat.update', $alat->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="label-custom">Nama Alat</label>
                    <input type="text" name="nama_alat"
                        value="{{ old('nama_alat', $alat->nama_alat) }}"
                        class="input-custom" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="label-custom">Kategori</label>
                    <select name="kategori_id" class="input-custom" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ old('kategori_id', $alat->kategori_id) == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="label-custom">Spesifikasi</label>
                    <textarea name="spesifikasi" rows="3"
                        class="input-custom"
                        required>{{ old('spesifikasi', $alat->spesifikasi) }}</textarea>
                </div>

                <div class="col-md-4 mb-4">
                    <label class="label-custom">Stok</label>
                    <input type="number" name="stok"
                        value="{{ old('stok', $alat->stok) }}"
                        min="0"
                        class="input-custom" required>
                </div>

            </div>

            <!-- BUTTON (KIRI & KANAN) -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                
                <button type="submit" class="btn-save">
                    💾 Update Data
                </button>

                <a href="{{ route('admin.alat.index') }}" class="btn-cancel">
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
    padding: 11px 12px;
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

/* BUTTON UPDATE */
.btn-save {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 10px 22px;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    transition: 0.3s;
}

.btn-save:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(59,130,246,0.3);
}

/* BUTTON KEMBALI */
.btn-cancel {
    background: rgba(255,255,255,0.08);
    padding: 10px 22px;
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
<script>
function confirmDelete(id, nama) {
    Swal.fire({
        title: 'Hapus Data?',
        text: `Data "${nama}" akan dihapus!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, hapus!',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection