@extends('admin.layout')

@section('title', 'Research')

@section('content')
  <h1>Research Papers</h1>
  <div class="actions" style="margin-bottom:12px"><a class="btn" href="{{ route('admin.researches.create') }}">+ Add Research</a></div>
  <div class="item-list">
    @forelse ($researches as $research)
      <div class="item">
        <div class="item-head">
          <img class="item-thumb" src="{{ $research->thumbnail_url }}" alt="">
          <div style="min-width:0">
            <div class="item-title">{{ $research->title }}</div>
            <div class="item-meta">{{ $research->category }}</div>
          </div>
        </div>
        <div class="item-meta">Published: {{ $research->published_date }}</div>
        <div class="item-actions">
          <a class="btn secondary" href="{{ route('admin.researches.edit', $research) }}">Edit</a>
          <form method="POST" action="{{ route('admin.researches.destroy', $research) }}" class="inline" onsubmit="return confirm('Delete this research?')">
            @csrf @method('DELETE')
            <button class="btn danger" type="submit">Delete</button>
          </form>
        </div>
      </div>
    @empty
      <div class="card empty">No research papers yet.</div>
    @endforelse
  </div>
@endsection
