<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ResolveX') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])

    <style>
        :root {
            --brand: #ff6b00;
            --brand-deep: #cc5600;
            --bg: #ffffff;
            --text: #0a0a0a;
            --text-secondary: #6b7280;
            --card-bg: #f8f9fa;
            --card-hover: #f0f1f3;
            --border: #e5e7eb;
            --sidebar-bg: #ffffff;
            --sidebar-text: #0a0a0a;
            --sidebar-border: #e5e7eb;
            --shadow: 0 10px 30px rgba(0,0,0,0.08);
            --hover-bg: rgba(255,107,0,0.05);
        }

        html.dark {
            --bg: #0a0a0a;
            --text: #ffffff;
            --text-secondary: #a0a0a0;
            --card-bg: #141414;
            --card-hover: #1a1a1a;
            --border: #262626;
            --sidebar-bg: #0f0f0f;
            --sidebar-text: #ffffff;
            --sidebar-border: #1a1a1a;
            --shadow: 0 20px 50px rgba(0,0,0,0.3);
            --hover-bg: rgba(255,107,0,0.1);
        }

        * { box-sizing: border-box; }
        body { 
            margin: 0; 
            font-family: 'Instrument Sans', sans-serif; 
            background: var(--bg); 
            color: var(--text); 
            transition: background 0.3s, color 0.3s;
        }

        .shell { min-height: 100vh; display: grid; grid-template-columns: 280px 1fr; }
        .side { background: var(--sidebar-bg); color: var(--sidebar-text); padding: 30px 20px; position: sticky; top: 0; height: 100vh; border-right: 1px solid var(--sidebar-border); overflow-y: auto; }
        .content { padding: 30px; background: var(--bg); }
        
        .brand { font-size: 24px; font-weight: 800; display: flex; align-items:center; gap: 10px; margin-bottom: 40px; }
        .brand-mark { width: 32px; height: 32px; background: var(--brand); border-radius: 8px; }

        .nav { display: grid; gap: 8px; }
        .nav a, .nav button { 
            padding: 12px 16px; 
            border-radius: 12px; 
            color: var(--text-secondary); 
            font-weight: 600; 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            transition: all 0.2s; 
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }
        .nav a:hover, .nav button:hover { color: var(--brand); background: var(--hover-bg); }
        .nav a.active { color: #ffffff; background: var(--brand); }

        .navbar { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 40px; 
            padding: 20px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: var(--shadow);
        }

        .btn { 
            padding: 10px 20px; 
            border-radius: 12px; 
            font-weight: 800; 
            cursor: pointer; 
            transition: all 0.2s; 
            display: inline-flex; 
            align-items: center; 
            gap: 8px;
        }
        .btn-primary { background: var(--brand); color: #000; border: none; }
        .btn-secondary { background: transparent; border: 1px solid var(--border); color: var(--text); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255,107,0,0.2); }

        .card { 
            background: var(--card-bg); 
            border: 1px solid var(--border); 
            border-radius: 24px; 
            padding: 24px; 
            box-shadow: var(--shadow);
        }

        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: var(--card-bg); border: 1px solid var(--border); padding: 20px; border-radius: 20px; }
        .stat-val { font-size: 32px; font-weight: 800; color: var(--brand); }

        /* Auth Pages */
        .auth-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: var(--bg); }
        .auth-card { width: 100%; max-width: 450px; }

        .theme-toggle {
            background: var(--card-bg);
            border: 1px solid var(--border);
            color: var(--brand);
            padding: 10px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-toggle:hover {
            background: var(--card-hover);
            box-shadow: 0 2px 8px rgba(255,107,0,0.15);
        }

        .hidden { display: none !important; }
        
        svg.hidden { display: none !important; }

        .alert { background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: 700; }
        .errors { background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; color: #ef4444; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: 700; }

        @media (max-width: 1024px) {
            .shell { grid-template-columns: 1fr; }
            .side { display: none; }
        }

        /* ANIMATIONS */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade { animation: fadeIn 0.4s ease-out forwards; }
        
        .nav a, .nav button, .btn, .card, .stat-card, .theme-toggle {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .side {
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .nav a:active, .nav button:active, .btn:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>
    @auth
        <div class="shell">
            <aside class="side">
                <div class="brand">
                    <div class="brand-mark"></div>
                    ResolveX
                </div>
                <nav class="nav">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        style="display: flex; align-items: center; gap: 10px;">
                        <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('grievances.index') }}" class="{{ request()->routeIs('grievances.*') ? 'active' : '' }}"
                        style="display: flex; align-items: center; gap: 10px;">
                        <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        {{ auth()->user()->isStaff() ? 'All Grievances' : 'My Grievances' }}
                    </a>
                    
                    @if(auth()->user()->isAdmin())
                    <div style="margin: 8px 0; padding: 6px 16px; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; color: var(--brand); opacity: 0.7;">Admin</div>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            style="display: flex; align-items: center; gap: 10px;">
                            <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Command Center
                        </a>
                        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}"
                            style="display: flex; align-items: center; gap: 10px;">
                            <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Identity & Access
                        </a>
                        <a href="{{ route('admin.analytics') }}" class="{{ request()->routeIs('admin.analytics') ? 'active' : '' }}"
                            style="display: flex; align-items: center; gap: 10px;">
                            <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Intelligence
                        </a>
                    @endif

                    <div style="margin: 8px 0; padding: 6px 16px; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; opacity: 0.3;">Account</div>
                    <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}"
                        style="display: flex; align-items: center; gap: 10px;">
                        <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        Notifications
                    </a>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}"
                        style="display: flex; align-items: center; gap: 10px;">
                        <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profile
                    </a>
                    
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.05);">
                        <a href="{{ route('grievances.create') }}" class="btn btn-primary" style="width: 100%; justify-content: center;">
                            <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            File New Ticket
                        </a>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" style="margin-top: 8px;">
                        @csrf
                        <button type="submit" class="btn btn-secondary" style="color: #ef4444; opacity: 0.95; display: flex; align-items: center; gap: 8px; justify-content: center;">
                            <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Logout
                        </button>
                    </form>
                </nav>
            </aside>
            <main class="content">
                <header class="navbar">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 44px; height: 44px; border-radius: 14px; background: var(--brand); display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 18px; color: #000; flex-shrink: 0;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <div>
                            <h2 style="margin:0; font-size: 18px; font-weight: 800;">{{ auth()->user()->name }}</h2>
                            <div style="display: flex; align-items: center; gap: 8px; margin-top: 2px;">
                                <span style="font-size: 12px; opacity: 0.5;">{{ auth()->user()->startup_name ?? 'ResolveX Platform' }}</span>
                                <span style="font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 6px; text-transform: uppercase; letter-spacing: 1px;
                                    background: {{ auth()->user()->isAdmin() ? 'rgba(255,107,0,0.15)' : 'rgba(100,116,139,0.15)' }};
                                    color: {{ auth()->user()->isAdmin() ? 'var(--brand)' : '#64748b' }};">
                                    {{ auth()->user()->roleLabel() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div style="display:flex; gap:12px; align-items:center;">
                        <button id="theme-toggle" class="theme-toggle">
                            <svg id="sun-icon" class="hidden" style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <svg id="moon-icon" style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path></svg>
                        </button>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="font-size: 13px; padding: 8px 16px;">⚡ Command Center</a>
                        @endif
                        <a href="{{ route('grievances.create') }}" class="btn btn-primary">+ New Ticket</a>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn btn-secondary" style="color:#ef4444;">Logout</button>
                        </form>
                    </div>
                </header>
                @include('partials.flash')
                <div class="animate-fade">
                    @yield('content')
                </div>
            </main>
        </div>
    @else
        <div class="auth-container">
            <div class="auth-card">
                <div style="text-align:center; margin-bottom: 30px;">
                    <div style="width:50px; height:50px; background:var(--brand); border-radius:12px; margin: 0 auto 15px;"></div>
                    <h1 style="font-size: 28px; font-weight: 800; margin: 0;">ResolveX</h1>
                </div>
                @include('partials.flash')
                @yield('content')
                <div style="text-align:center; margin-top: 20px; display: flex; justify-content: center;">
                    <button id="theme-toggle-guest" class="theme-toggle">
                        <svg id="sun-icon-guest" class="hidden" style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <svg id="moon-icon-guest" style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    @endauth

    <script>
        // Theme Management System
        const initTheme = () => {
            const html = document.documentElement;
            const themeToggles = [document.getElementById('theme-toggle'), document.getElementById('theme-toggle-guest')];
            const sunIcons = [document.getElementById('sun-icon'), document.getElementById('sun-icon-guest')];
            const moonIcons = [document.getElementById('moon-icon'), document.getElementById('moon-icon-guest')];

            const updateIcons = (isDark) => {
                sunIcons.forEach(icon => {
                    if (icon) {
                        if (isDark) icon.classList.remove('hidden');
                        else icon.classList.add('hidden');
                    }
                });
                moonIcons.forEach(icon => {
                    if (icon) {
                        if (isDark) icon.classList.add('hidden');
                        else icon.classList.remove('hidden');
                    }
                });
            };

            const setTheme = (theme) => {
                if (theme === 'dark') {
                    html.classList.add('dark');
                    localStorage.theme = 'dark';
                    updateIcons(true);
                } else {
                    html.classList.remove('dark');
                    localStorage.theme = 'light';
                    updateIcons(false);
                }
            };

            // Detect initial theme preference
            if (localStorage.theme === 'light') {
                setTheme('light');
            } else if (localStorage.theme === 'dark') {
                setTheme('dark');
            } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                setTheme('dark');
            } else {
                setTheme('light');
            }

            // Toggle theme on button click
            themeToggles.forEach(toggle => {
                if (toggle) {
                    toggle.addEventListener('click', (e) => {
                        e.preventDefault();
                        const isDark = html.classList.contains('dark');
                        setTheme(isDark ? 'light' : 'dark');
                    });
                }
            });
        };

        // Initialize theme immediately and on page load
        document.addEventListener('DOMContentLoaded', initTheme);
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initTheme);
        } else {
            initTheme();
        }
    </script>
    @stack('scripts')
</body>
</html>
