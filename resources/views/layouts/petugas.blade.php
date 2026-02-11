<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Petugas - UKK Alat')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
    /* CSS AMPUH UNTUK MENGUNCI SIDEBAR */
    #sidebar-petugas {
        position: fixed;
        /* Kunci di layar */
        top: 0;
        left: 0;
        height: 100vh;
        /* Tinggi pas layar */
        width: 16rem;
        /* Lebar w-64 */
        z-index: 50;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    /* MEMBERI RUANG AGAR KONTEN DI KANAN TIDAK TERTUTUP */
    .main-content {
        margin-left: 16rem;
        /* Harus sama dengan lebar sidebar */
        width: calc(100% - 16rem);
        min-height: 100vh;
    }

    /* Area menu yang bisa scroll jika menu terlalu banyak */
    .nav-scroll {
        flex: 1;
        overflow-y: auto;
    }

    /* Menghilangkan scrollbar browser agar rapi */
    body {
        overflow-x: hidden;
    }
    </style>
</head>

<body style="background-color: white;">

    <div class="flex">

        <div id="sidebar-petugas" class="shadow-lg border-r border-gray-200" style="background-color: white;">

            <div class="p-4 text-xl font-bold border-b border-gray-200 flex-shrink-0"
                style="background-color: #CDEDEA; color: #374151;">
                📚 SARPAS
            </div>

            <div class="p-4 text-sm border-b border-gray-200 flex-shrink-0" style="background-color: #DCEBFA;">
                <span style="color: #374151;">Login sebagai:</span><br>
                <b style="color: #374151;">{{ auth()->user()->name }}</b><br>
                <span class="text-xs font-semibold" style="color: #374151;">{{ auth()->user()->role }}</span>
            </div>

            <nav class="nav-scroll p-4 space-y-2">

                <a href="{{ route('petugas.dashboard') }}"
                    class="block px-4 py-2 rounded transition font-semibold border-l-4 {{ request()->routeIs('petugas.dashboard') ? '' : 'hover:bg-gray-50' }}"
                    style="{{ request()->routeIs('petugas.dashboard') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    🏠 Dashboard
                </a>

                <div class="mt-4 pt-2">
                    <p class="text-xs font-bold uppercase" style="color: #374151; opacity: 0.6;">Transaksi</p>
                </div>

                <a href="{{ route('petugas.alat.index') }}"
                    class="block px-4 py-2 rounded transition font-semibold border-l-4 {{ request()->routeIs('petugas.alat.*') ? '' : 'hover:bg-gray-50' }}"
                    style="{{ request()->routeIs('petugas.alat.*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    📦 Daftar Alat
                </a>

                <a href="{{ route('petugas.peminjaman.index') }}"
                    class="block px-4 py-2 rounded transition font-semibold border-l-4 {{ request()->routeIs('petugas.peminjaman.*') ? '' : 'hover:bg-gray-50' }}"
                    style="{{ request()->routeIs('petugas.peminjaman.*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    ✅ Setujui Peminjaman
                </a>

                <a href="{{ route('petugas.pengembalian.index') }}"
                    class="block px-4 py-2 rounded transition font-semibold border-l-4 {{ request()->routeIs('petugas.pengembalian.*') ? '' : 'hover:bg-gray-50' }}"
                    style="{{ request()->routeIs('petugas.pengembalian.*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    ✔️ Validasi Pengembalian
                </a>

                <div class="mt-4 pt-2">
                    <p class="text-xs font-bold uppercase" style="color: #374151; opacity: 0.6;">Laporan</p>
                </div>

                <a href="{{ route('petugas.laporan.index') }}"
                    class="block px-4 py-2 rounded transition font-semibold border-l-4 {{ request()->routeIs('petugas.laporan.*') ? '' : 'hover:bg-gray-50' }}"
                    style="{{ request()->routeIs('petugas.laporan.*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    📊 Laporan
                </a>
            </nav>

            <div class="p-4 border-t border-gray-200 flex-shrink-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full py-2 rounded font-semibold transition-opacity hover:opacity-90"
                        style="background-color: #5B9FFF; color: #FFFFFF;">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>

        <main class="main-content p-8">
            <div class="w-full">
                @yield('content')
            </div>
        </main>

    </div>

</body>

</html>