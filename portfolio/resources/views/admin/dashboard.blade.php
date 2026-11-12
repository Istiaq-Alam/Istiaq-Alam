@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
  <style>
    .dash-stats { grid-template-columns:repeat(auto-fit,minmax(120px,1fr)); gap:10px; margin-bottom:12px; }
    .dash-stats .stat, .quick {
      border:1px solid transparent; border-radius:14px; box-shadow:0 16px 30px hsla(192,79%,49%,.25);
      background:
        linear-gradient(to bottom right, hsla(128,95%,50%,.251) 0%, hsla(0,0%,99%,0) 100%) padding-box,
        hsl(120,3%,13%) padding-box,
        linear-gradient(to bottom right, hsl(101,83%,45%) 0%, hsla(0,0%,25%,0) 50%) border-box;
    }
    .dash-stats .stat { padding:10px 12px; margin-bottom:0; animation:rise .5s ease backwards; animation-delay:calc(var(--i) * 70ms); }
    .dash-stats .stat strong { font-size:1.2rem; font-variant-numeric:tabular-nums; }
    .quick { padding:10px 12px; margin-bottom:0; animation:rise .5s ease .35s backwards; }
    .quick h2 { font-size:0.95rem; margin-bottom:8px; }
    .quick .actions { margin-top:0; gap:8px; }
    .site-preview { display:block; width:100%; box-sizing:border-box; max-width:none; margin-top:12px; padding:0; overflow:hidden; }
    .site-preview canvas { display:block; width:100%; height:340px; }
  </style>
  <h1>Dashboard</h1>
  <div class="stats dash-stats">
    <div class="card stat" style="--i:0"><strong data-count="{{ $projectCount }}">{{ $projectCount }}</strong>Projects</div>
    <div class="card stat" style="--i:1"><strong data-count="{{ $researchCount }}">{{ $researchCount }}</strong>Research Papers</div>
    <div class="card stat" style="--i:2"><strong data-count="{{ $skillCount }}">{{ $skillCount }}</strong>Skills</div>
    <div class="card stat" style="--i:3"><strong data-count="{{ $certificateCount }}">{{ $certificateCount }}</strong>Certificates</div>
    <div class="card stat" style="--i:4"><strong data-count="{{ $unreadCount }}">{{ $unreadCount }}</strong>Unread Messages</div>
  </div>

  <div class="card quick">
    <h2>Quick actions</h2>
    <div class="actions">
      <a class="btn" href="{{ route('admin.projects.create') }}">+ Add Project</a>
      <a class="btn" href="{{ route('admin.researches.create') }}">+ Add Research</a>
      <a class="btn secondary" href="{{ route('admin.messages.index') }}">View Messages</a>
    </div>
  </div>

  <div class="card site-preview">
    <canvas id="site-preview" aria-label="Preview of the main portfolio page layout"></canvas>
  </div>

  <script>
    (function () {
      var canvas = document.getElementById('site-preview');
      if (canvas) {
        var ctx = canvas.getContext('2d');
        var ratio = window.devicePixelRatio || 1;
        var W = canvas.clientWidth, H = canvas.clientHeight;
        canvas.width = W * ratio; canvas.height = H * ratio;
        ctx.scale(ratio, ratio);
        function panel(x, y, w, h) {
          ctx.beginPath();
          ctx.roundRect(x, y, w, h, 20);
          ctx.fillStyle = '#000';
          ctx.fill();
          ctx.strokeStyle = 'hsl(0,0%,22%)';
          ctx.lineWidth = 1;
          ctx.stroke();
        }
        function bar(x, y, w, h, color) {
          ctx.beginPath();
          ctx.roundRect(x, y, w, h, 6);
          ctx.fillStyle = color;
          ctx.fill();
        }
        var pad = 16, sbW = Math.min(260, W * 0.3), sbH = H - pad * 2;
        // Sidebar panel (avatar, name, title)
        panel(pad, pad, sbW, sbH);
        ctx.beginPath();
        ctx.arc(pad + 15 + 40, pad + 15 + 40, 40, 0, Math.PI * 2);
        ctx.fillStyle = 'hsl(107,20%,40%)';
        ctx.fill();
        bar(pad + 15, pad + 105, sbW - 30, 14, 'hsl(0,0%,95%)');
        bar(pad + 15, pad + 129, sbW * 0.6, 10, 'hsl(240,1%,17%)');
        // Main-content: navbar pill row and article panel
        var mx = pad + sbW + 16, mw = W - mx - pad;
        var navH = 40;
        for (var i = 0; i < 5; i++) {
          var bw = (mw - 4 * 8) / 5;
          panel(mx + i * (bw + 8), pad, bw, navH);
        }
        var artY = pad + navH + 16, artH = H - artY - pad;
        panel(mx, artY, mw, artH);
        bar(mx + 15, artY + 15, mw * 0.3, 14, 'hsl(101,83%,45%)');
        ctx.fillStyle = 'hsl(0,0%,22%)';
        ctx.fillRect(mx + 15, artY + 42, mw - 30, 1);
        // Gradient-border tiles like the public cards
        var tY = artY + 56, tW = (mw - 30 - 2 * 12) / 3, tH = Math.min(90, artH - 80);
        for (var j = 0; j < 3; j++) {
          var tx = mx + 15 + j * (tW + 12);
          ctx.beginPath();
          ctx.roundRect(tx, tY, tW, tH, 14);
          ctx.fillStyle = 'hsl(120,3%,13%)';
          ctx.fill();
          ctx.strokeStyle = 'hsl(101,83%,45%)';
          ctx.stroke();
        }
      }

      if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
      document.querySelectorAll('[data-count]').forEach(function (el) {
        var end = parseInt(el.dataset.count, 10) || 0;
        if (end === 0) return;
        var start = null, dur = 800;
        el.textContent = '0';
        function step(ts) {
          if (start === null) start = ts;
          var p = Math.min((ts - start) / dur, 1);
          el.textContent = Math.round(end * (1 - Math.pow(1 - p, 3)));
          if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
      });
    })();
  </script>
@endsection
