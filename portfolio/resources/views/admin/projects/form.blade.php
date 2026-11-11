@extends('admin.layout')

@section('title', $project->exists ? 'Edit Project' : 'New Project')

@section('content')
  <h1>{{ $project->exists ? 'Edit Project' : 'New Project' }}</h1>
  <div class="card">
    <form method="POST" enctype="multipart/form-data"
          action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}">
      @csrf
      @if ($project->exists) @method('PUT') @endif

      <label for="title">Title</label>
      <input id="title" type="text" name="title" value="{{ old('title', $project->title) }}" required>

      <div class="row">
        <div>
          <label for="category">Category</label>
          <input id="category" type="text" name="category" list="category-options" value="{{ old('category', $project->category) }}" required>
          <datalist id="category-options">
            @foreach ($categories as $option)
              <option value="{{ $option }}">
            @endforeach
          </datalist>
        </div>
        <div>
          <label for="sub_category">Sub category (optional)</label>
          <input id="sub_category" type="text" name="sub_category" value="{{ old('sub_category', $project->sub_category) }}">
        </div>
      </div>

      <label for="project_url">Project URL</label>
      <input id="project_url" type="text" name="project_url" value="{{ old('project_url', $project->project_url) }}">

      <label for="description">Description</label>
      <textarea id="description" name="description">{{ old('description', $project->description) }}</textarea>

      <div class="row">
        <div>
          <label for="thumbnail">Thumbnail (jpeg, png, webp, gif, svg; max 2MB)</label>
          <input id="thumbnail" type="file" name="thumbnail" accept="image/*" onchange="previewImage(this)">
          <img id="thumbnail-preview" class="preview" src="{{ $project->thumbnail_url }}" alt="" @if (! $project->thumbnail_url) hidden @endif>
        </div>
        <div>
          <label for="sort_order">Sort order</label>
          <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order) }}">
          <label style="display:flex;gap:8px;align-items:center">
            <input type="checkbox" name="is_github_featured" value="1" {{ old('is_github_featured', $project->is_github_featured) ? 'checked' : '' }}>
            Show in GitHub Projects section
          </label>
        </div>
      </div>

      <div class="actions">
        <button class="btn" type="submit">Save</button>
        <a class="btn secondary" href="{{ route('admin.projects.index') }}">Cancel</a>
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
