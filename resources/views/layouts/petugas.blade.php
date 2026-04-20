<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Petugas - UKK Alat')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css','resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
    body {
        margin: 0;
        background: radial-gradient(circle at top left, #0f172a, #020617 70%);
        color: #e5e7eb;
        font-family: 'Inter', sans-serif;
    }

    /* NAVBAR */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 25px;
        background: rgba(2, 6, 23, 0.8);
        backdrop-filter: blur(12px);
        z-index: 100;
    }

    .nav-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .logo {
        font-weight: bold;
        color: #60a5fa;
        font-size: 18px;
    }

    .nav-center {
        width: 30%;
        position: relative;
    }

    .nav-center input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border-radius: 12px;
        border: none;
        background: rgba(255, 255, 255, 0.05);
        color: white;
        outline: none;
    }

    .nav-center i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
    }

    .nav-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .icon-btn {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .icon-btn:hover {
        background: rgba(59, 130, 246, 0.2);
        box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
    }

    .user-menu {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.05);
        padding: 6px 12px;
        border-radius: 12px;
    }

    /* SIDEBAR */
    #sidebar-petugas {
        position: fixed;
        top: 70px;
        left: 0;
        width: 16rem;
        height: calc(100vh - 70px);
        background: rgba(2, 6, 23, 0.8);
        backdrop-filter: blur(12px);
        padding: 15px;
        display: flex;
        flex-direction: column;
    }

    .nav-scroll {
        flex: 1;
        overflow-y: auto;
    }

    .sidebar-nav a {
        display: flex;
        align-items: center;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 6px;
        color: #94a3b8;
        transition: 0.3s;
    }

    .sidebar-nav a:hover {
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
        transform: translateX(5px);
    }

    /* ACTIVE */
    .sidebar-nav a.active {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
    }

    .sidebar-nav a.active i {
        color: white;
    }

    .sidebar-nav i {
        width: 22px;
        margin-right: 10px;
    }

    .section-title {
        font-size: 11px;
        color: #475569;
        margin: 15px 10px;
    }

    /* MAIN */
    .main-content {
        margin-top: 70px;
        margin-left: 16rem;
        padding: 25px;
    }

    .logout-btn {
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        border: none;
        cursor: pointer;
    }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">

        <div class="nav-left">
            <div class="logo">
                <i class="fas fa-book-open"></i> SARPAS
            </div>
        </div>

        <div class="nav-center">
            <form action="{{ route('petugas.alat.index') }}" method="GET">
                <input type="text" name="q" placeholder="Cari alat..." required>
                <i class="fas fa-search"></i>
            </form>
        </div>

        <div class="nav-right">
            <div class="icon-btn">
                <i class="fas fa-bell"></i>
            </div>

            <div class="user-menu">
                <i class="fas fa-user-circle"></i>
                {{ auth()->user()->name }}
            </div>
        </div>

    </div>

    <!-- SIDEBAR -->
    <div id="sidebar-petugas">

        <!-- IDENTITAS (TETAP ADA, TAPI DISESUAIKAN STYLE) -->
        <div style="margin-bottom: 10px;">
            <div style="font-size: 12px; color: #64748b;">Login sebagai</div>
            <div style="font-weight: bold;">{{ auth()->user()->name }}</div>
            <div style="font-size: 12px; color: #94a3b8;">{{ auth()->user()->role }}</div>
        </div>

        <nav class="sidebar-nav nav-scroll">

            <a href="{{ route('petugas.dashboard') }}"
                class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                <i class="fas fa-house"></i> Dashboard
            </a>

            <p class="section-title">Transaksi</p>

            <a href="{{ route('petugas.alat.index') }}"
                class="{{ request()->routeIs('petugas.alat.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Daftar Alat
            </a>

            <a href="{{ route('petugas.peminjaman.index') }}"
                class="{{ request()->routeIs('petugas.peminjaman.*') ? 'active' : '' }}">
                <i class="fas fa-check-circle"></i> Setujui Peminjaman
            </a>

            <a href="{{ route('petugas.pengembalian.index') }}"
                class="{{ request()->routeIs('petugas.pengembalian.*') ? 'active' : '' }}">
                <i class="fas fa-rotate-left"></i> Validasi Pengembalian
            </a>

            <p class="section-title">Laporan</p>

            <a href="{{ route('petugas.laporan.index') }}"
                class="{{ request()->routeIs('petugas.laporan.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Laporan
            </a>

        </nav>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn">
                Logout
            </button>
        </form>

    </div>

    <!-- CONTENT -->
    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')

</body>

</html>