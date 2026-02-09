<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body style="background-color: white;">

    <div class="flex min-h-screen">

        <!-- SIDEBAR SISWA -->
        <div class="w-64 text-gray-800" style="background-color: white;">
            <div class="p-4 text-xl font-bold border-b" style="background-color: #CDEDEA; color: #374151;">
                Siswa
            </div>

            <nav class="p-4 space-y-2">
                <a href="" class="block px-3 py-2 rounded transition font-semibold border-l-4"
                    style="'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    🏠 Dashboard
                </a>

                <div class="mt-4 pt-2">
                    <p class="text-xs font-bold uppercase" style="color: #374151; opacity: 0.6;">Menu</p>
                </div>

                <a href="{{ route('peminjam.alat.index') }}"
                    class="block px-3 py-2 rounded transition font-semibold border-l-4"
                    style="'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    📦 Daftar Alat
                </a>

                <a href="{{ route('peminjam.checkout') }}"
                    class="block px-3 py-2 rounded transition font-semibold border-l-4"
                    style="'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    ➕ Daftar Pinjam
                </a>

                <a href="{{ route('peminjam.kembalikan') }}"
                    class="block px-3 py-2 rounded transition font-semibold border-l-4"
                    style="{{ request()->routeIs('peminjam.kembalikan') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    ↩️ Kembalikan Alat
                </a>

                <a href="{{ route('peminjam.riwayat') }}"
                    class="block px-3 py-2 rounded transition font-semibold border-l-4"
                    style="'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    📚 Riwayat Peminjaman
                </a>

                <a href="" class="block px-3 py-2 rounded transition font-semibold border-l-4"
                    style="'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    💰 Pembayaran Denda
                </a>
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-gray-200">
                @csrf
                <button class="w-full py-2 rounded font-semibold" style="background-color: #5B9FFF; color: #FFFFFF;">
                    🚪 Logout
                </button>
            </form>
        </div>

        <!-- CONTENT -->
        <div class="flex-1 p-6" style="background-color: white;">
            @yield('content')
        </div>

    </div>

</body>

</html>