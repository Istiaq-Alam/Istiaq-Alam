@extends('admin.layout')

@section('title', 'Projects')

@section('content')
  <h1>Projects</h1>
  <div class="actions" style="margin-bottom:14px"><a class="btn" href="{{ route('admin.projects.create') }}">+ Add Project</a></div>
  <div class="card">
    <div class="table-wrap"><table>
      <thead>
        <tr><th>Thumbnail</th><th>Title</th><th>Category</th><th>GitHub</th><th></th></tr>
      </thead>
      <tbody>
        @forelse ($projects as $project)
          <tr>
            <td><img src="{{ $project->thumbnail_url }}" alt=""></td>
            <td>{{ $project->title }}</td>
            <td>{{ $project->category }}{{ $project->sub_category ? ' · '.$project->sub_category : '' }}</td>
            <td>{{ $project->is_github_featured ? 'Yes' : 'No' }}</td>
            <td>
              <a class="btn secondary" href="{{ route('admin.projects.edit', $project) }}">Edit</a>
              <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="inline" onsubmit="return confirm('Delete this project?')">
                @csrf @method('DELETE')
                <button class="btn danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5">No projects yet.</td></tr>
        @endforelse
      </tbody>
    </table></div>
  </div>
@endsection
