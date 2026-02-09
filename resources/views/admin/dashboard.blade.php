@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: 'Segoe UI', sans-serif;">
    <div class="mb-4">
        <h4 style="font-weight: 700; color: #333; margin: 0;">🏠 Dashboard Admin</h4>
        <p style="color: #718096; font-size: 0.9rem;">Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        
        <div style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #4e73df; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="font-size: 11px; font-weight: 800; color: #4e73df; text-transform: uppercase;">Total Inventaris</div>
            <div style="font-size: 24px; font-weight: 700; color: #5a5c69;">{{ $total_alat }} Alat</div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #f6e05e; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="font-size: 11px; font-weight: 800; color: #f6e05e; text-transform: uppercase;">Perlu Persetujuan</div>
            <div style="font-size: 24px; font-weight: 700; color: #5a5c69;">{{ $pinjam_menunggu }} Data</div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #1cc88a; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="font-size: 11px; font-weight: 800; color: #1cc88a; text-transform: uppercase;">Sedang Dipinjam</div>
            <div style="font-size: 24px; font-weight: 700; color: #5a5c69;">{{ $pinjam_aktif }} Transaksi</div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #e74a3b; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="font-size: 11px; font-weight: 800; color: #e74a3b; text-transform: uppercase;">Kas Denda</div>
            <div style="font-size: 24px; font-weight: 700; color: #5a5c69;">Rp {{ number_format($total_denda, 0, ',', '.') }}</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e3e6f0;">
            <h5 style="font-weight: 700; margin-bottom: 15px; font-size: 14px;">📜 Log Aktivitas Terbaru</h5>
            <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                @foreach($recent_logs as $log)
                <tr style="border-bottom: 1px solid #f8f9fc;">
                    <td style="padding: 10px 0; color: #4e73df; font-weight: 600;">{{ $log->user->name }}</td>
                    <td style="padding: 10px 0;">{{ $log->deskripsi }}</td>
                    <td style="padding: 10px 0; color: #a0aec0; text-align: right;">{{ $log->created_at->diffForHumans() }}</td>
                </tr>
                @endforeach
            </table>
            <div style="margin-top: 15px; text-align: center;">
                <a href="{{ route('admin.log.index') }}" style="font-size: 12px; color: #4e73df; text-decoration: none; font-weight: 700;">Lihat Semua Log →</a>
            </div>
        </div>

        <div style="background: #fff5f5; border-radius: 12px; padding: 20px; border: 1px solid #feb2b2;">
            <h5 style="font-weight: 700; color: #c53030; margin-bottom: 15px; font-size: 14px;">⚠️ Stok Menipis (< 5)</h5>
            <ul style="padding-left: 20px; font-size: 13px; color: #742a2a;">
                @php $alats = \App\Models\Alat::where('stok', '<', 5)->get(); @endphp
                @forelse($alats as $a)
                    <li style="margin-bottom: 8px;">{{ $a->nama_alat }} (Sisa: <strong>{{ $a->stok }}</strong>)</li>
                @empty
                    <li>Semua stok aman.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection