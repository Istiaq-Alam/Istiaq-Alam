@extends('admin.layout')

@section('title', 'Research')

@section('content')
  <h1>Research Papers</h1>
  <div class="actions" style="margin-bottom:14px"><a class="btn" href="{{ route('admin.researches.create') }}">+ Add Research</a></div>
  <div class="card">
    <div class="table-wrap"><table>
      <thead>
        <tr><th>Thumbnail</th><th>Title</th><th>Category</th><th>Published</th><th></th></tr>
      </thead>
      <tbody>
        @forelse ($researches as $research)
          <tr>
            <td><img src="{{ $research->thumbnail_url }}" alt=""></td>
            <td>{{ $research->title }}</td>
            <td>{{ $research->category }}</td>
            <td>{{ $research->published_date }}</td>
            <td>
              <a class="btn secondary" href="{{ route('admin.researches.edit', $research) }}">Edit</a>
              <form method="POST" action="{{ route('admin.researches.destroy', $research) }}" class="inline" onsubmit="return confirm('Delete this research?')">
                @csrf @method('DELETE')
                <button class="btn danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5">No research papers yet.</td></tr>
        @endforelse
      </tbody>
    </table></div>
  </div>
@endsection
