<!DOCTYPE html>

<html>
<body>
<h1>Selamat Datang Admin!</h1>
<form action="{{ route('admin.logout') }}" method="POST">
@csrf
<button type="submit">Logout</button>
</form>
</body>
</html>