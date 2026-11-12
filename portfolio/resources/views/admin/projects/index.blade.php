@extends('admin.layout')

@section('title', 'Projects')

@section('content')
  <style>
    .project-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:30px; margin-top:12px; }
    .project-card { display:flex; flex-direction:column; min-width:0; background:transparent; }
    .project-card-img { position:relative; width:100%; height:200px; border-radius:16px; overflow:hidden; margin:0 0 15px; background:#000; }
    .project-card-img img { width:100%; height:100%; object-fit:cover; display:block; transition:transform .25s ease; }
    .project-card:hover .project-card-img img { transform:scale(1.1); }
    .project-card-title { margin:0 0 4px 10px; color:hsl(177,100%,50%); font-size:15px; font-weight:400; line-height:1.3; text-transform:capitalize; overflow-wrap:anywhere; }
    .project-card-category { margin:0 0 0 10px; color:hsla(128,100%,50%,0.658); font-size:14px; font-weight:300; overflow-wrap:anywhere; }
    .project-card-meta { margin:6px 0 0 10px; color:var(--muted); font-size:0.8rem; }
    .project-card-actions { margin:auto 0 0 10px; padding-top:10px; display:flex; gap:6px; flex-wrap:wrap; align-items:center; }
  </style>

  <h1>Projects</h1>
  <div class="actions" style="margin-bottom:12px"><a class="btn" href="{{ route('admin.projects.create') }}">+ Add Project</a></div>
  <div class="project-grid">
    @forelse ($projects as $project)
      <div class="project-card">
        <figure class="project-card-img">
          <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" loading="lazy">
        </figure>
        <h3 class="project-card-title">{{ $project->title }}</h3>
        <p class="project-card-category">{{ $project->sub_category ?? $project->category }}</p>
        <p class="project-card-meta">GitHub: {{ $project->is_github_featured ? 'Yes' : 'No' }}</p>
        <div class="project-card-actions">
          <a class="btn secondary" href="{{ route('admin.projects.edit', $project) }}">Edit</a>
          <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="inline" onsubmit="return askAdminPassword(this, 'Delete this project?')">
            @csrf @method('DELETE')
            <button class="btn danger" type="submit">Delete</button>
          </form>
        </div>
      </div>
    @empty
      <div class="card empty">No projects yet.</div>
    @endforelse
  </div>
@endsection
