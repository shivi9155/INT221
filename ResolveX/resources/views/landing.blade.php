<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ResolveX') }} | Startup Grievance Redressal</title>
    <meta name="description" content="ResolveX — AI-powered grievance redressal platform built for startups. File, track, and resolve issues in record time.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand: #ff6b00;
            --bg: #0a0a0a;
            --text: #ffffff;
            --card-bg: #141414;
            --border: #262626;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Instrument Sans', sans-serif; background: var(--bg); color: var(--text); overflow-x: hidden; }
        a { text-decoration: none; }

        /* NAV */
        .nav { display: flex; justify-content: space-between; align-items: center; padding: 20px 60px; position: fixed; top: 0; left: 0; right: 0; z-index: 100; background: rgba(10,10,10,0.8); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); }
        .nav-brand { font-size: 22px; font-weight: 900; display: flex; align-items: center; gap: 10px; }
        .brand-dot { width: 28px; height: 28px; background: var(--brand); border-radius: 8px; }
        .nav-links { display: flex; gap: 32px; align-items: center; }
        .nav-links a { font-size: 14px; font-weight: 600; opacity: 0.6; color: var(--text); transition: opacity 0.2s; }
        .nav-links a:hover { opacity: 1; }

        /* BUTTONS */
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 12px; font-weight: 800; cursor: pointer; transition: all 0.2s; font-size: 14px; border: none; }
        .btn-primary { background: var(--brand); color: #000; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(255,107,0,0.35); }
        .btn-outline { background: transparent; border: 1px solid rgba(255,255,255,0.15); color: var(--text); }
        .btn-outline:hover { border-color: var(--brand); color: var(--brand); }

        /* HERO */
        .hero { min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 120px 40px 80px; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; top: 20%; left: 50%; transform: translate(-50%, -50%); width: 600px; height: 600px; background: radial-gradient(circle, rgba(255,107,0,0.12) 0%, transparent 70%); pointer-events: none; }
        .hero::after { content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 100%; height: 1px; background: linear-gradient(to right, transparent, rgba(255,107,0,0.3), transparent); }

        .hero-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(255,107,0,0.08); border: 1px solid rgba(255,107,0,0.2); padding: 8px 20px; border-radius: 99px; font-size: 13px; font-weight: 700; color: var(--brand); margin-bottom: 32px; }
        .hero-badge span { width: 6px; height: 6px; border-radius: 50%; background: var(--brand); animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: 0.3; } }

        .hero h1 { font-size: clamp(40px, 7vw, 84px); font-weight: 900; line-height: 1.05; letter-spacing: -3px; max-width: 900px; margin-bottom: 24px; }
        .hero h1 span { color: var(--brand); }
        .hero p { font-size: 18px; opacity: 0.5; max-width: 560px; line-height: 1.7; margin-bottom: 48px; font-weight: 500; }

        .hero-cta { display: flex; gap: 16px; align-items: center; flex-wrap: wrap; justify-content: center; }

        .hero-stats { display: flex; gap: 48px; margin-top: 80px; padding-top: 48px; border-top: 1px solid var(--border); flex-wrap: wrap; justify-content: center; }
        .hero-stat { text-align: center; }
        .hero-stat-val { font-size: 36px; font-weight: 900; color: var(--brand); }
        .hero-stat-label { font-size: 13px; opacity: 0.4; margin-top: 4px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }

        /* FEATURES */
        .section { padding: 100px 60px; }
        .section-label { font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 3px; color: var(--brand); margin-bottom: 16px; }
        .section h2 { font-size: clamp(28px, 4vw, 48px); font-weight: 900; letter-spacing: -1.5px; margin-bottom: 16px; }
        .section > p { font-size: 16px; opacity: 0.5; max-width: 500px; line-height: 1.7; margin-bottom: 64px; }

        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; }
        .feature-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 24px; padding: 32px; transition: all 0.3s; }
        .feature-card:hover { border-color: var(--brand); transform: translateY(-4px); box-shadow: 0 20px 60px rgba(255,107,0,0.08); }
        .feature-icon { width: 48px; height: 48px; background: rgba(255,107,0,0.1); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; color: var(--brand); }
        .feature-card h3 { font-size: 18px; font-weight: 800; margin-bottom: 10px; }
        .feature-card p { font-size: 14px; opacity: 0.55; line-height: 1.7; }

        /* BENTO GRID */
        .bento { display: grid; grid-template-columns: repeat(3, 1fr); grid-template-rows: auto; gap: 24px; }
        .bento-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 24px; padding: 32px; }
        .bento-card.span-2 { grid-column: span 2; }
        .bento-card.dark-accent { background: #0f0f0f; border-color: rgba(255,107,0,0.15); }

        /* CTA */
        .cta-section { padding: 100px 60px; text-align: center; background: linear-gradient(135deg, rgba(255,107,0,0.03) 0%, transparent 60%); border-top: 1px solid var(--border); }
        .cta-section h2 { font-size: clamp(28px, 5vw, 56px); font-weight: 900; letter-spacing: -2px; margin-bottom: 16px; }
        .cta-section p { font-size: 16px; opacity: 0.5; margin-bottom: 40px; }

        /* FOOTER */
        .footer { padding: 40px 60px; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; opacity: 0.4; font-size: 13px; }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="nav">
    <div class="nav-brand">
        <div class="brand-dot"></div>
        ResolveX
    </div>
    <div class="nav-links">
        <a href="#features">Features</a>
        <a href="#how">How it works</a>
        <a href="{{ route('login') }}" class="btn btn-outline" style="padding: 8px 20px; font-size: 13px;">Sign In</a>
        <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 8px 20px; font-size: 13px;">Get Started</a>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-badge">
        <span></span> AI-powered grievance intelligence
    </div>
    <h1>Resolve Startup <span>Grievances</span><br>at Machine Speed</h1>
    <p>ResolveX brings SLA tracking, sentiment analysis, and role-based triage to your startup's internal operations — all in one platform.</p>
    <div class="hero-cta">
        <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 16px 36px; font-size: 16px;">
            Start for free
            <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </a>
        <a href="{{ route('login') }}" class="btn btn-outline" style="padding: 16px 36px; font-size: 16px;">Sign in to dashboard</a>
    </div>
    <div class="hero-stats">
        <div class="hero-stat">
            <div class="hero-stat-val">48h</div>
            <div class="hero-stat-label">Avg SLA Target</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat-val">94%</div>
            <div class="hero-stat-label">Resolution Rate</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat-val">AI</div>
            <div class="hero-stat-label">Smart Triage</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat-val">RBAC</div>
            <div class="hero-stat-label">Role-Based Access</div>
        </div>
    </div>
</section>

{{-- FEATURES --}}
<section class="section" id="features">
    <div class="section-label">Platform Features</div>
    <h2>Everything your startup needs<br>to resolve issues fast</h2>
    <p>Built for founders, employees, and administrators who need clarity and speed.</p>

    <div class="features">
        <div class="feature-card">
            <div class="feature-icon">
                <svg style="width:24px;height:24px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
            </div>
            <h3>AI-Powered Classification</h3>
            <p>Every ticket is automatically categorized and given a sentiment score, so the right team sees it first.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <svg style="width:24px;height:24px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3>SLA Tracking & Escalation</h3>
            <p>Automatic SLA deadlines with smart escalation logic. Overdue tickets surface immediately to leadership.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <svg style="width:24px;height:24px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <h3>Role-Based Access Control</h3>
            <p>Admins, moderators, and users each have isolated, purpose-built dashboards. No data leakage.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <svg style="width:24px;height:24px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <h3>Real-Time Analytics</h3>
            <p>Track resolution rates, response times, category trends, and satisfaction scores with live charts.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <svg style="width:24px;height:24px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            </div>
            <h3>CSV Export & Reporting</h3>
            <p>Export full grievance datasets to CSV instantly. Perfect for board presentations and compliance audits.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <svg style="width:24px;height:24px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
            </div>
            <h3>Threaded Activity Timeline</h3>
            <p>Full audit trail for every ticket — comments, status changes, assignments, and escalations.</p>
        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section class="section" id="how" style="background: rgba(255,107,0,0.02); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
    <div class="section-label">How It Works</div>
    <h2>From submission to resolution<br>in three steps</h2>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; margin-top: 20px;">
        <div style="display: flex; gap: 20px; align-items: flex-start;">
            <div style="width: 48px; height: 48px; background: var(--brand); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 900; color: #000; flex-shrink: 0;">1</div>
            <div>
                <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 8px;">File a Ticket</h3>
                <p style="font-size: 14px; opacity: 0.55; line-height: 1.7;">Submit your grievance with category, priority, and description. Attach files if needed.</p>
            </div>
        </div>
        <div style="display: flex; gap: 20px; align-items: flex-start;">
            <div style="width: 48px; height: 48px; background: rgba(255,107,0,0.15); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 900; color: var(--brand); flex-shrink: 0;">2</div>
            <div>
                <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 8px;">AI Triages It</h3>
                <p style="font-size: 14px; opacity: 0.55; line-height: 1.7;">The system analyzes sentiment, assigns categories, and routes to the right team automatically.</p>
            </div>
        </div>
        <div style="display: flex; gap: 20px; align-items: flex-start;">
            <div style="width: 48px; height: 48px; background: rgba(16,185,129,0.1); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 900; color: #10b981; flex-shrink: 0;">3</div>
            <div>
                <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 8px;">Track & Resolve</h3>
                <p style="font-size: 14px; opacity: 0.55; line-height: 1.7;">Get real-time updates as the admin works through the ticket. Rate the resolution when done.</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div style="display: inline-block; background: rgba(255,107,0,0.08); border: 1px solid rgba(255,107,0,0.2); padding: 8px 20px; border-radius: 99px; font-size: 12px; font-weight: 800; color: var(--brand); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 24px;">Free to Start</div>
    <h2>Ready to resolve<br><span style="color: var(--brand);">faster than ever?</span></h2>
    <p>Join startups using ResolveX to manage grievances with intelligence and speed.</p>
    <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
        <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 18px 48px; font-size: 16px;">
            Create your account
        </a>
        <a href="{{ route('login') }}" class="btn btn-outline" style="padding: 18px 48px; font-size: 16px;">
            Sign in
        </a>
    </div>
</section>

{{-- FOOTER --}}
<footer class="footer">
    <div>© {{ date('Y') }} ResolveX — Startup Grievance Platform</div>
    <div>Built with Laravel & AI Intelligence</div>
</footer>

</body>
</html>

