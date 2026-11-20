@extends('admin.layout')

@section('title', 'Change Password')

@section('content')
  <h1>Change Password</h1>
  <div class="card">
    <form method="POST" action="{{ route('admin.password.update') }}">
      @csrf
      @method('PUT')
      <label for="current_password">Current password</label>
      <input id="current_password" type="password" name="current_password" autocomplete="current-password" required>
      <label for="password">New password</label>
      <input id="password" type="password" name="password" autocomplete="new-password" required>
      <label for="password_confirmation">Confirm new password</label>
      <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
      <div class="actions">
        <button class="btn" type="submit">Update password</button>
      </div>
    </form>
  </div>
@endsection
