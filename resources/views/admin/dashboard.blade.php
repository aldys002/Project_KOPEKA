<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <style>
        .menu-box {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            width: 300px;
        }
        .stat-card {
            background-color: #f0f0f0;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Selamat Datang Admin!</h1>
    
    <div class="stat-card">
        <p>Total Anggota Saat Ini: <strong>{{ $totalAnggota }}</strong></p>
    </div>

    <div class="menu-box">
        <h3>Menu Navigasi</h3>
        <ul>
            <li>
                <a href="{{ route('admin.anggota.index') }}">Daftar & Kelola Anggota</a>
            </li>
            <li><a href="#">Input Simpanan (Coming Soon)</a></li>
            <li><a href="#">Input Hutang (Coming Soon)</a></li>
        </ul>
    </div>

    <hr>

    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>