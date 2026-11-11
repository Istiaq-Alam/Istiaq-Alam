@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
  <h1>Dashboard</h1>
  <div class="stats" style="grid-template-columns:repeat(auto-fit,minmax(130px,1fr))">
    <div class="card stat"><strong>{{ $projectCount }}</strong>Projects</div>
    <div class="card stat"><strong>{{ $researchCount }}</strong>Research Papers</div>
    <div class="card stat"><strong>{{ $skillCount }}</strong>Skills</div>
    <div class="card stat"><strong>{{ $certificateCount }}</strong>Certificates</div>
    <div class="card stat"><strong>{{ $unreadCount }}</strong>Unread Messages</div>
  </div>

  <div class="card">
    <h2>Quick actions</h2>
    <div class="actions" style="margin-top:0">
      <a class="btn" href="{{ route('admin.projects.create') }}">+ Add Project</a>
      <a class="btn" href="{{ route('admin.researches.create') }}">+ Add Research</a>
      <a class="btn secondary" href="{{ route('admin.messages.index') }}">View Messages</a>
    </div>
  </div>
@endsection
