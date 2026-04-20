@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Inter', sans-serif;">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 style="font-weight:800; color:#e2e8f0; margin-bottom:5px;">
            ✏️ Edit Pengguna
        </h4>
        <p style="color:#94a3b8; font-size:14px;">
            Perbarui informasi akun pengguna
        </p>
    </div>

    {{-- CARD --}}
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

        {{-- FORM --}}
        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                {{-- NAMA --}}
                <div class="col-md-6 mb-3">
                    <label class="label-custom">Nama Lengkap</label>
                    <input type="text" name="name"
                        value="{{ old('name', $user->name) }}"
                        class="input-custom" required>
                </div>

                {{-- EMAIL --}}
                <div class="col-md-6 mb-3">
                    <label class="label-custom">Email</label>
                    <input type="email" name="email"
                        value="{{ old('email', $user->email) }}"
                        class="input-custom" required>
                </div>

                {{-- PASSWORD --}}
                <div class="col-md-6 mb-3">
                    <label class="label-custom">
                        Password Baru
                        <small style="color:#64748b; font-weight:400;">(opsional)</small>
                    </label>
                    <input type="password" name="password"
                        placeholder="Kosongkan jika tidak diubah"
                        class="input-custom">
                </div>

                {{-- ROLE --}}
                <div class="col-md-6 mb-4">
                    <label class="label-custom">Level Akses</label>
                    <select name="role" class="input-custom" required>
                        <option value="peminjam" {{ $user->role == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                        <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

            </div>

            {{-- BUTTON FULL WIDTH --}}
            <div class="d-flex gap-3 w-100">
                <a href="{{ route('admin.user.index') }}" class="btn-cancel w-50 text-center">
                    ← Kembali
                </a>

                <button type="submit" class="btn-save w-50">
                    💾 Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

{{-- STYLE --}}
<style>

/* CARD */
.card-custom {
    background: rgba(255,255,255,0.04);
    border-radius: 16px;
    padding: 30px;
    border: 1px solid rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
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
    padding: 11px 13px;
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
    font-weight: 700;
    transition: 0.2s;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(59,130,246,0.4);
}

.btn-cancel {
    background: rgba(255,255,255,0.08);
    padding: 12px;
    border-radius: 10px;
    color: #e2e8f0;
    text-decoration: none;
    font-weight: 600;
    transition: 0.2s;
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