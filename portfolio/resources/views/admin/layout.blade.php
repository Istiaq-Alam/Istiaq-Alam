<!DOCTYPE html>
<html lang="en" data-skin="matrix">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin') · Portfolio Admin</title>
  <link rel="stylesheet" href="{{ asset('theme.css') }}">
  <style>
    :root { --bg:#0f1115; --panel:#181b22; --line:#2a2f3a; --text:#e6e8ee; --muted:#9aa3b2; --accent:#00d1b2; --danger:#ff5d5d; }
    * { box-sizing: border-box; }
    body { margin:0; font-family: system-ui, -apple-system, "Segoe UI", sans-serif; background:#000; color:var(--text); }
    #matrix { display:block; position:fixed; top:0; left:0; z-index:-2; pointer-events:none; }
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
    .item-list { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:12px; }
    .item { background:var(--panel); border:1px solid var(--line); border-radius:8px; padding:10px; display:flex; flex-direction:column; gap:8px; min-width:0; }
    .item-card { border:1px solid transparent; border-radius:14px; box-shadow:0 16px 30px hsla(192,79%,49%,.25); background:linear-gradient(to bottom right, hsla(128,95%,50%,.251) 0%, hsla(0,0%,99%,0) 100%) padding-box, hsl(120,3%,13%) padding-box, linear-gradient(to bottom right, hsl(101,83%,45%) 0%, hsla(0,0%,25%,0) 50%) border-box; }
    .item-head { display:flex; gap:10px; align-items:center; min-width:0; }
    .item-thumb { width:56px; height:56px; flex-shrink:0; border-radius:6px; object-fit:cover; background:var(--bg); border:1px solid var(--line); }
    .item-title { font-weight:600; font-size:0.92rem; line-height:1.3; overflow:hidden; text-overflow:ellipsis; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }
    .item-meta { color:var(--muted); font-size:0.8rem; overflow-wrap:anywhere; }
    .item-body { color:var(--muted); font-size:0.85rem; line-height:1.4; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; margin:0; }
    .item-actions { margin-top:auto; display:flex; gap:6px; flex-wrap:wrap; align-items:center; padding-top:8px; border-top:1px solid var(--line); }
    .empty { color:var(--muted); padding:14px; }
    th { color:var(--muted); font-weight:600; }
    td img { width:70px; height:auto; border-radius:4px; }
    label { display:block; margin:12px 0 6px; color:var(--muted); font-size:0.9rem; }
    input[type=text], input[type=email], input[type=password], input[type=number], input[type=date], input[type=file], input[list], textarea, select {
      width:100%; background:var(--bg); color:var(--text); border:1px solid var(--line); border-radius:6px; padding:9px 10px; font-size:0.95rem; }
    input[type=date] { color-scheme:dark; }
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
    .btn, .btn.secondary, .btn.danger, .menu-btn, .sidebar nav a { transition: transform .15s ease, box-shadow .2s ease, background-color .2s ease, color .2s ease, border-color .2s ease; }
    .btn:hover, .btn:focus-visible { transform: translateY(-2px); box-shadow: 0 0 14px rgba(0,255,156,.35); }
    .btn.secondary:hover, .btn.secondary:focus-visible { box-shadow: 0 0 12px rgba(0,255,156,.25); border-color: var(--accent); color: var(--accent); }
    .btn.danger:hover, .btn.danger:focus-visible { box-shadow: 0 0 14px rgba(255,93,93,.45); }
    .btn:active, .menu-btn:active { transform: translateY(0) scale(.97); }
    .menu-btn:hover { border-color: var(--accent); color: var(--accent); }
    .sidebar nav a:hover { transform: translateX(3px); }
    .stat, .item { transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
    .stat:hover, .item:hover { transform: translateY(-3px); border-color: var(--accent); box-shadow: 0 8px 22px rgba(0,255,156,.18); }
    @keyframes rise { from { opacity:0; transform: translateY(10px); } to { opacity:1; transform: none; } }
    main > * { animation: rise .45s ease both; }
    main > *:nth-child(2) { animation-delay: .05s; }
    main > *:nth-child(3) { animation-delay: .1s; }
    main > *:nth-child(4) { animation-delay: .15s; }
    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after { animation: none !important; transition: none !important; }
    }
  </style>
</head>
<body>
  <canvas id="matrix"></canvas>
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
        <a class="{{ request()->routeIs('admin.details.*') ? 'active' : '' }}" href="{{ route('admin.details.edit') }}">Edit Details</a>
        <a class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}">Messages</a>
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
  <script>
    async function verifyAdminPassword(message) {
      if (!confirm(message)) return false;
      var password = prompt('Enter your admin password to confirm:');
      if (!password) return false;
      var response = await fetch('{{ route('admin.confirm-password') }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ admin_password: password }),
      });
      var data = await response.json();
      if (!data.ok) alert('Incorrect admin password. Nothing was removed.');
      return data.ok === true;
    }
    function askAdminPassword(form, message) {
      if (!confirm(message)) return false;
      var password = prompt('Enter your admin password to confirm:');
      if (!password) return false;
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'admin_password';
      input.value = password;
      form.appendChild(input);
      return true;
    }
  </script>
  <script>
    (function () {
      var body = document.body, mobile = window.matchMedia('(max-width: 800px)');
      var startX = 0, startY = 0, tracking = false;
      document.addEventListener('touchstart', function (e) {
        tracking = mobile.matches && e.touches.length === 1 && !e.target.closest('.table-wrap');
        if (tracking) { startX = e.touches[0].clientX; startY = e.touches[0].clientY; }
      }, { passive: true });
      document.addEventListener('touchend', function (e) {
        if (!tracking) return;
        tracking = false;
        var t = e.changedTouches[0], dx = t.clientX - startX, dy = t.clientY - startY;
        if (Math.abs(dx) < 60 || Math.abs(dy) > Math.abs(dx) * 0.6) return;
        if (dx > 0) body.classList.add('nav-open');
        else body.classList.remove('nav-open');
      }, { passive: true });
    })();
  </script>
  <script>
    (function () {
      var canvas = document.getElementById('matrix'), ctx = canvas.getContext('2d');
      var letters = 'Istiaq Alam ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', fontSize = 12, drops = [], hue = 120;
      function resize() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        for (var x = drops.length; x < canvas.width / fontSize; x++) drops[x] = 1;
      }
      resize();
      window.addEventListener('resize', resize);
      function draw() {
        ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = 'hsl(' + hue + ', 100%, 50%)';
        ctx.font = fontSize + 'px monospace';
        for (var i = 0; i < drops.length; i++) {
          ctx.fillText(letters.charAt(Math.floor(Math.random() * letters.length)), i * fontSize, drops[i] * fontSize);
          if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) drops[i] = 0;
          drops[i]++;
        }
        hue += 0.5;
        if (hue >= 360) hue = 0;
      }
      setInterval(draw, 33);
    })();
  </script>
</body>
</html>
