<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DriveNow – Location de Voitures')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --grad-1: #FF6B35;
            --grad-2: #F7C59F;
            --accent: #FF6B35;
            --accent-2: #6C63FF;
            --accent-3: #00D9B5;
            --dark: #0D0D1A;
            --dark-2: #16162A;
            --card: #1E1E35;
            --card-border: rgba(255,255,255,0.08);
            --text: #F0F0FF;
            --muted: #8888AA;
            --success: #00D9B5;
            --warning: #FFB800;
            --danger: #FF4757;
            --info: #6C63FF;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--dark);
            color: var(--text);
            min-height: 100vh;
        }

        h1,h2,h3,h4,h5,h6 { font-family: 'Syne', sans-serif; }

        /* ── Sidebar ─────────────────────────────── */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: 260px; height: 100vh;
            background: var(--dark-2);
            border-right: 1px solid var(--card-border);
            display: flex; flex-direction: column;
            z-index: 100;
            overflow-y: auto;
        }

        .sidebar-logo {
            padding: 24px 20px;
            border-bottom: 1px solid var(--card-border);
        }

        .sidebar-logo .logo-text {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--grad-1), var(--accent-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-logo .logo-sub {
            font-size: 0.72rem;
            color: var(--muted);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .sidebar-nav { padding: 20px 12px; flex: 1; }

        .nav-section-title {
            font-size: 0.65rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--muted);
            padding: 8px 12px;
            margin-top: 12px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 10px;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 2px;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: var(--text);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(255,107,53,0.2), rgba(108,99,255,0.2));
            color: var(--accent);
            border: 1px solid rgba(255,107,53,0.3);
        }

        .nav-link i { width: 18px; text-align: center; font-size: 0.9rem; }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--card-border);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--grad-1), var(--accent-2));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
            color: white;
            flex-shrink: 0;
        }

        .user-name { font-size: 0.85rem; font-weight: 600; }
        .user-role { font-size: 0.72rem; color: var(--muted); }

        /* ── Main Layout ─────────────────────────── */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Topbar ──────────────────────────────── */
        .topbar {
            background: var(--dark-2);
            border-bottom: 1px solid var(--card-border);
            padding: 0 28px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .topbar-actions { display: flex; align-items: center; gap: 12px; }

        /* ── Content ─────────────────────────────── */
        .content { padding: 28px; flex: 1; }

        /* ── Cards ───────────────────────────────── */
        .card {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 20px;
        }

        .card-title {
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 16px;
        }

        /* ── Stat Cards ──────────────────────────── */
        .stat-card {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 20px 24px;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.3); }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 80px; height: 80px;
            border-radius: 50%;
            opacity: 0.15;
        }

        .stat-card.orange::before { background: var(--grad-1); }
        .stat-card.purple::before { background: var(--accent-2); }
        .stat-card.teal::before   { background: var(--accent-3); }
        .stat-card.yellow::before { background: var(--warning); }

        .stat-icon {
            width: 46px; height: 46px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            margin-bottom: 14px;
        }

        .stat-icon.orange { background: rgba(255,107,53,0.15); color: var(--grad-1); }
        .stat-icon.purple { background: rgba(108,99,255,0.15); color: var(--accent-2); }
        .stat-icon.teal   { background: rgba(0,217,181,0.15);  color: var(--accent-3); }
        .stat-icon.yellow { background: rgba(255,184,0,0.15);  color: var(--warning); }

        .stat-value {
            font-family: 'Syne', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-label { font-size: 0.8rem; color: var(--muted); }

        /* ── Buttons ─────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--grad-1), #FF8C5A);
            color: white;
        }

        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }

        .btn-secondary {
            background: rgba(255,255,255,0.06);
            color: var(--text);
            border: 1px solid var(--card-border);
        }

        .btn-secondary:hover { background: rgba(255,255,255,0.1); }

        .btn-danger {
            background: rgba(255,71,87,0.15);
            color: var(--danger);
            border: 1px solid rgba(255,71,87,0.3);
        }

        .btn-danger:hover { background: rgba(255,71,87,0.25); }

        .btn-success {
            background: rgba(0,217,181,0.15);
            color: var(--success);
            border: 1px solid rgba(0,217,181,0.3);
        }

        .btn-sm { padding: 7px 14px; font-size: 0.8rem; }

        /* ── Table ───────────────────────────────── */
        .table-wrapper { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            text-align: left;
            padding: 10px 14px;
            font-size: 0.75rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--muted);
            border-bottom: 1px solid var(--card-border);
        }

        tbody td {
            padding: 13px 14px;
            font-size: 0.87rem;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            vertical-align: middle;
        }

        tbody tr:hover { background: rgba(255,255,255,0.02); }

        /* ── Badges ──────────────────────────────── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success  { background: rgba(0,217,181,0.15);  color: var(--success); }
        .badge-danger   { background: rgba(255,71,87,0.15);   color: var(--danger); }
        .badge-warning  { background: rgba(255,184,0,0.15);   color: var(--warning); }
        .badge-info     { background: rgba(108,99,255,0.15);  color: var(--accent-2); }
        .badge-primary  { background: rgba(255,107,53,0.15);  color: var(--grad-1); }
        .badge-secondary{ background: rgba(255,255,255,0.08); color: var(--muted); }

        /* ── Forms ───────────────────────────────── */
        .form-group { margin-bottom: 18px; }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 7px;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--card-border);
            border-radius: 10px;
            padding: 10px 14px;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.88rem;
            transition: border-color 0.2s;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--accent);
            background: rgba(255,107,53,0.04);
        }

        select.form-control option { background: var(--card); }

        .form-error { font-size: 0.78rem; color: var(--danger); margin-top: 4px; }

        /* ── Grid ────────────────────────────────── */
        .grid { display: grid; gap: 20px; }
        .grid-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-4 { grid-template-columns: repeat(4, 1fr); }

        /* ── Alert ───────────────────────────────── */
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.87rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success { background: rgba(0,217,181,0.12); border: 1px solid rgba(0,217,181,0.3); color: var(--success); }
        .alert-danger  { background: rgba(255,71,87,0.12); border: 1px solid rgba(255,71,87,0.3);  color: var(--danger); }
        .alert-warning { background: rgba(255,184,0,0.12); border: 1px solid rgba(255,184,0,0.3);  color: var(--warning); }

        /* ── Scrollbar ───────────────────────────── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 3px; }

        /* ── Pagination ──────────────────────────── */
        .pagination { display: flex; gap: 6px; align-items: center; margin-top: 16px; }
        .pagination a, .pagination span {
            padding: 7px 13px;
            border-radius: 8px;
            font-size: 0.83rem;
            text-decoration: none;
        }
        .pagination a { background: rgba(255,255,255,0.06); color: var(--text); border: 1px solid var(--card-border); }
        .pagination a:hover { background: rgba(255,107,53,0.15); border-color: var(--accent); }
        .pagination span.active-page { background: var(--grad-1); color: white; }
        .pagination span.disabled { color: var(--muted); }

        /* ── Misc ────────────────────────────────── */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .section-title { font-family: 'Syne', sans-serif; font-size: 1.2rem; font-weight: 700; }

        .divider { height: 1px; background: var(--card-border); margin: 20px 0; }

        .text-muted { color: var(--muted); }
        .text-accent { color: var(--accent); }
        .text-success { color: var(--success); }
        .text-danger { color: var(--danger); }
        .text-warning { color: var(--warning); }

        .fw-bold { font-weight: 700; }
        .mb-0 { margin-bottom: 0; }
        .mt-4 { margin-top: 16px; }
        .d-flex { display: flex; }
        .align-center { align-items: center; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .flex-wrap { flex-wrap: wrap; }
        .justify-between { justify-content: space-between; }
        .w-full { width: 100%; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; }
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
        }
    </style>

    @stack('styles')
</head>
<body>

@auth
<!-- ── Sidebar ───────────────────────────────────────────── -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-text">🚗 DriveNow</div>
        <div class="logo-sub">Location de voitures</div>
    </div>

    <nav class="sidebar-nav">
        @if(auth()->user()->isAdmin())
            <div class="nav-section-title">Administration</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Tableau de bord
            </a>
            <a href="{{ route('admin.voitures.index') }}" class="nav-link {{ request()->routeIs('admin.voitures.*') ? 'active' : '' }}">
                <i class="fas fa-car"></i> Voitures
            </a>
            <a href="{{ route('admin.reservations.index') }}" class="nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> Réservations
            </a>
            <a href="{{ route('admin.clients.index') }}" class="nav-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Clients
            </a>
        @else
            <div class="nav-section-title">Mon espace</div>
            <a href="{{ route('client.dashboard') }}" class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Accueil
            </a>
            <a href="{{ route('client.catalogue') }}" class="nav-link {{ request()->routeIs('client.catalogue') ? 'active' : '' }}">
                <i class="fas fa-car"></i> Catalogue
            </a>
            <a href="{{ route('client.reservations.index') }}" class="nav-link {{ request()->routeIs('client.reservations.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Mes réservations
            </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin-top: 12px;">
            @csrf
            <button type="submit" class="btn btn-secondary w-full" style="justify-content: center;">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </button>
        </form>
    </div>
</aside>
@endauth

<!-- ── Main ─────────────────────────────────────────────── -->
<div class="{{ auth()->check() ? 'main-wrapper' : '' }}">
    @auth
    <header class="topbar">
        <div class="page-title">@yield('page-title', 'DriveNow')</div>
        <div class="topbar-actions">
            <span style="font-size:0.82rem; color:var(--muted);">
                <i class="fas fa-clock"></i> {{ now()->format('d/m/Y') }}
            </span>
        </div>
    </header>
    @endauth

    <main class="{{ auth()->check() ? 'content' : '' }}">
        @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
