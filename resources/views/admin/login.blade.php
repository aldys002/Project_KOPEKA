<!DOCTYPE html>

<html>
<head>
<title>Login Admin</title>
<style>
body { font-family: sans-serif; background: #2c3e50; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
.box { background: white; padding: 40px; border-radius: 10px; width: 300px; }
input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; }
button { width: 100%; padding: 10px; background: orange; color: white; border: none; cursor: pointer; }
</style>
</head>
<body>
<div class="box">
<h2>Admin KOPEKA</h2>
@if($errors->has('error')) <p style="color:red">{{ $errors->first('error') }}</p> @endif
<form action="{{ route('admin.login.submit') }}" method="POST">
@csrf
<input type="text" name="nipp" placeholder="NIPP Admin" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit">MASUK</button>
</form>
</div>
</body>
</html>