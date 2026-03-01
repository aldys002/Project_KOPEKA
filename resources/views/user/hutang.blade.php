<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pinjaman - KOPEKA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Rincian Pinjaman: {{ $user->users }}</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    Informasi: Pinjaman dikenakan bunga flat 1% per bulan.
                </div>
                
                <table class="table table-hover">
                    <tr>
                        <th>Saldo Pokok Pinjaman</th>
                        <td>Rp {{ number_format($saldoAwal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Lama Pinjaman Berjalan</th>
                        <td>{{ $selisihBulan }} Bulan</td>
                    </tr>
                    <tr>
                        <th>Total Akumulasi Bunga (1%)</th>
                        <td class="text-danger">+ Rp {{ number_format($bunga, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="table-danger fs-4">
                        <th>TOTAL KEWAJIBAN</th>
                        <th class="text-danger">Rp {{ number_format($totalHutangSekarang, 0, ',', '.') }}</th>
                    </tr>
                </table>
                
                <hr>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary btn-sm">Kembali ke Dashboard</a>
                    <span class="text-muted small">Update otomatis per: {{ date('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>