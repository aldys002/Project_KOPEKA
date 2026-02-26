<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Kopeka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <span class="navbar-brand">Halo, {{ $user->name }} ({{ $user->nipp }})</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger btn-sm">Keluar</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h5 class="text-muted">Total Simpanan</h5>
                        <h2 class="text-primary">Rp {{ number_format($user->simpanan->total ?? 0, 0, ',', '.') }}</h2>
                        <hr>
                        <p class="mb-1">Pokok: Rp {{ number_format($user->simpanan->pokok ?? 0) }}</p>
                        <p class="mb-1">Wajib: Rp {{ number_format($user->simpanan->wajib ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h5 class="text-muted">Sisa Hutang (RAT 2025)</h5>
                        <h2 class="text-danger">Rp {{ number_format($user->hutang->saldo_hutang_2025 ?? 0, 0, ',', '.') }}</h2>
                        <p class="mt-3 text-secondary small">*Data sesuai laporan tahunan terakhir</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>