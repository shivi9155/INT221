<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ResolveX') }}</title>
    <style>
        :root { --ink:#182033; --muted:#667085; --line:#d9e0ea; --bg:#f6f8fb; --panel:#fff; --brand:#176b87; --brand2:#0f8b8d; --warn:#b54708; --danger:#b42318; --ok:#067647; }
        * { box-sizing:border-box; }
        body { margin:0; font-family:Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Arial, sans-serif; color:var(--ink); background:var(--bg); }
        a { color:inherit; text-decoration:none; }
        .shell { min-height:100vh; display:grid; grid-template-columns:260px 1fr; }
        .side { background:#122031; color:#eef6ff; padding:24px; position:sticky; top:0; height:100vh; }
        .brand { font-size:24px; font-weight:800; margin-bottom:4px; }
        .tag { color:#a8c3d8; font-size:13px; margin-bottom:28px; }
        .nav { display:grid; gap:8px; }
        .nav a, .nav button { width:100%; text-align:left; border:0; color:#eef6ff; background:transparent; padding:11px 12px; border-radius:7px; cursor:pointer; font-weight:650; }
        .nav a:hover, .nav button:hover { background:#20354e; }
        .content { padding:28px; }
        .top { display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:24px; }
        .title { font-size:28px; font-weight:800; margin:0; }
        .subtitle { color:var(--muted); margin:5px 0 0; }
        .grid { display:grid; gap:16px; }
        .grid-4 { grid-template-columns:repeat(4, minmax(0,1fr)); }
        .grid-2 { grid-template-columns:repeat(2, minmax(0,1fr)); }
        .card { background:var(--panel); border:1px solid var(--line); border-radius:8px; padding:18px; }
        .stat { font-size:30px; font-weight:800; margin-top:8px; }
        .muted { color:var(--muted); }
        .btn { display:inline-flex; align-items:center; justify-content:center; gap:8px; border:1px solid var(--brand); background:var(--brand); color:white; padding:10px 14px; border-radius:7px; font-weight:750; cursor:pointer; }
        .btn.secondary { background:white; color:var(--brand); }
        .btn.danger { background:var(--danger); border-color:var(--danger); }
        input, select, textarea { width:100%; border:1px solid var(--line); border-radius:7px; padding:10px 12px; background:white; color:var(--ink); }
        textarea { min-height:130px; }
        label { display:block; font-size:13px; font-weight:750; margin-bottom:6px; }
        .form-grid { display:grid; grid-template-columns:repeat(2, minmax(0,1fr)); gap:16px; }
        .full { grid-column:1 / -1; }
        .table { width:100%; border-collapse:collapse; }
        .table th, .table td { padding:12px; border-bottom:1px solid var(--line); text-align:left; vertical-align:top; }
        .table th { font-size:12px; color:var(--muted); text-transform:uppercase; }
        .badge { display:inline-flex; padding:4px 8px; border-radius:999px; background:#eef4ff; color:#175cd3; font-size:12px; font-weight:800; }
        .badge.High { background:#fef3f2; color:var(--danger); }
        .badge.Medium { background:#fffaeb; color:var(--warn); }
        .badge.Low { background:#ecfdf3; color:var(--ok); }
        .timeline { display:grid; gap:12px; }
        .event { border-left:3px solid var(--brand2); padding:4px 0 4px 14px; }
        .alert { background:#ecfdf3; border:1px solid #abefc6; color:#05603a; padding:12px; border-radius:7px; margin-bottom:16px; }
        .errors { background:#fef3f2; border:1px solid #fecdca; color:#b42318; padding:12px; border-radius:7px; margin-bottom:16px; }
        .auth { min-height:100vh; display:grid; place-items:center; padding:24px; }
        .auth-card { width:min(460px,100%); }
        .filters { display:grid; grid-template-columns:2fr repeat(3, 1fr) auto; gap:10px; align-items:end; }
        .bar { height:12px; background:#e6edf4; border-radius:999px; overflow:hidden; }
        .bar span { display:block; height:100%; background:var(--brand2); }
        @media (max-width:900px) { .shell { grid-template-columns:1fr; } .side { position:static; height:auto; } .grid-4,.grid-2,.form-grid,.filters { grid-template-columns:1fr; } .content { padding:18px; } }
    </style>
</head>
<body>
@auth
    <div class="shell">
        <aside class="side">
            <div class="brand">ResolveX</div>
            <div class="tag">Smart grievance redressal</div>
            <nav class="nav">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('grievances.index') }}">Grievances</a>
                <a href="{{ route('grievances.create') }}">Submit Ticket</a>
                <a href="{{ route('profile.edit') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </nav>
        </aside>
        <main class="content">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>
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
