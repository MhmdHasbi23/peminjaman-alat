@extends('layouts.petugas') {{-- Pastikan mengarah ke file layout utama Anda --}}

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: 'Segoe UI', sans-serif;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 style="font-weight: 700; color: #333; margin: 0;">📦 Inventaris Alat (Petugas)</h4>
            <p style="color: #718096; font-size: 0.9rem; margin: 0;">Pantau ketersediaan stok barang secara real-time.
            </p>
        </div>
        <div class="text-end">
            <span class="badge bg-primary">Role: Petugas</span>
        </div>
    </div>

    <div
        style="background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e3e6f0;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #f8f9fc; border-bottom: 2px solid #e3e6f0;">
                <tr>
                    <th
                        style="padding: 18px 15px; text-align: left; color: #4e73df; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">
                        Informasi Alat</th>
                    <th
                        style="padding: 18px 15px; text-align: left; color: #4e73df; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">
                        Kategori</th>
                    <th
                        style="padding: 18px 15px; text-align: center; color: #4e73df; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">
                        Jumlah Stok</th>
                    <th
                        style="padding: 18px 15px; text-align: center; color: #4e73df; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">
                        Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alats as $a)
                <tr style="border-bottom: 1px solid #f1f3f9; transition: 0.3s;"
                    onmouseover="this.style.backgroundColor='#fcfdfe'"
                    onmouseout="this.style.backgroundColor='transparent'">
                    <td style="padding: 15px;">
                        <div style="font-weight: 600; color: #3a3b45; font-size: 15px;">{{ $a->nama_alat }}</div>
                        <div style="color: #a0aec0; font-size: 12px; margin-top: 2px;">Spesifikasi:
                            {{ $a->spesifikasi }}</div>
                    </td>
                    <td style="padding: 15px;">
                        <span
                            style="color: #6e707e; font-size: 14px;">{{ $a->kategori->nama_kategori ?? 'Umum' }}</span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <span style="font-size: 18px; font-weight: 700; color: #3a3b45;">{{ $a->stok }}</span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        @if($a->stok > 10)
                        <div
                            style="background: #e1f7ef; color: #1cc88a; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; display: inline-block;">
                            <i class="fas fa-check-circle me-1"></i> AMAN
                        </div>
                        @elseif($a->stok > 0)
                        <div
                            style="background: #fff9e6; color: #f6e05e; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; display: inline-block;">
                            <i class="fas fa-exclamation-triangle me-1"></i> TERBATAS
                        </div>
                        @else
                        <div
                            style="background: #ffebe9; color: #e74a3b; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; display: inline-block;">
                            <i class="fas fa-times-circle me-1"></i> KOSONG
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 50px; text-align: center;">
                        <img src="https://illustrations.popsy.co/amber/box-opening.svg" alt="Empty"
                            style="width: 150px; opacity: 0.5;">
                        <p style="margin-top: 15px; color: #a0aec0; font-weight: 500;">Belum ada data inventaris alat.
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{-- {{ $alats->links() }} --}}
    </div>
</div>
@endsection