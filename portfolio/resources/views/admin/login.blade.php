<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <style>
    body { margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center; background:#0f1115; color:#e6e8ee; font-family:system-ui,sans-serif; }
    form { background:#181b22; border:1px solid #2a2f3a; border-radius:10px; padding:28px; width:340px; }
    h1 { font-size:1.3rem; margin:0 0 14px; }
    label { display:block; margin:12px 0 6px; color:#9aa3b2; font-size:0.9rem; }
    input { width:100%; box-sizing:border-box; background:#0f1115; color:#e6e8ee; border:1px solid #2a2f3a; border-radius:6px; padding:9px 10px; }
    button { margin-top:18px; width:100%; background:#00d1b2; color:#06231e; border:0; padding:10px; border-radius:6px; font-weight:600; cursor:pointer; }
    .error { color:#ff5d5d; font-size:0.9rem; margin-top:10px; }
  </style>
</head>
<body>
  <form method="POST" action="{{ route('admin.login.submit') }}">
    @csrf
    <h1>Admin Login</h1>
    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    @error('email')<p class="error">{{ $message }}</p>@enderror
    <button type="submit">Log in</button>
  </form>
</body>
</html>
