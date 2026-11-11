@extends('admin.layout')

@section('title', $research->exists ? 'Edit Research' : 'New Research')

@section('content')
  <h1>{{ $research->exists ? 'Edit Research' : 'New Research' }}</h1>
  <div class="card">
    <form method="POST" enctype="multipart/form-data"
          action="{{ $research->exists ? route('admin.researches.update', $research) : route('admin.researches.store') }}">
      @csrf
      @if ($research->exists) @method('PUT') @endif

      <label for="title">Title</label>
      <input id="title" type="text" name="title" value="{{ old('title', $research->title) }}" required>

      <div class="row">
        <div>
          <label for="category">Category</label>
          <input id="category" type="text" name="category" value="{{ old('category', $research->category) }}" required>
        </div>
        <div>
          <label for="published_date">Published date</label>
          <input id="published_date" type="date" name="published_date" value="{{ old('published_date', $publishedDate) }}" required>
        </div>
      </div>

      <label for="research_url">URL</label>
      <input id="research_url" type="text" name="research_url" value="{{ old('research_url', $research->research_url) }}">

      <label for="description">Description</label>
      <textarea id="description" name="description" required>{{ old('description', $research->description) }}</textarea>

      <div class="row">
        <div>
          <label for="thumbnail">Thumbnail (jpeg, png, webp, gif, svg; max 2MB)</label>
          <input id="thumbnail" type="file" name="thumbnail" accept="image/*" onchange="previewImage(this)">
          <img id="thumbnail-preview" class="preview" src="{{ $research->thumbnail_url }}" alt="" @if (! $research->thumbnail_url) hidden @endif>
        </div>
        <div>
          <label for="sort_order">Sort order</label>
          <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $research->sort_order) }}">
        </div>
      </div>

      <label for="pdf">Research PDF (max 2MB)</label>
      <input id="pdf" type="file" name="pdf" accept="application/pdf">
      @if ($research->pdf)
        <p class="item-meta"><a href="{{ route('research.pdf', $research) }}" target="_blank">View current PDF</a></p>
      @endif

      <div class="actions">
        <button class="btn" type="submit">Save</button>
        <a class="btn secondary" href="{{ route('admin.researches.index') }}">Cancel</a>
      </div>
    </form>
  </div>

  <script>
    function previewImage(input) {
      const img = document.getElementById('thumbnail-preview');
      if (input.files && input.files[0]) {
        img.src = URL.createObjectURL(input.files[0]);
        img.hidden = false;
      }
    }
  </script>
@endsection
