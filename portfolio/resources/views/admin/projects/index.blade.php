@extends('admin.layout')

@section('title', 'Projects')

@section('content')
  <h1>Projects</h1>
  <div class="actions" style="margin-bottom:12px"><a class="btn" href="{{ route('admin.projects.create') }}">+ Add Project</a></div>
  <div class="item-list">
    @forelse ($projects as $project)
      <div class="item">
        <div class="item-head">
          <img class="item-thumb" src="{{ $project->thumbnail_url }}" alt="">
          <div style="min-width:0">
            <div class="item-title">{{ $project->title }}</div>
            <div class="item-meta">{{ $project->category }}{{ $project->sub_category ? ' · '.$project->sub_category : '' }}</div>
          </div>
        </div>
        <div class="item-meta">GitHub: {{ $project->is_github_featured ? 'Yes' : 'No' }}</div>
        <div class="item-actions">
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
