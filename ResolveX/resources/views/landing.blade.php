<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ResolveX') }} | Startup Grievance Redressal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#142032; --muted:#607186; --line:rgba(255,255,255,0.18); --paper:#f7f9fc; --card:rgba(255,255,255,0.78); --card-strong:#ffffff; --navy:#0d1c2d; --brand:#0f6c78; --brand-deep:#0b4f59; --accent:#f06a43; --accent-soft:#ffcfbf; --sky:#98c1d9; --ok:#2a7f62; --shadow:0 24px 70px rgba(15, 30, 50, 0.16); }
        * { box-sizing:border-box; }
        html { scroll-behavior:smooth; }
        body { margin:0; font-family:'Manrope', 'Segoe UI', sans-serif; color:var(--ink); background:
            radial-gradient(circle at 10% 20%, rgba(152,193,217,0.45), transparent 26%),
            radial-gradient(circle at 88% 18%, rgba(240,106,67,0.18), transparent 18%),
            linear-gradient(180deg, #eef4fb 0%, #f9fbfe 48%, #eef3f8 100%);
        }
        a { color:inherit; text-decoration:none; }
        .landing-shell { max-width:1240px; margin:0 auto; padding:24px; }
        .topbar { display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:26px; }
        .brand-lockup { display:flex; align-items:center; gap:14px; }
        .brand-mark { width:44px; height:44px; border-radius:14px; background:linear-gradient(135deg, var(--brand), var(--accent)); box-shadow:0 18px 30px rgba(15,108,120,0.2); position:relative; overflow:hidden; }
        .brand-mark::before, .brand-mark::after { content:''; position:absolute; border-radius:999px; }
        .brand-mark::before { inset:9px 18px 9px 10px; border:2px solid rgba(255,255,255,0.85); transform:skewX(-8deg); }
        .brand-mark::after { width:16px; height:16px; right:7px; top:7px; background:rgba(255,255,255,0.26); }
        .brand-title { font-family:'Space Grotesk', 'Manrope', sans-serif; font-size:26px; font-weight:700; letter-spacing:-0.04em; }
        .brand-copy { color:var(--muted); font-size:13px; margin-top:2px; }
        .nav-actions { display:flex; gap:12px; flex-wrap:wrap; }
        .btn { display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:12px 18px; border-radius:16px; font-weight:800; border:1px solid transparent; transition:transform .2s ease, box-shadow .2s ease, background .2s ease; }
        .btn:hover { transform:translateY(-1px); }
        .btn-primary { background:linear-gradient(135deg, var(--brand), var(--brand-deep)); color:#fff; box-shadow:0 14px 28px rgba(15,108,120,0.24); }
        .btn-secondary { background:rgba(255,255,255,0.78); color:var(--brand); border-color:rgba(15,108,120,0.14); }
        .hero { position:relative; overflow:hidden; border-radius:34px; background:linear-gradient(135deg, rgba(13,28,45,0.97), rgba(17,63,89,0.95) 55%, rgba(15,108,120,0.92)); color:#eff8ff; padding:34px; box-shadow:var(--shadow); }
        .hero::before { content:''; position:absolute; inset:-80px auto auto -80px; width:240px; height:240px; border-radius:50%; background:radial-gradient(circle, rgba(152,193,217,0.3), transparent 68%); }
        .hero::after { content:''; position:absolute; inset:auto -100px -110px auto; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle, rgba(240,106,67,0.3), transparent 70%); }
        .hero-grid { display:grid; grid-template-columns:1.2fr .8fr; gap:28px; position:relative; z-index:1; align-items:stretch; }
        .eyebrow { display:inline-flex; align-items:center; gap:8px; padding:7px 12px; border-radius:999px; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.12); font-size:12px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; }
        .hero-title { font-family:'Space Grotesk', 'Manrope', sans-serif; font-size:clamp(42px, 6vw, 68px); line-height:.98; letter-spacing:-0.06em; margin:18px 0 16px; max-width:720px; }
        .hero-copy { color:rgba(239,248,255,0.76); font-size:18px; line-height:1.75; max-width:640px; }
        .hero-actions { display:flex; gap:14px; flex-wrap:wrap; margin-top:24px; }
        .hero-metrics { display:grid; grid-template-columns:repeat(3, minmax(0,1fr)); gap:14px; margin-top:26px; }
        .metric { padding:18px; border-radius:22px; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.1); backdrop-filter:blur(12px); }
        .metric strong { display:block; font-family:'Space Grotesk', 'Manrope', sans-serif; font-size:32px; letter-spacing:-0.05em; margin-bottom:6px; }
        .metric span { color:rgba(239,248,255,0.72); font-size:13px; }
        .hero-panel { background:linear-gradient(180deg, rgba(255,255,255,0.96), rgba(255,255,255,0.84)); color:var(--ink); border-radius:28px; padding:24px; border:1px solid rgba(255,255,255,0.28); box-shadow:0 20px 45px rgba(7, 21, 40, 0.18); display:grid; gap:18px; align-self:end; }
        .panel-kicker { font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:.09em; color:var(--brand); }
        .panel-card { background:linear-gradient(180deg, #fbfdff, #edf4fb); border:1px solid rgba(152,193,217,0.3); border-radius:22px; padding:18px; }
        .ticket-head { display:flex; align-items:center; justify-content:space-between; gap:10px; margin-bottom:10px; }
        .ticket-id { font-family:'Space Grotesk', 'Manrope', sans-serif; font-weight:700; letter-spacing:-0.03em; }
        .pill { display:inline-flex; align-items:center; padding:6px 10px; border-radius:999px; font-size:12px; font-weight:800; }
        .pill.high { background:#fef0ec; color:#b9401b; }
        .pill.ok { background:#ebf8f2; color:var(--ok); }
        .panel-line { display:flex; align-items:center; justify-content:space-between; gap:10px; padding:10px 0; border-top:1px solid rgba(20,32,50,0.08); font-size:14px; }
        .section { padding:34px 0 10px; }
        .section-head { display:flex; justify-content:space-between; gap:16px; align-items:end; margin-bottom:20px; flex-wrap:wrap; }
        .section-title { font-family:'Space Grotesk', 'Manrope', sans-serif; font-size:32px; letter-spacing:-0.05em; margin:0; }
        .section-copy { color:var(--muted); max-width:620px; line-height:1.7; }
        .feature-grid { display:grid; grid-template-columns:repeat(3, minmax(0,1fr)); gap:18px; }
        .card { background:linear-gradient(180deg, rgba(255,255,255,0.95), rgba(255,255,255,0.86)); border:1px solid rgba(188,201,214,0.52); border-radius:28px; padding:22px; box-shadow:0 16px 34px rgba(16,33,50,0.07); }
        .card-icon { width:46px; height:46px; border-radius:15px; background:linear-gradient(135deg, rgba(15,108,120,0.14), rgba(240,106,67,0.16)); display:grid; place-items:center; font-family:'Space Grotesk', 'Manrope', sans-serif; font-weight:700; color:var(--brand); margin-bottom:16px; }
        .card h3 { margin:0 0 8px; font-size:21px; font-family:'Space Grotesk', 'Manrope', sans-serif; letter-spacing:-0.03em; }
        .card p { margin:0; color:var(--muted); line-height:1.7; }
        .workflow { display:grid; grid-template-columns:repeat(5, minmax(0,1fr)); gap:14px; }
        .step { position:relative; padding:22px; border-radius:24px; background:linear-gradient(180deg, rgba(255,255,255,0.95), rgba(246,249,253,0.92)); border:1px solid rgba(188,201,214,0.48); min-height:180px; }
        .step-number { display:inline-flex; width:34px; height:34px; border-radius:12px; align-items:center; justify-content:center; background:linear-gradient(135deg, var(--brand), var(--accent)); color:#fff; font-weight:800; margin-bottom:14px; }
        .step h4 { margin:0 0 8px; font-size:18px; font-family:'Space Grotesk', 'Manrope', sans-serif; }
        .step p { margin:0; color:var(--muted); line-height:1.6; font-size:14px; }
        .cta-band { margin:30px 0 8px; border-radius:32px; padding:28px; background:linear-gradient(135deg, rgba(255,255,255,0.94), rgba(226,239,249,0.88)); border:1px solid rgba(152,193,217,0.34); display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; }
        .cta-band h3 { margin:0 0 8px; font-size:28px; font-family:'Space Grotesk', 'Manrope', sans-serif; letter-spacing:-0.04em; }
        .cta-band p { margin:0; color:var(--muted); max-width:700px; }
        .footer { padding:18px 0 36px; color:var(--muted); font-size:14px; display:flex; justify-content:space-between; gap:10px; flex-wrap:wrap; }
        @media (max-width:1024px) { .hero-grid, .feature-grid, .workflow { grid-template-columns:1fr; } .hero-metrics { grid-template-columns:1fr; } }
        @media (max-width:680px) { .landing-shell { padding:18px; } .hero { padding:24px; border-radius:28px; } .hero-title { font-size:42px; } .topbar, .hero-actions, .cta-band { align-items:stretch; } .btn, .hero-actions a, .nav-actions a { width:100%; } }
    </style>
</head>
<body>
    <div class="landing-shell">
        <header class="topbar">
            <div class="brand-lockup">
                <div class="brand-mark"></div>
                <div>
                    <div class="brand-title">ResolveX</div>
                    <div class="brand-copy">Smart grievance redressal for fast-moving startup teams</div>
                </div>
            </div>
            <nav class="nav-actions">
                <a href="{{ route('login') }}" class="btn btn-secondary">Sign in</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Get started</a>
            </nav>
        </header>

        <section class="hero">
            <div class="hero-grid">
                <div>
                    <div class="eyebrow">SLA-aware startup support system</div>
                    <h1 class="hero-title">Move complaints from silent frustration to visible resolution.</h1>
                    <p class="hero-copy">ResolveX helps founders, employees, moderators, and admins manage startup grievances with ticket tracking, escalation, feedback loops, and analytics that surface what needs attention now.</p>
                    <div class="hero-actions">
                        <a href="{{ route('register') }}" class="btn btn-primary">Launch your workspace</a>
                        <a href="{{ route('login') }}" class="btn btn-secondary">Open demo login</a>
                    </div>
                    <div class="hero-metrics">
                        <div class="metric">
                            <strong>4-stage</strong>
                            <span>Workflow from submission to resolution</span>
                        </div>
                        <div class="metric">
                            <strong>SLA + AI</strong>
                            <span>Smart urgency, category hints, and escalation support</span>
                        </div>
                        <div class="metric">
                            <strong>360°</strong>
                            <span>Admin analytics, feedback, chat, and notifications</span>
                        </div>
                    </div>
                </div>
                <aside class="hero-panel">
                    <div>
                        <div class="panel-kicker">Live ticket preview</div>
                        <h2 style="margin:8px 0 0; font-size:28px; font-family:'Space Grotesk', 'Manrope', sans-serif; letter-spacing:-0.04em;">A modern command center for sensitive issues</h2>
                    </div>
                    <div class="panel-card">
                        <div class="ticket-head">
                            <div class="ticket-id">RX-20260516-AI82K</div>
                            <span class="pill high">High priority</span>
                        </div>
                        <div style="font-weight:800; margin-bottom:8px;">Payroll delay complaint with anonymous mode enabled</div>
                        <div style="color:var(--muted); line-height:1.65; font-size:14px;">Classifier recommends HR review, SLA deadline is 24 hours, and leadership escalation is triggered if no progress is recorded.</div>
                        <div class="panel-line"><span>Status</span><strong>Under Review</strong></div>
                        <div class="panel-line"><span>Sentiment</span><strong>Critical</strong></div>
                        <div class="panel-line"><span>Assigned</span><strong>Moderator queue</strong></div>
                        <div class="panel-line"><span>Next milestone</span><strong>Response within 2h</strong></div>
                    </div>
                    <div class="panel-card">
                        <div class="panel-kicker" style="margin-bottom:10px;">Why teams choose it</div>
                        <div style="display:grid; gap:10px;">
                            <div class="panel-line"><span>Anonymous reporting</span><span class="pill ok">Enabled</span></div>
                            <div class="panel-line"><span>Feedback after resolution</span><span class="pill ok">Built in</span></div>
                            <div class="panel-line"><span>Admin analytics export</span><span class="pill ok">Ready</span></div>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <section class="section" id="features">
            <div class="section-head">
                <div>
                    <h2 class="section-title">Built for serious startup operations</h2>
                    <p class="section-copy">The platform goes beyond a basic complaint form. It gives teams a structured way to intake issues, coordinate action, and prove follow-through with visible timelines and insights.</p>
                </div>
            </div>
            <div class="feature-grid">
                <article class="card">
                    <div class="card-icon">01</div>
                    <h3>Role-based workspaces</h3>
                    <p>Founders, employees, moderators, and admins each get a focused experience with the controls and visibility they actually need.</p>
                </article>
                <article class="card">
                    <div class="card-icon">02</div>
                    <h3>Tracking that feels accountable</h3>
                    <p>Every complaint becomes a ticket with status progression, ownership, activity timeline, attachment support, and resolution feedback.</p>
                </article>
                <article class="card">
                    <div class="card-icon">03</div>
                    <h3>Escalation and analytics</h3>
                    <p>Surface overdue cases faster with SLA watch, smart urgency cues, notification flows, and charts for category and response trends.</p>
                </article>
            </div>
        </section>

        <section class="section">
            <div class="section-head">
                <div>
                    <h2 class="section-title">Simple path from complaint to closure</h2>
                    <p class="section-copy">The workflow stays understandable for users while still giving the admin side enough depth to feel like a real product, not a classroom mockup.</p>
                </div>
            </div>
            <div class="workflow">
                <article class="step">
                    <div class="step-number">1</div>
                    <h4>User submits issue</h4>
                    <p>Choose category, set priority, attach documents, and submit anonymously when the situation demands privacy.</p>
                </article>
                <article class="step">
                    <div class="step-number">2</div>
                    <h4>Platform enriches ticket</h4>
                    <p>ResolveX assigns a ticket ID, estimates urgency, suggests a category, and sets the first SLA target automatically.</p>
                </article>
                <article class="step">
                    <div class="step-number">3</div>
                    <h4>Moderator or admin acts</h4>
                    <p>Cases get assigned, commented on, updated through the status pipeline, and escalated if the clock or risk level demands it.</p>
                </article>
                <article class="step">
                    <div class="step-number">4</div>
                    <h4>User tracks progress</h4>
                    <p>The timeline remains visible, notifications keep users informed, and the process feels transparent instead of opaque.</p>
                </article>
                <article class="step">
                    <div class="step-number">5</div>
                    <h4>Resolution gets measured</h4>
                    <p>After closure, teams collect feedback and use analytics to improve response quality over time.</p>
                </article>
            </div>
        </section>

        <section class="cta-band">
            <div>
                <h3>Ready to give your project a stronger first impression?</h3>
                <p>Use the redesigned landing page as the front door for demos and evaluators, then guide them into a cleaner in-app experience built around clarity, trust, and momentum.</p>
            </div>
            <div class="nav-actions">
                <a href="{{ route('register') }}" class="btn btn-primary">Create account</a>
                <a href="{{ route('login') }}" class="btn btn-secondary">Sign in to dashboard</a>
            </div>
        </section>

        <footer class="footer">
            <span>ResolveX positions your project as a smart grievance redressal platform for startups.</span>
            <span>Ticketing, escalation, analytics, and accountability in one place.</span>
        </footer>
    </div>
</body>
</html>
