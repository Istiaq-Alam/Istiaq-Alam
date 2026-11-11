@extends('admin.layout')

@section('title', 'Certificates')

@section('content')
  <h1>Certificates</h1>
  <div class="actions" style="margin-bottom:12px"><a class="btn" href="{{ route('admin.certificates.create') }}">+ Add Certificate</a></div>
  <div class="item-list">
    @forelse ($certificates as $certificate)
      <div class="item">
        <div class="item-head">
          <img class="item-thumb" src="{{ $certificate->image_url }}" alt="">
          <div style="min-width:0">
            <div class="item-title">{{ $certificate->title }}</div>
          </div>
        </div>
        <div class="item-meta">{{ $certificate->credential_url }}</div>
        <div class="item-actions">
          <a class="btn secondary" href="{{ route('admin.certificates.edit', $certificate) }}">Edit</a>
          <form method="POST" action="{{ route('admin.certificates.destroy', $certificate) }}" class="inline" onsubmit="return confirm('Delete this certificate?')">
            @csrf @method('DELETE')
            <button class="btn danger" type="submit">Delete</button>
          </form>
        </div>
      </div>
    @empty
      <div class="card empty">No certificates yet.</div>
    @endforelse
  </div>
@endsection
