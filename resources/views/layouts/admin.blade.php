<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin - UKK Alat')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body style="background-color: white">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <div id="sidebar" class="w-64 flex flex-col shadow-lg border-r border-gray-200 transition-all duration-300"
            style="background-color: white;">

            <!-- LOGO -->
            <div class="p-4 text-xl font-bold border-b border-gray-200"
                style="background-color: #CDEDEA; color: #374151;">
                📚 SARPAS
            </div>

            <!-- USER -->
            <div class="p-4 text-sm border-b border-gray-200" style="background-color: #DCEBFA;">
                <span>Login sebagai:</span><br>
                <b>{{ auth()->user()->name }}</b><br>
                <span class="text-xs font-semibold">{{ auth()->user()->role }}</span>
            </div>

            <!-- MENU -->
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">

                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded font-semibold">
                    🏠 Dashboard
                </a>

                <div class="mt-4 pt-2">
                    <p class="text-xs font-bold uppercase" style="opacity: 0.6;">Master Data</p>
                </div>

                <a href="{{ route('admin.alat.index') }}" class="block px-4 py-2 rounded font-semibold">
                    📦 Data Alat
                </a>

                <a href="{{ route('admin.kategori.index') }}" class="block px-4 py-2 rounded font-semibold">
                    🏷️ Kategori
                </a>

                <div class="mt-4 pt-2">
                    <p class="text-xs font-bold uppercase" style="opacity: 0.6;">Transaksi</p>
                </div>

                <a href="{{ route('admin.peminjaman.index') }}" class="block px-4 py-2 rounded font-semibold">
                    🔄 Data Peminjaman
                </a>

                <a href="{{ route('admin.pengembalian.index') }}" class="block px-4 py-2 rounded font-semibold">
                    ↩️ Pengembalian
                </a>

                <div class="mt-4 pt-2">
                    <p class="text-xs font-bold uppercase" style="opacity: 0.6;">Administrator</p>
                </div>

                <a href="{{ route('admin.user.index') }}" class="block px-4 py-2 rounded font-semibold">
                    👥 Manajemen User
                </a>

                <a href="{{ route('admin.log.index') }}" class="block px-4 py-2 rounded font-semibold">
                    📊 Log Aktivitas
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

        <!-- CONTENT -->
        <div class="flex-1 p-8 overflow-x-auto">

            @yield('content')
        </div>

    </div>

    <!-- JS BUKA TUTUP NAVBAR (MINIMAL & AMAN) -->
    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('hidden');
    }
    </script>

</body>

</html>