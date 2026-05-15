<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ResolveX') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#102132; --muted:#5f7083; --line:#d8e1ea; --panel-soft:rgba(255,255,255,0.86); --brand:#0f6c78; --brand-strong:#0b4f59; --brand2:#ee6c4d; --brand3:#98c1d9; --warn:#b76b12; --danger:#a63d40; --ok:#2a7f62; --shadow:0 20px 50px rgba(16, 33, 50, 0.10); --shadow-soft:0 10px 30px rgba(16, 33, 50, 0.08); }
        * { box-sizing:border-box; }
        html { scroll-behavior:smooth; }
        body { margin:0; font-family:'Manrope', 'Segoe UI', sans-serif; color:var(--ink); background:
            radial-gradient(circle at top left, rgba(152,193,217,0.35), transparent 28%),
            radial-gradient(circle at 88% 14%, rgba(238,108,77,0.18), transparent 14%),
            linear-gradient(180deg, #eef4fb 0%, #f8fbff 45%, #eef3f8 100%);
        }
        body.menu-open { overflow:hidden; }
        a { color:inherit; text-decoration:none; }
        .shell { min-height:100vh; display:grid; grid-template-columns:290px 1fr; }
        .side { background:linear-gradient(180deg, #0f2235 0%, #14314a 52%, #1f4f69 100%); color:#eef6ff; padding:0; position:sticky; top:0; height:100vh; overflow:hidden; box-shadow:18px 0 45px rgba(10, 24, 40, 0.12); z-index:40; }
        .side::before { content:''; position:absolute; inset:auto -60px -90px auto; width:180px; height:180px; border-radius:50%; background:radial-gradient(circle, rgba(238,108,77,0.36), transparent 68%); pointer-events:none; }
        .side::after { content:''; position:absolute; inset:24px auto auto -70px; width:160px; height:160px; border-radius:50%; background:radial-gradient(circle, rgba(152,193,217,0.20), transparent 70%); pointer-events:none; }
        .side-scroll { height:100%; overflow-y:auto; overflow-x:hidden; padding:26px 22px; position:relative; z-index:1; scrollbar-width:thin; scrollbar-color:rgba(152,193,217,0.45) transparent; }
        .side-scroll::-webkit-scrollbar { width:8px; }
        .side-scroll::-webkit-scrollbar-thumb { background:rgba(152,193,217,0.36); border-radius:999px; }
        .brand-wrap { margin-bottom:24px; }
        .brand { font-family:'Space Grotesk', 'Manrope', sans-serif; font-size:30px; font-weight:700; margin-bottom:6px; letter-spacing:-0.04em; display:flex; align-items:center; gap:10px; }
        .brand-mark { width:34px; height:34px; border-radius:12px; background:linear-gradient(135deg, rgba(152,193,217,0.9), rgba(238,108,77,0.95)); box-shadow:0 12px 20px rgba(10,24,40,0.18); position:relative; overflow:hidden; }
        .brand-mark::before { content:''; position:absolute; inset:7px 13px 7px 8px; border:2px solid rgba(255,255,255,0.88); border-radius:999px; transform:skewX(-10deg); }
        .tag { color:#b6d0e2; font-size:13px; max-width:210px; line-height:1.5; }
        .user-chip { margin-top:18px; padding:14px; border-radius:18px; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.1); }
        .user-chip strong { display:block; font-size:15px; }
        .user-chip span { display:block; color:#b6d0e2; font-size:12px; margin-top:3px; }
        .nav { display:grid; gap:10px; margin-top:24px; }
        .nav a, .nav button { width:100%; text-align:left; border:1px solid transparent; color:#eef6ff; background:transparent; padding:12px 14px; border-radius:14px; cursor:pointer; font-weight:700; transition:all .2s ease; }
        .nav a:hover, .nav button:hover { background:rgba(255,255,255,0.10); border-color:rgba(255,255,255,0.12); transform:translateX(2px); }
        .nav a.active, .nav button.active { background:linear-gradient(135deg, rgba(255,255,255,0.16), rgba(152,193,217,0.18)); border-color:rgba(255,255,255,0.18); box-shadow:inset 0 1px 0 rgba(255,255,255,0.12); }
        .nav-label { display:block; font-size:11px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:#b6d0e2; margin:10px 0 2px; padding:0 4px; }
        .side-footer { margin-top:24px; padding:14px; border-radius:18px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.08); color:#cfe1ee; font-size:12px; line-height:1.6; }
        .content { padding:22px 28px 28px; min-width:0; }
        .content-inner { max-width:1320px; margin:0 auto; }
        .navbar { position:sticky; top:14px; z-index:30; display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:22px; padding:14px 18px; border-radius:22px; background:rgba(255,255,255,0.72); border:1px solid rgba(188,201,214,0.5); backdrop-filter:blur(14px); box-shadow:var(--shadow-soft); }
        .navbar-left { display:flex; align-items:center; gap:14px; min-width:0; }
        .menu-toggle { display:none; width:46px; height:46px; border-radius:14px; border:1px solid rgba(15,108,120,0.14); background:#fff; color:var(--brand); cursor:pointer; align-items:center; justify-content:center; box-shadow:var(--shadow-soft); }
        .menu-toggle svg { width:22px; height:22px; }
        .navbar-title { display:flex; flex-direction:column; gap:4px; min-width:0; }
        .crumb { display:inline-flex; align-items:center; gap:8px; color:var(--muted); font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:.1em; }
        .navbar-subtitle { color:var(--muted); margin:0; line-height:1.5; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .navbar-right { display:flex; gap:10px; flex-wrap:wrap; justify-content:flex-end; align-items:center; }
        .nav-pills { display:flex; gap:8px; flex-wrap:wrap; }
        .nav-pills a { padding:10px 12px; border-radius:999px; background:rgba(15,108,120,0.08); color:var(--brand); font-size:13px; font-weight:800; }
        .top { display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:24px; }
        .title { font-family:'Space Grotesk', 'Manrope', sans-serif; font-size:34px; font-weight:700; letter-spacing:-0.04em; margin:0; }
        .subtitle { color:var(--muted); margin:7px 0 0; line-height:1.6; }
        .grid { display:grid; gap:18px; }
        .grid-4 { grid-template-columns:repeat(4, minmax(0,1fr)); }
        .grid-2 { grid-template-columns:repeat(2, minmax(0,1fr)); }
        .card { background:linear-gradient(180deg, rgba(255,255,255,0.96), rgba(255,255,255,0.88)); border:1px solid rgba(188,201,214,0.65); border-radius:22px; padding:22px; box-shadow:var(--shadow-soft); backdrop-filter:blur(10px); }
        .stat { font-family:'Space Grotesk', 'Manrope', sans-serif; font-size:36px; font-weight:700; letter-spacing:-0.05em; margin-top:10px; }
        .muted { color:var(--muted); }
        .btn { display:inline-flex; align-items:center; justify-content:center; gap:8px; border:1px solid var(--brand); background:linear-gradient(135deg, var(--brand) 0%, var(--brand-strong) 100%); color:white; padding:11px 16px; border-radius:14px; font-weight:800; cursor:pointer; box-shadow:0 12px 24px rgba(15,108,120,0.20); transition:transform .2s ease, box-shadow .2s ease, filter .2s ease; }
        .btn:hover { transform:translateY(-1px); box-shadow:0 16px 28px rgba(15,108,120,0.24); filter:saturate(1.05); }
        .btn.secondary { background:rgba(255,255,255,0.92); color:var(--brand); border-color:rgba(15,108,120,0.18); box-shadow:none; }
        .btn.danger { background:var(--danger); border-color:var(--danger); }
        input, select, textarea { width:100%; border:1px solid var(--line); border-radius:14px; padding:12px 14px; background:rgba(255,255,255,0.96); color:var(--ink); box-shadow:inset 0 1px 0 rgba(255,255,255,0.8); }
        input:focus, select:focus, textarea:focus { outline:none; border-color:var(--brand3); box-shadow:0 0 0 4px rgba(152,193,217,0.28); }
        textarea { min-height:130px; }
        label { display:block; font-size:13px; font-weight:750; margin-bottom:6px; }
        .form-grid { display:grid; grid-template-columns:repeat(2, minmax(0,1fr)); gap:16px; }
        .full { grid-column:1 / -1; }
        .table { width:100%; border-collapse:separate; border-spacing:0; }
        .table th, .table td { padding:14px 12px; border-bottom:1px solid rgba(188,201,214,0.55); text-align:left; vertical-align:top; }
        .table tbody tr:hover td { background:rgba(152,193,217,0.10); }
        .table th { font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:0.08em; }
        .badge { display:inline-flex; padding:6px 10px; border-radius:999px; background:#eef4ff; color:#175cd3; font-size:12px; font-weight:800; }
        .badge.High { background:#fef3f2; color:var(--danger); }
        .badge.Medium { background:#fffaeb; color:var(--warn); }
        .badge.Low { background:#ecfdf3; color:var(--ok); }
        .badge.Resolved { background:#ecfdf3; color:var(--ok); }
        .badge.Submitted { background:#eef4ff; color:#175cd3; }
        .badge.Under { background:#fff3e8; color:#b76b12; }
        .badge.In { background:#edf4ff; color:#285ea8; }
        .badge.Critical { background:#fef3f2; color:var(--danger); }
        .badge.Concerned { background:#fff3e8; color:#b76b12; }
        .badge.Neutral { background:#eef4ff; color:#175cd3; }
        .badge.Calm { background:#ecfdf3; color:var(--ok); }
        .timeline { display:grid; gap:12px; }
        .event { border-left:3px solid var(--brand2); padding:10px 0 10px 16px; background:linear-gradient(90deg, rgba(238,108,77,0.07), transparent 55%); border-radius:0 12px 12px 0; }
        .alert { background:#ecfdf3; border:1px solid #abefc6; color:#05603a; padding:12px; border-radius:12px; margin-bottom:16px; }
        .errors { background:#fef3f2; border:1px solid #fecdca; color:#b42318; padding:12px; border-radius:12px; margin-bottom:16px; }
        .auth { min-height:100vh; display:grid; place-items:center; padding:24px; }
        .auth-card { width:min(500px,100%); background:var(--panel-soft); border:1px solid rgba(188,201,214,0.7); border-radius:30px; padding:28px; box-shadow:var(--shadow); backdrop-filter:blur(12px); position:relative; overflow:hidden; }
        .auth-card::before { content:''; position:absolute; inset:-80px auto auto -80px; width:180px; height:180px; border-radius:50%; background:radial-gradient(circle, rgba(152,193,217,0.28), transparent 66%); }
        .auth-card::after { content:''; position:absolute; inset:auto -80px -80px auto; width:180px; height:180px; border-radius:50%; background:radial-gradient(circle, rgba(238,108,77,0.18), transparent 66%); }
        .auth-card > * { position:relative; z-index:1; }
        .filters { display:grid; grid-template-columns:2fr repeat(3, 1fr) auto; gap:10px; align-items:end; }
        .bar { height:12px; background:#e6edf4; border-radius:999px; overflow:hidden; box-shadow:inset 0 1px 2px rgba(16,33,50,0.08); }
        .bar span { display:block; height:100%; background:linear-gradient(90deg, var(--brand2), var(--brand)); border-radius:999px; }
        .hero-panel { background:linear-gradient(135deg, rgba(15,108,120,0.97), rgba(11,79,89,0.94)); color:#f4fbff; border-radius:28px; padding:28px; box-shadow:var(--shadow); position:relative; overflow:hidden; }
        .hero-panel::after { content:''; position:absolute; width:240px; height:240px; border-radius:50%; right:-80px; top:-80px; background:radial-gradient(circle, rgba(238,108,77,0.36), transparent 70%); }
        .hero-panel .subtitle, .hero-panel .muted { color:rgba(244,251,255,0.78); }
        .stack { display:grid; gap:14px; }
        .soft-note { display:inline-flex; align-items:center; gap:10px; padding:10px 14px; border-radius:14px; background:rgba(152,193,217,0.12); color:var(--brand); font-size:13px; font-weight:800; }
        .side-overlay { display:none; }
        @media (max-width:1080px) {
            .shell { grid-template-columns:1fr; }
            .side { position:fixed; left:0; top:0; bottom:0; width:300px; max-width:88vw; height:100vh; transform:translateX(-102%); transition:transform .24s ease; }
            .side.is-open { transform:translateX(0); }
            .menu-toggle { display:inline-flex; }
            .side-overlay { display:block; position:fixed; inset:0; background:rgba(8, 17, 28, 0.5); opacity:0; pointer-events:none; transition:opacity .2s ease; z-index:35; }
            .side-overlay.is-open { opacity:1; pointer-events:auto; }
            .content { padding:18px; }
        }
        @media (max-width:900px) {
            .grid-4,.grid-2,.form-grid,.filters { grid-template-columns:1fr; }
            .title { font-size:28px; }
            .navbar { top:10px; padding:12px 14px; }
            .navbar, .top { flex-direction:column; align-items:flex-start; }
            .navbar-right { width:100%; justify-content:flex-start; }
            .nav-pills { width:100%; overflow:auto; padding-bottom:4px; flex-wrap:nowrap; }
            .nav-pills a { white-space:nowrap; }
        }
    </style>
</head>
<body>
@auth
    <div class="side-overlay" id="sidebarOverlay" aria-hidden="true"></div>
    <div class="shell">
        <aside class="side" id="appSidebar">
            <div class="side-scroll">
                <div class="brand-wrap">
                    <div class="brand"><span class="brand-mark"></span>ResolveX</div>
                    <div class="tag">Smart grievance redressal built for startup trust, speed, and accountability.</div>
                    <div class="user-chip">
                        <strong>{{ auth()->user()->name }}</strong>
                        <span>{{ ucfirst(auth()->user()->role) }} | {{ ucfirst(auth()->user()->user_type) }}</span>
                    </div>
                </div>
                <nav class="nav">
                    <span class="nav-label">Workspace</span>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('grievances.index') }}" class="{{ request()->routeIs('grievances.index', 'grievances.show') ? 'active' : '' }}">Grievances</a>
                    <a href="{{ route('grievances.create') }}" class="{{ request()->routeIs('grievances.create') ? 'active' : '' }}">Submit Ticket</a>
                    <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">Notifications @if(auth()->user()->unreadNotifications->count()) ({{ auth()->user()->unreadNotifications->count() }}) @endif</a>
                    @if(auth()->user()->isAdmin())
                        <span class="nav-label">Admin</span>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">Admin Dashboard</a>
                        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">User Controls</a>
                    @endif
                    <span class="nav-label">Account</span>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </nav>
                <div class="side-footer">
                    Track, escalate, and resolve complaints without losing the timeline. The sidebar now scrolls independently, so long navigation stays usable on smaller screens too.
                </div>
            </div>
        </aside>
        <main class="content">
            <div class="content-inner">
                <div class="navbar">
                    <div class="navbar-left">
                        <button class="menu-toggle" id="sidebarToggle" type="button" aria-label="Toggle sidebar" aria-expanded="false" aria-controls="appSidebar">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                                <path d="M4 7h16"></path>
                                <path d="M4 12h16"></path>
                                <path d="M4 17h16"></path>
                            </svg>
                        </button>
                        <div class="navbar-title">
                            <span class="crumb">ResolveX workspace</span>
                            <p class="navbar-subtitle">Keep every grievance moving with more clarity and less guesswork.</p>
                        </div>
                    </div>
                    <div class="navbar-right">
                        <div class="nav-pills">
                            <a href="{{ route('dashboard') }}">Overview</a>
                            <a href="{{ route('grievances.index') }}">Ticket Queue</a>
                            <a href="{{ route('notifications.index') }}">Updates</a>
                        </div>
                        <a class="btn secondary" href="{{ route('landing') }}">View Landing</a>
                        <a class="btn" href="{{ route('grievances.create') }}">New Ticket</a>
                    </div>
                </div>
                @include('partials.flash')
                @yield('content')
            </div>
        </main>
    </div>
    <script>
        (function () {
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('appSidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (!toggle || !sidebar || !overlay) {
                return;
            }

            const setOpen = (open) => {
                sidebar.classList.toggle('is-open', open);
                overlay.classList.toggle('is-open', open);
                document.body.classList.toggle('menu-open', open);
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            };

            toggle.addEventListener('click', () => {
                const isOpen = sidebar.classList.contains('is-open');
                setOpen(!isOpen);
            });

            overlay.addEventListener('click', () => setOpen(false));

            window.addEventListener('resize', () => {
                if (window.innerWidth > 1080) {
                    setOpen(false);
                }
            });
        })();
    </script>
@else
    <main class="auth">
        <div class="auth-card">
            @include('partials.flash')
            @yield('content')
        </div>
    </main>
@endauth
</body>
</html>
