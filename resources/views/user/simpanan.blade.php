<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Simpanan - KOPEKA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --kai-blue: #003399; --kai-orange: #ED6B23; }
        body { background-color: #f8f9fa; font-family: sans-serif; }
        .card { border: none; border-radius: 12px; }
        .bg-kai { background-color: var(--kai-blue); color: white; }
        .text-kai-orange { color: var(--kai-orange); }
        .list-group-item { border: none; padding: 1.2rem; border-bottom: 1px solid #eee; }
        .total-box { background-color: #e9ecef; border-radius: 10px; padding: 20px; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark">Rincian Simpanan</h3>
                    <p class="text-muted">{{ $user->users }} ({{ $user->nipp ?? $user->nik }})</p>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-kai py-3">
                        <i class="fas fa-wallet me-2"></i> Saldo Aktif
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Simpanan Pokok</span>
                                <span class="fw-bold">Rp {{ number_format($simpanan->pokok ?? 0, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Simpanan Wajib</span>
                                <span class="fw-bold">Rp {{ number_format($simpanan->wajib ?? 0, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Simpanan Sukarela</span>
                                <span class="fw-bold text-success">Rp {{ number_format($simpanan->sukarela ?? 0, 0, ',', '.') }}</span>
                            </li>
                        </ul>
                        
                        <div class="p-4">
                            <div class="total-box text-center">
                                <small class="text-uppercase fw-bold text-muted">Total Simpanan</small>
                                <h2 class="fw-bold text-kai-orange mt-1">
                                    Rp {{ number_format($simpanan->total_simpanan ?? 0, 0, ',', '.') }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary rounded-pill px-4">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>