<!DOCTYPE html>
<html lang="en" class="dark">
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
            --card-bg: #f8f9fa;
            --border: #e9ecef;
            --sidebar-bg: #141414;
            --sidebar-text: #ffffff;
            --shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .dark {
            --bg: #0a0a0a;
            --text: #ffffff;
            --card-bg: #141414;
            --border: #262626;
            --shadow: 0 20px 50px rgba(0,0,0,0.3);
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
        .side { background: var(--sidebar-bg); color: var(--sidebar-text); padding: 30px 20px; position: sticky; top: 0; height: 100vh; border-right: 1px solid var(--border); }
        .content { padding: 30px; }
        
        .brand { font-size: 24px; font-weight: 800; display: flex; align-items:center; gap: 10px; margin-bottom: 40px; }
        .brand-mark { width: 32px; height: 32px; background: var(--brand); border-radius: 8px; }

        .nav { display: grid; gap: 8px; }
        .nav a, .nav button { 
            padding: 12px 16px; 
            border-radius: 12px; 
            color: #a0a0a0; 
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
        .nav a:hover, .nav button:hover { color: var(--brand); background: rgba(255,107,0,0.05); }
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
        }

        .hidden { display: none !important; }

        .alert { background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: 700; }
        .errors { background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; color: #ef4444; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: 700; }

        @media (max-width: 1024px) {
            .shell { grid-template-columns: 1fr; }
            .side { display: none; }
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
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('grievances.index') }}" class="{{ request()->routeIs('grievances.*') ? 'active' : '' }}">Grievances</a>
                    <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">Notifications</a>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">Profile</a>
                    
                    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.05);">
                        <a href="{{ route('grievances.create') }}" class="btn btn-primary" style="width: 100%; justify-content: center;">
                            <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            Create Ticket
                        </a>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" style="margin-top: 10px;">
                        @csrf
                        <button type="submit" style="color: #ef4444; opacity: 0.8;">Logout</button>
                    </form>
                </nav>
            </aside>
            <main class="content">
                <header class="navbar">
                    <div>
                        <h2 style="margin:0; font-size: 20px;">Welcome, {{ auth()->user()->name }}</h2>
                        <p style="margin:0; font-size: 13px; opacity: 0.6;">Your startup grievance portal</p>
                    </div>
                    <div style="display:flex; gap:12px; align-items:center;">
                        <button id="theme-toggle" class="theme-toggle">
                            <svg id="sun-icon" class="hidden" style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <svg id="moon-icon" style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path></svg>
                        </button>
                        <a href="{{ route('grievances.create') }}" class="btn btn-primary">New Ticket</a>
                    </div>
                </header>
                @include('partials.flash')
                @yield('content')
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
                <div style="text-align:center; margin-top: 20px;">
                    <button id="theme-toggle" class="theme-toggle">Toggle Theme</button>
                </div>
            </div>
        </div>
    @endauth

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;
        const sunIcon = document.getElementById('sun-icon');
        const moonIcon = document.getElementById('moon-icon');

        const updateIcons = (isDark) => {
            if (sunIcon && moonIcon) {
                sunIcon.style.display = isDark ? 'block' : 'none';
                moonIcon.style.display = isDark ? 'none' : 'block';
            }
        };

        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
            updateIcons(true);
        } else {
            html.classList.remove('dark');
            updateIcons(false);
        }

        themeToggle.addEventListener('click', () => {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
                updateIcons(false);
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
                updateIcons(true);
            }
        });
    </script>
</body>
</html>
