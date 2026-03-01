<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin - KOPEKA</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; background-color: #f4f7f6; }
        .grid-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 5px solid #2ecc71; }
        .card.hutang { border-left-color: #e74c3c; }
        .card.total { border-left-color: #3498db; }
        .card h3 { margin: 0; font-size: 14px; color: #7f8c8d; }
        .card p { margin: 10px 0 0; font-size: 18px; font-weight: bold; color: #2c3e50; }
        
        .menu-box { margin-top: 30px; padding: 20px; background: white; border-radius: 8px; width: fit-content; min-width: 300px; }
        .btn-logout { margin-top: 20px; background: #95a5a6; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Dashboard Ringkasan Koperasi</h1>
    
    <div class="grid-container">
        <div class="card">
            <h3>Total Anggota</h3>
            <p>{{ $totalAnggota }} Orang</p>
        </div>

        <div class="card">
            <h3>Total Pokok</h3>
            <p>Rp {{ number_format($totalPokok, 0, ',', '.') }}</p>
        </div>
        <div class="card">
            <h3>Total Wajib</h3>
            <p>Rp {{ number_format($totalWajib, 0, ',', '.') }}</p>
        </div>
        <div class="card">
            <h3>Total Sukarela</h3>
            <p>Rp {{ number_format($totalSukarela, 0, ',', '.') }}</p>
        </div>

        <div class="card total">
            <h3>Total Seluruh Simpanan</h3>
            <p>Rp {{ number_format($totalSimpananKeseluruhan, 0, ',', '.') }}</p>
        </div>

        <div class="card hutang">
            <h3>Total Seluruh Hutang (2025)</h3>
            <p>Rp {{ number_format($totalHutang, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="menu-box">
        <h3>Menu Navigasi</h3>
        <hr>
        <ul>
            <li><a href="{{ route('admin.anggota.index') }}">Kelola Data & Saldo Anggota</a></li>
            <li><a href="#">Laporan Bulanan</a></li>
        </ul>
        
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>

</body>
</html>