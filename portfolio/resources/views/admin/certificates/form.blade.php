@extends('admin.layout')

@section('title', $certificate->exists ? 'Edit Certificate' : 'New Certificate')

@section('content')
  <h1>{{ $certificate->exists ? 'Edit Certificate' : 'New Certificate' }}</h1>
  <div class="card">
    <form method="POST" enctype="multipart/form-data"
          action="{{ $certificate->exists ? route('admin.certificates.update', $certificate) : route('admin.certificates.store') }}">
      @csrf
      @if ($certificate->exists) @method('PUT') @endif

      <label for="title">Title</label>
      <input id="title" type="text" name="title" value="{{ old('title', $certificate->title) }}" required>

      <label for="credential_url">Credential URL (optional)</label>
      <input id="credential_url" type="text" name="credential_url" value="{{ old('credential_url', $certificate->credential_url) }}">

      <div class="row">
        <div>
          <label for="image">Image (jpeg, png, webp, gif, svg; max 2MB){{ $certificate->exists ? ' — leave empty to keep current' : '' }}</label>
          <input id="image" type="file" name="image" accept="image/*" onchange="previewImage(this)" {{ $certificate->exists ? '' : 'required' }}>
          <img id="image-preview" class="preview" src="{{ $certificate->image_url }}" alt="" @if (! $certificate->image_url) hidden @endif>
        </div>
        <div>
          <label for="sort_order">Sort order</label>
          <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $certificate->sort_order) }}">
        </div>
      </div>

      <div class="actions">
        <button class="btn" type="submit">Save</button>
        <a class="btn secondary" href="{{ route('admin.certificates.index') }}">Cancel</a>
      </div>
    </form>
  </div>

  <script>
    function previewImage(input) {
      const img = document.getElementById('image-preview');
      if (input.files && input.files[0]) {
        img.src = URL.createObjectURL(input.files[0]);
        img.hidden = false;
      }
    }
  </script>
@endsection
