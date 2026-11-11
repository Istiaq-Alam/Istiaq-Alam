@extends('admin.layout')

@section('title', $skill->exists ? 'Edit Skill' : 'New Skill')

@section('content')
  <h1>{{ $skill->exists ? 'Edit Skill' : 'New Skill' }}</h1>
  <div class="card">
    <form method="POST" action="{{ $skill->exists ? route('admin.skills.update', $skill) : route('admin.skills.store') }}">
      @csrf
      @if ($skill->exists) @method('PUT') @endif

      <label for="name">Name</label>
      <input id="name" type="text" name="name" value="{{ old('name', $skill->name) }}" required>

      <label for="percentage">Percentage: <output id="percentage-value">{{ old('percentage', $skill->percentage ?? 0) }}</output>%</label>
      <input id="percentage" type="range" name="percentage" min="0" max="100" value="{{ old('percentage', $skill->percentage ?? 0) }}"
             oninput="document.getElementById('percentage-value').value = this.value">

      <label for="sort_order">Sort order</label>
      <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $skill->sort_order) }}">

      <div class="actions">
        <button class="btn" type="submit">Save</button>
        <a class="btn secondary" href="{{ route('admin.skills.index') }}">Cancel</a>
      </div>
    </form>
  </div>
@endsection
