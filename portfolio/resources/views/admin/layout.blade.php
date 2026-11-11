<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin') · Portfolio Admin</title>
  <style>
    :root { --bg:#0f1115; --panel:#181b22; --line:#2a2f3a; --text:#e6e8ee; --muted:#9aa3b2; --accent:#00d1b2; --danger:#ff5d5d; }
    * { box-sizing: border-box; }
    body { margin:0; font-family: system-ui, -apple-system, "Segoe UI", sans-serif; background:var(--bg); color:var(--text); }
    a { color:var(--accent); text-decoration:none; }
    .shell { display:flex; min-height:100vh; }
    .sidebar { width:220px; flex-shrink:0; background:var(--panel); border-right:1px solid var(--line); position:sticky; top:0; height:100vh; display:flex; flex-direction:column; padding:16px 12px; transition:transform .2s ease; z-index:20; }
    .brand { font-weight:700; font-size:1rem; padding:4px 10px 14px; border-bottom:1px solid var(--line); margin-bottom:10px; }
    .sidebar nav { display:flex; flex-direction:column; gap:2px; flex:1; }
    .sidebar nav a { color:var(--muted); padding:8px 10px; border-radius:6px; font-size:0.92rem; }
    .sidebar nav a:hover { background:var(--bg); color:var(--text); }
    .sidebar nav a.active { background:rgba(0,209,178,.12); color:var(--accent); }
    .sidebar .logout { margin-top:10px; width:100%; }
    .topbar { display:none; align-items:center; justify-content:space-between; padding:10px 14px; background:var(--panel); border-bottom:1px solid var(--line); position:sticky; top:0; z-index:10; }
    .menu-btn { background:transparent; color:var(--text); border:1px solid var(--line); border-radius:6px; padding:4px 10px; font-size:1.1rem; cursor:pointer; }
    .backdrop { display:none; }
    .content { flex:1; min-width:0; }
    main { max-width:1100px; margin:20px auto; padding:0 18px; }
    h1 { font-size:1.25rem; margin:0 0 12px; }
    h2 { font-size:1.05rem; margin:0 0 10px; }
    .card { background:var(--panel); border:1px solid var(--line); border-radius:8px; padding:14px; margin-bottom:14px; }
    .stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(170px,1fr)); gap:14px; }
    .stat strong { display:block; font-size:1.5rem; color:var(--accent); }
    .btn { display:inline-block; background:var(--accent); color:#06231e; border:0; padding:6px 12px; border-radius:6px; font-weight:600; cursor:pointer; font-size:0.85rem; }
    .btn.secondary { background:transparent; color:var(--text); border:1px solid var(--line); }
    .btn.danger { background:var(--danger); color:#fff; }
    table { width:100%; border-collapse:collapse; }
    th, td { text-align:left; padding:8px 8px; border-bottom:1px solid var(--line); vertical-align:middle; font-size:0.88rem; }
    .table-wrap { overflow-x:auto; }
    th { color:var(--muted); font-weight:600; }
    td img { width:70px; height:auto; border-radius:4px; }
    label { display:block; margin:12px 0 6px; color:var(--muted); font-size:0.9rem; }
    input[type=text], input[type=email], input[type=password], input[type=number], input[type=file], input[list], textarea, select {
      width:100%; background:var(--bg); color:var(--text); border:1px solid var(--line); border-radius:6px; padding:9px 10px; font-size:0.95rem; }
    textarea { min-height:110px; }
    input[type=range] { width:100%; }
    .row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .actions { margin-top:18px; display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
    .flash { background:#0d3b33; border:1px solid var(--accent); padding:10px 14px; border-radius:6px; margin-bottom:16px; }
    .errors { background:#3b1414; border:1px solid var(--danger); padding:10px 14px; border-radius:6px; margin-bottom:16px; }
    .errors ul { margin:0; padding-left:18px; }
    .preview { margin-top:10px; max-width:180px; border-radius:6px; border:1px solid var(--line); }
    .unread { color:var(--accent); font-weight:700; }
    .inline { display:inline; }
    @media (max-width:800px) {
      .sidebar { position:fixed; left:0; top:0; transform:translateX(-100%); }
      body.nav-open .sidebar { transform:translateX(0); }
      body.nav-open .backdrop { display:block; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:15; }
      .topbar { display:flex; }
      main { padding:0 12px; margin:14px auto; }
    }
    @media (max-width:700px) { .row { grid-template-columns:1fr; } }
  </style>
</head>
<body>
  @auth
  <div class="topbar">
    <strong>Portfolio Admin</strong>
    <button class="menu-btn" type="button" aria-label="Toggle menu" onclick="document.body.classList.toggle('nav-open')">☰</button>
  </div>
  <div class="backdrop" onclick="document.body.classList.remove('nav-open')"></div>
  <div class="shell">
    <aside class="sidebar">
      <div class="brand">Portfolio Admin</div>
      <nav>
        <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a class="{{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}">Projects</a>
        <a class="{{ request()->routeIs('admin.researches.*') ? 'active' : '' }}" href="{{ route('admin.researches.index') }}">Research</a>
        <a class="{{ request()->routeIs('admin.skills.*') ? 'active' : '' }}" href="{{ route('admin.skills.index') }}">Skills</a>
        <a class="{{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}" href="{{ route('admin.certificates.index') }}">Certificates</a>
        <a class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}">Messages</a>
        <a href="{{ route('home') }}">View site</a>
      </nav>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button class="btn secondary logout" type="submit">Log out</button>
      </form>
    </aside>
    <div class="content">
      <main>
        @if (session('success'))
          <div class="flash">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
          <div class="errors"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        @yield('content')
      </main>
    </div>
  </div>
  @else
  <main>
    @yield('content')
  </main>
  @endauth
</body>
</html>
