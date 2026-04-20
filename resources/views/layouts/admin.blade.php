<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin - UKK Alat')</title>
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
    #sidebar {
        position: fixed;
        top: 70px;
        left: 0;
        width: 16rem;
        height: calc(100vh - 70px);
        background: rgba(2, 6, 23, 0.8);
        backdrop-filter: blur(12px);
        padding: 15px;
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

    /* ✅ MAIN CONTENT FIX (FULL LAYAR) */
    .main-content {
        margin-top: 70px;
        margin-left: 16rem;
        width: calc(100% - 16rem);
        padding: 25px 30px;

        /* FIX AGAR TIDAK TERPOTONG */
        min-height: calc(100vh - 70px);
    }

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

        <div class="nav-left">
            <div class="logo">
                <i class="fas fa-book-open"></i> SARPAS
            </div>
        </div>

        <div class="nav-center">
            <form action="{{ route('admin.search') }}" method="GET">
                <input type="text" name="q" placeholder="Cari alat, kategori..." required>
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
    <div id="sidebar">

        <nav class="sidebar-nav">

            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-house"></i> Dashboard
            </a>

            <p class="section-title">Master Data</p>

            <a href="{{ route('admin.alat.index') }}" class="{{ request()->routeIs('admin.alat.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Data Alat
            </a>

            <a href="{{ route('admin.kategori.index') }}"
                class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                <i class="fas fa-tag"></i> Kategori
            </a>

            <a href="{{ route('admin.peminjaman.index') }}"
                class="{{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                <i class="fas fa-sync-alt"></i> Peminjaman
            </a>

            <p class="section-title">Administrator</p>

            <a href="{{ route('admin.user.index') }}" class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> User
            </a>

            <a href="{{ route('admin.log.index') }}" class="{{ request()->routeIs('admin.log.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Log
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