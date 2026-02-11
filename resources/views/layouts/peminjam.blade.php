<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Siswa')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
    /* MENGUNCI SIDEBAR AGAR TIDAK BISA DI-SCROLL */
    #sidebar-siswa {
        position: fixed;
        /* Kunci posisi di layar */
        top: 0;
        left: 0;
        height: 100vh;
        /* Tinggi pas satu layar */
        width: 16rem;
        /* Lebar w-64 */
        z-index: 50;
        display: flex;
        flex-direction: column;
        background-color: white;
        border-right: 1px solid #e5e7eb;
        box-shadow: 4px 0 6px -1px rgba(0, 0, 0, 0.05);
    }

    /* MEMBERI RUANG UNTUK KONTEN DI KANAN AGAR TIDAK TERTUTUP */
    .main-content {
        margin-left: 16rem;
        /* Harus sama dengan lebar sidebar */
        width: calc(100% - 16rem);
        min-height: 100vh;
    }

    /* Navigasi di dalam sidebar jika suatu saat menu bertambah banyak */
    .nav-wrapper {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
    }

    /* Menghilangkan scrollbar utama browser jika diperlukan agar lebih bersih */
    body {
        overflow-x: hidden;
    }
    </style>
</head>

<body style="background-color: white;">

    <div class="flex">

        <aside id="sidebar-siswa">

            <div class="p-4 text-xl font-bold border-b flex-shrink-0"
                style="background-color: #CDEDEA; color: #374151;">
                <i class="fas fa-graduation-cap me-2"></i> Siswa
            </div>

            <nav class="nav-wrapper space-y-2">

                <a href="{{ route('peminjam.dashboard') }}"
                    class="block px-3 py-2 rounded transition font-semibold border-l-4 {{ request()->routeIs('peminjam.dashboard') ? '' : 'hover:bg-gray-50' }}"
                    style="{{ request()->routeIs('peminjam.dashboard') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    🏠 Dashboard
                </a>

                <div class="mt-4 pt-2">
                    <p class="text-xs font-bold uppercase" style="color: #374151; opacity: 0.6; letter-spacing: 1px;">
                        Menu Utama</p>
                </div>

                <a href="{{ route('peminjam.alat.index') }}"
                    class="block px-3 py-2 rounded transition font-semibold border-l-4 {{ request()->routeIs('peminjam.alat.index') ? '' : 'hover:bg-gray-50' }}"
                    style="{{ request()->routeIs('peminjam.alat.index') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    📦 Daftar Alat
                </a>

                <a href="{{ route('peminjam.checkout') }}"
                    class="block px-3 py-2 rounded transition font-semibold border-l-4 {{ request()->routeIs('peminjam.checkout') ? '' : 'hover:bg-gray-50' }}"
                    style="{{ request()->routeIs('peminjam.checkout') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    ➕ Daftar Pinjam
                </a>

                <a href="{{ route('peminjam.kembalikan') }}"
                    class="block px-3 py-2 rounded transition font-semibold border-l-4 {{ request()->routeIs('peminjam.kembalikan') ? '' : 'hover:bg-gray-50' }}"
                    style="{{ request()->routeIs('peminjam.kembalikan') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    ↩️ Kembalikan Alat
                </a>

                <a href="{{ route('peminjam.riwayat') }}"
                    class="block px-3 py-2 rounded transition font-semibold border-l-4 {{ request()->routeIs('peminjam.riwayat') ? '' : 'hover:bg-gray-50' }}"
                    style="{{ request()->routeIs('peminjam.riwayat') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                    📚 Riwayat Peminjaman
                </a>

            </nav>

            <div class="p-4 border-t border-gray-200 flex-shrink-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full py-2 rounded font-bold text-white shadow-sm hover:opacity-90 transition-all"
                        style="background-color: #5B9FFF;">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="main-content p-8">
            <div class="w-full">
                @yield('content')
            </div>
        </main>

    </div>

</body>

</html>