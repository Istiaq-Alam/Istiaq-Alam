@extends('admin.layout')

@section('title', 'Skills')

@section('content')
  <h1>Skills</h1>
  <div class="actions" style="margin-bottom:14px"><a class="btn" href="{{ route('admin.skills.create') }}">+ Add Skill</a></div>
  <div class="card">
    <div class="table-wrap"><table>
      <thead>
        <tr><th>Name</th><th>Percentage</th><th></th></tr>
      </thead>
      <tbody>
        @forelse ($skills as $skill)
          <tr>
            <td>{{ $skill->name }}</td>
            <td>{{ $skill->percentage }}%</td>
            <td>
              <a class="btn secondary" href="{{ route('admin.skills.edit', $skill) }}">Edit</a>
              <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" class="inline" onsubmit="return confirm('Delete this skill?')">
                @csrf @method('DELETE')
                <button class="btn danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="3">No skills yet.</td></tr>
        @endforelse
      </tbody>
    </table></div>
  </div>
@endsection
