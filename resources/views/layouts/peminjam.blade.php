<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Siswa')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
    body {
        margin: 0;
        min-height: 100vh;
        background: radial-gradient(circle at top left, #0f172a, #020617 70%);
        color: #e5e7eb;
        font-family: 'Inter', sans-serif;
    }

    /* NAVBAR (SAMA PERSIS ADMIN) */
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

    .logo {
        font-weight: bold;
        color: #60a5fa;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
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
    }

    .user-menu {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.05);
        padding: 6px 12px;
        border-radius: 12px;
    }

    /* SIDEBAR (SAMA PERSIS ADMIN) */
    #sidebar-siswa {
        position: fixed;
        top: 70px;
        left: 0;
        width: 16rem;
        height: calc(100vh - 70px);
        background: rgba(2, 6, 23, 0.8);
        backdrop-filter: blur(12px);
        padding: 15px;
    }

    .user-info {
        margin-bottom: 10px;
    }

    .user-info small {
        color: #64748b;
        font-size: 12px;
    }

    .user-info strong {
        display: block;
        margin-top: 2px;
    }

    .nav-wrapper {
        overflow-y: auto;
    }

    .section-title {
        font-size: 11px;
        color: #475569;
        margin: 15px 10px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 6px;
        color: #94a3b8;
        text-decoration: none;
        transition: 0.3s;
    }

    .nav-item i {
        width: 22px;
        margin-right: 10px;
    }

    .nav-item:hover {
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
        transform: translateX(5px);
    }

    .nav-active {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white !important;
        box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
    }

    /* MAIN CONTENT (SAMA ADMIN) */
    .main-content {
        margin-top: 70px;
        margin-left: 16rem;
        width: calc(100% - 16rem);
        padding: 25px 30px;
        min-height: calc(100vh - 70px);
    }

    /* LOGOUT (SAMA ADMIN STYLE) */
    .logout-btn {
        margin-top: 10px;
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

        <div class="logo">
            <i class="fas fa-graduation-cap"></i>
            SARPAS
        </div>

        <div class="nav-center">
            <form action="#" method="GET">
                <input type="text" placeholder="Cari alat...">
                <i class="fas fa-search"></i>
            </form>
        </div>

        <div class="nav-right">
            <div class="icon-btn">
                <i class="fas fa-bell"></i>
            </div>

            <div class="user-menu">
                <i class="fas fa-user-circle"></i>
                {{ auth()->user()->name ?? 'User' }}
            </div>
        </div>

    </div>

    <!-- SIDEBAR -->
    <div id="sidebar-siswa">

        <div class="user-info">
            <small>Login sebagai</small>
            <strong>{{ auth()->user()->name ?? 'User' }}</strong>
        </div>

        <nav class="nav-wrapper">

            <a href="{{ route('peminjam.dashboard') }}"
                class="nav-item {{ request()->routeIs('peminjam.dashboard') ? 'nav-active' : '' }}">
                <i class="fas fa-house"></i> Dashboard
            </a>

            <p class="section-title">Menu Utama</p>

            <a href="{{ route('peminjam.alat.index') }}"
                class="nav-item {{ request()->routeIs('peminjam.alat.index') ? 'nav-active' : '' }}">
                <i class="fas fa-box"></i> Daftar Alat
            </a>

            <a href="{{ route('peminjam.checkout') }}"
                class="nav-item {{ request()->routeIs('peminjam.checkout') ? 'nav-active' : '' }}">
                <i class="fas fa-plus-circle"></i> Daftar Pinjam
            </a>

            <a href="{{ route('peminjam.kembalikan') }}"
                class="nav-item {{ request()->routeIs('peminjam.kembalikan') ? 'nav-active' : '' }}">
                <i class="fas fa-rotate-left"></i> Kembalikan Alat
            </a>

            <a href="{{ route('peminjam.riwayat') }}"
                class="nav-item {{ request()->routeIs('peminjam.riwayat') ? 'nav-active' : '' }}">
                <i class="fas fa-clock-rotate-left"></i> Riwayat Peminjaman
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

</body>

</html>