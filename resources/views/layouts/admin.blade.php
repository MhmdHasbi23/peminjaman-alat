<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin - UKK Alat')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
    /* MENGUNCI SIDEBAR SECARA ABSOLUT */
    #sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 16rem;
        z-index: 50;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .main-content {
        margin-left: 16rem;
        width: calc(100% - 16rem);
        min-height: 100vh;
    }

    .sidebar-nav {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
    }

    body {
        overflow-x: hidden;
    }

    /* Styling tambahan untuk merapikan ikon */
    .sidebar-nav a i {
        width: 20px;
        text-align: center;
        margin-right: 8px;
    }
    </style>
</head>

<body style="background-color: white">

    <div class="flex">

        <div id="sidebar" class="shadow-lg border-r border-gray-200" style="background-color: white;">

            <div class="p-4 text-xl font-bold border-b border-gray-200 flex-shrink-0"
                style="background-color: #CDEDEA; color: #374151;">
                <i class="fas fa-book-open"></i> SARPAS
            </div>

            <div class="p-4 text-sm border-b border-gray-200 flex-shrink-0" style="background-color: #DCEBFA;">
                <span><i class="fas fa-user-circle"></i> Login sebagai:</span><br>
                <b>{{ auth()->user()->name }}</b><br>
                <span class="text-xs font-semibold">{{ auth()->user()->role }}</span>
            </div>

            <nav class="sidebar-nav space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-2 rounded font-semibold hover:bg-gray-100 transition-colors">
                    <i class="fas fa-house"></i> Dashboard
                </a>

                <div class="mt-4 pt-2">
                    <p class="text-xs font-bold uppercase text-gray-400">Master Data</p>
                </div>
                <a href="{{ route('admin.alat.index') }}"
                    class="block px-4 py-2 rounded font-semibold hover:bg-gray-100 transition-colors">
                    <i class="fas fa-box"></i> Data Alat
                </a>
                <a href="{{ route('admin.kategori.index') }}"
                    class="block px-4 py-2 rounded font-semibold hover:bg-gray-100 transition-colors">
                    <i class="fas fa-tag"></i> Kategori
                </a>
                <a href="{{ route('admin.peminjaman.index') }}"
                    class="block px-4 py-2 rounded font-semibold hover:bg-gray-100 transition-colors">
                    <i class="fas fa-sync-alt"></i> Data Peminjaman
                </a>

                <div class="mt-4 pt-2">
                    <p class="text-xs font-bold uppercase text-gray-400">Administrator</p>
                </div>
                <a href="{{ route('admin.user.index') }}"
                    class="block px-4 py-2 rounded font-semibold hover:bg-gray-100 transition-colors">
                    <i class="fas fa-users"></i> Manajemen User
                </a>
                <a href="{{ route('admin.log.index') }}"
                    class="block px-4 py-2 rounded font-semibold hover:bg-gray-100 transition-colors">
                    <i class="fas fa-chart-line"></i> Log Aktivitas
                </a>
            </nav>

            <div class="p-4 border-t border-gray-200 flex-shrink-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full py-2 rounded font-semibold text-white transition-opacity hover:opacity-90"
                        style="background-color: #5B9FFF;">
                        <i class="fas fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="main-content p-8">
            <div class="w-full">
                @yield('content')
            </div>
        </div>

    </div>

</body>

</html>