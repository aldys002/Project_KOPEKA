<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard KOPEKA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container d-flex justify-content-between">
            <span class="navbar-brand">KOPEKA - Dashboard</span>
            <form action="{{ route('logout') }}" method="POST">@csrf <button class="btn btn-danger btn-sm">Logout</button></form>
        </div>
    </nav>

    <div class="container">
        <div class="alert alert-info shadow-sm">
            Halo, <strong>{{ $user->nama_anggota }}</strong> (NIPP: {{ $user->nipp }})
        </div>

        <div class="row text-center">
            <div class="col-md-6 mb-3">
                <div class="card p-4 shadow-sm border-0">
                    <h6>TOTAL SIMPANAN</h6>
                    <h2 class="text-success">Rp {{ number_format($keuangan->simp_pokok + $keuangan->simp_wajib + $keuangan->simp_sukarela, 0, ',', '.') }}</h2>
                    <a href="{{ route('user.simpanan') }}" class="btn btn-outline-success btn-sm mt-2">Lihat Detail Simpanan</a>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card p-4 shadow-sm border-0">
                    <h6>SALDO HUTANG</h6>
                    <h2 class="text-danger">Rp {{ number_format($keuangan->saldo_hutang, 0, ',', '.') }}</h2>
                    <a href="{{ route('user.hutang') }}" class="btn btn-outline-danger btn-sm mt-2">Lihat Detail Pinjaman</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>