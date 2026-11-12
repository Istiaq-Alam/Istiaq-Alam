@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
  <style>
    .dash-stats { grid-template-columns:repeat(auto-fit,minmax(120px,1fr)); gap:10px; margin-bottom:12px; }
    .dash-stats .stat { padding:10px 12px; margin-bottom:0; animation:rise .5s ease backwards; animation-delay:calc(var(--i) * 70ms); }
    .dash-stats .stat strong { font-size:1.2rem; font-variant-numeric:tabular-nums; }
    .quick { padding:10px 12px; margin-bottom:0; animation:rise .5s ease .35s backwards; }
    .quick h2 { font-size:0.95rem; margin-bottom:8px; }
    .quick .actions { margin-top:0; gap:8px; }
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

  <script>
    (function () {
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
