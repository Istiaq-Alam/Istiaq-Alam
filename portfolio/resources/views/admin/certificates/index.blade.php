@extends('admin.layout')

@section('title', 'Certificates')

@section('content')
  <h1>Certificates</h1>
  <div class="actions" style="margin-bottom:14px"><a class="btn" href="{{ route('admin.certificates.create') }}">+ Add Certificate</a></div>
  <div class="card">
    <div class="table-wrap"><table>
      <thead>
        <tr><th>Image</th><th>Title</th><th>Credential URL</th><th></th></tr>
      </thead>
      <tbody>
        @forelse ($certificates as $certificate)
          <tr>
            <td><img src="{{ $certificate->image_url }}" alt=""></td>
            <td>{{ $certificate->title }}</td>
            <td>{{ $certificate->credential_url }}</td>
            <td>
              <a class="btn secondary" href="{{ route('admin.certificates.edit', $certificate) }}">Edit</a>
              <form method="POST" action="{{ route('admin.certificates.destroy', $certificate) }}" class="inline" onsubmit="return confirm('Delete this certificate?')">
                @csrf @method('DELETE')
                <button class="btn danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4">No certificates yet.</td></tr>
        @endforelse
      </tbody>
    </table></div>
  </div>
@endsection
