<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Simpanan - KOPEKA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Rincian Simpanan: {{ $user->users }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th class="bg-light">Simpanan Pokok</th>
                        <td>Rp {{ number_format($simpanan->pokok ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Simpanan Wajib</th>
                        <td>Rp {{ number_format($simpanan->wajib ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Simpanan Sukarela</th>
                        <td>Rp {{ number_format($simpanan->sukarela ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="table-success">
                        <th>TOTAL SALDO</th>
                        <th>Rp {{ number_format($simpanan->total_simpanan ?? 0, 0, ',', '.') }}</th>
                    </tr>
                </table>
                <a href="{{ route('user.dashboard') }}" class="btn btn-secondary btn-sm">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>