<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventaris Lab') — Lab Informatika</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-accent: #3b82f6;
            --sidebar-text: #cbd5e1;
            --sidebar-hover: #1e293b;
            --header-height: 60px;
        }
        body { background: #f1f5f9; font-family: 'Segoe UI', system-ui, sans-serif; }

        /* ── Sidebar ── */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 1040;
            transition: transform .25s ease;
        }
        #sidebar .sidebar-brand {
            height: var(--header-height);
            display: flex; align-items: center;
            padding: 0 1.25rem;
            border-bottom: 1px solid #1e293b;
        }
        #sidebar .sidebar-brand span { color: #fff; font-weight: 700; font-size: 1rem; }
        #sidebar .sidebar-brand small { color: var(--sidebar-accent); font-size: .7rem; display: block; }
        #sidebar .nav-link {
            color: var(--sidebar-text);
            padding: .55rem 1.25rem;
            border-radius: 8px;
            margin: 2px 8px;
            font-size: .875rem;
            transition: background .15s, color .15s;
        }
        #sidebar .nav-link:hover, #sidebar .nav-link.active {
            background: var(--sidebar-hover);
            color: #fff;
        }
        #sidebar .nav-link.active { border-left: 3px solid var(--sidebar-accent); }
        #sidebar .nav-link i { width: 1.4rem; }
        .sidebar-section {
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #475569;
            padding: .75rem 1.5rem .25rem;
            font-weight: 600;
        }

        /* ── Main content ── */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        #topbar {
            height: var(--header-height);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            position: sticky; top: 0; z-index: 1030;
            display: flex; align-items: center; padding: 0 1.5rem;
        }
        .page-content { padding: 1.5rem; }

        /* ── Cards ── */
        .stat-card {
            border: none; border-radius: 12px;
            transition: transform .15s, box-shadow .15s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 20px rgba(0,0,0,.08); }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

        /* ── Table ── */
        .table-hover tbody tr:hover { background: #f8fafc; }
        .table th { font-size: .78rem; text-transform: uppercase; letter-spacing: .05em; color: #64748b; font-weight: 600; }

        /* ── Sidebar collapsed on mobile ── */
        @media (max-width: 991.98px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; }
        }

        .badge-condition-baik           { background: #dcfce7; color: #166534; }
        .badge-condition-rusak_ringan   { background: #fef9c3; color: #854d0e; }
        .badge-condition-rusak_berat    { background: #fee2e2; color: #991b1b; }
        .badge-condition-tidak_berfungsi { background: #1e293b; color: #cbd5e1; }
    </style>
    @stack('styles')
</head>
<body>

<!-- ════ SIDEBAR ════ -->
<nav id="sidebar">
    <div class="sidebar-brand">
        <div>
            <span><i class="bi bi-pc-display me-2 text-primary"></i>LabInvent</span>
            <small>Sistem Inventaris Laboratorium</small>
        </div>
    </div>
    <ul class="nav flex-column pt-2">
        <li class="sidebar-section">Utama</li>
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <li class="sidebar-section">Inventaris</li>
        <li class="nav-item">
            <a href="{{ route('rooms.index') }}" class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                <i class="bi bi-door-open"></i> Ruangan & Lab
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('items.index') }}" class="nav-link {{ request()->routeIs('items.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Semua Barang
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('items.index', ['condition' => 'rusak_berat']) }}" class="nav-link">
                <i class="bi bi-exclamation-triangle text-danger"></i> Barang Rusak
            </a>
        </li>

        <li class="sidebar-section">Pemeliharaan</li>
        <li class="nav-item">
            <a href="{{ route('maintenance.index') }}" class="nav-link {{ request()->routeIs('maintenance.*') ? 'active' : '' }}">
                <i class="bi bi-tools"></i> Log Pemeliharaan
            </a>
        </li>

        <li class="sidebar-section">Master Data</li>
        <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Kategori
            </a>
        </li>
    </ul>
</nav>

<!-- ════ MAIN ════ -->
<div id="main-content">
    <!-- Topbar -->
    <div id="topbar">
        <button class="btn btn-sm btn-light d-lg-none me-3" onclick="document.getElementById('sidebar').classList.toggle('show')">
            <i class="bi bi-list fs-5"></i>
        </button>
        <div class="fw-semibold text-secondary small">@yield('page-title', 'Dashboard')</div>
        <div class="ms-auto d-flex gap-2 align-items-center">
            <span class="badge bg-primary-subtle text-primary">
                <i class="bi bi-calendar3 me-1"></i>{{ date('d M Y') }}
            </span>
        </div>
    </div>

    <!-- Flash messages -->
    <div class="px-4 pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <div class="page-content">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
