<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Petugas - UKK Alat</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body style="background-color: white;">

    <div class="flex min-h-screen">

        <!-- SIDEBAR PETUGAS -->
        <div class="w-64 text-gray-800 flex flex-col shadow-lg border-r border-gray-200 sidebar-petugas"
            style="background-color: white;">

            <!-- LOGO -->
            <div class="p-4 text-xl font-bold border-b border-gray-200 rounded-b-lg"
                style="background-color: #CDEDEA; color: #374151;">
                📚 UKK Alat
            </div>

            <!-- USER -->
            <div class="p-4 text-sm border-b border-gray-200" style="background-color: #DCEBFA;">
                <span style="color: #374151;">Login sebagai:</span><br>
                <b style="color: #374151;">{{ auth()->user()->name }}</b><br>
                <span class="text-xs font-semibold" style="color: #374151;">{{ auth()->user()->role }}</span>
            </div>

            <!-- MENU -->
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">

                <!-- DASHBOARD -->
                <a href="{{ route('petugas.dashboard') }}"
                    class="block px-4 py-2 rounded transition font-semibold border-l-4"
                    style="'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    🏠 Dashboard
                </a>

                <!-- TRANSAKSI -->
                <div class="mt-4 pt-2">
                    <p class="text-xs font-bold uppercase" style="color: #374151; opacity: 0.6;">Transaksi</p>
                </div>

                <a href="{{ route('petugas.alat.index') }}"
                    class="block px-4 py-2 rounded transition font-semibold border-l-4"
                    style="'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    📦 Daftar Alat
                </a>

                <a href="{{ route('petugas.peminjaman.index') }}"
                    class="block px-4 py-2 rounded transition font-semibold border-l-4"
                    style="'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    ✅ Setujui Peminjaman
                </a>

                <a href="{{ route('petugas.pengembalian.index') }}"
                    class="block px-4 py-2 rounded transition font-semibold border-l-4"
                    style="'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    ✔️ Validasi Pengembalian
                </a>

                <!-- LAPORAN -->
                <div class="mt-4 pt-2">
                    <p class="text-xs font-bold uppercase" style="color: #374151; opacity: 0.6;">Laporan</p>
                </div>

                <a href="{{ route('petugas.laporan.index') }}"
                    class="block px-4 py-2 rounded transition font-semibold border-l-4"
                    style="'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    📊 Laporan
                </a>

                <a href=""
                    class="block px-4 py-2 rounded transition font-semibold border-l-4"
                    style="'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    📚 Laporan Peminjaman
                </a>

                <a href=""
                    class="block px-4 py-2 rounded transition font-semibold border-l-4"
                    style="'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    💰 Verifikasi Denda
                </a>
            </nav>

            <!-- LOGOUT -->
            <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-gray-200">
                @csrf
                <button class="w-full py-2 rounded font-semibold" style="background-color: #5B9FFF; color: #FFFFFF;">
                    🚪 Logout
                </button>
            </form>
        </div>

        <!-- KONTEN -->
        <div class="flex-1 p-8 text-gray-900 overflow-x-auto" style="background-color: white;">
            @yield('content')
        </div>

    </div>

</body>

</html>