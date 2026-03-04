<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOPEKA - Rail Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --kai-blue: #003399; --kai-orange: #ED6B23; --kai-gray: #E8E9ED; }
        body { background-color: var(--kai-gray); font-family: 'Segoe UI', Roboto, sans-serif; }
        
        /* Navbar KAI Style */
        .navbar { background-color: white !important; border-bottom: 5px solid var(--kai-orange); padding: 1rem; }
        .navbar-brand { color: var(--kai-blue) !important; font-weight: 800; font-size: 1.5rem; }

        /* Card Style */
        .card-kai { border: none; border-radius: 12px; background: white; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); height: 100%; }
        .card-header-kai { background-color: var(--kai-blue); color: white; padding: 15px; font-weight: 600; }
        
        /* Hero Section */
        .hero-section { background: linear-gradient(135deg, var(--kai-blue) 0%, #002266 100%); color: white; border-radius: 15px; padding: 40px; margin-bottom: 30px; position: relative; }
        .hero-section::after { content: ""; position: absolute; right: 20px; bottom: 0; width: 200px; height: 100px; background: url('https://www.kai.id/static/images/logo_kai.png') no-repeat center; background-size: contain; opacity: 0.1; }

        .btn-kai { background-color: var(--kai-orange); color: white; border-radius: 50px; font-weight: bold; border: none; padding: 10px 25px; transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-kai:hover { background-color: #d45a1a; color: white; transform: scale(1.05); }
        
        .placeholder-card { border: 2px dashed #ccc; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #999; height: 100%; min-height: 200px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-light shadow-sm mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="#"><i class="fas fa-train me-2"></i>KOPEKA <span style="color: var(--kai-orange)">RAIL</span></a>
            <form action="{{ route('logout') }}" method="POST">@csrf <button class="btn btn-outline-danger btn-sm rounded-pill fw-bold">Keluar</button></form>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="hero-section shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="text-uppercase" style="letter-spacing: 2px; color: var(--kai-orange)">Layanan Keuangan Anggota</h5>
                    <h2 class="display-6 fw-bold">Halo, {{ $user->users }}</h2>
                    <p class="lead opacity-75">NIPP: {{ $user->nipp }} | "Melayani dengan Setulus Hati"</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card-kai shadow-sm">
                    <div class="card-header-kai d-flex justify-content-between align-items-center">
                        <span>TOTAL SIMPANAN</span>
                        <i class="fas fa-vault"></i>
                    </div>
                    <div class="p-4 text-center">
                        <h1 class="fw-bold text-dark mb-4">Rp {{ number_format($keuangan->total_simpanan, 0, ',', '.') }}</h1>
                        <a href="{{ route('user.simpanan') }}" class="btn btn-kai w-100">LIHAT DETAIL SIMPANAN</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-kai shadow-sm">
                    <div class="card-header-kai d-flex justify-content-between align-items-center" style="background-color: #333;">
                        <span>SALDO PINJAMAN</span>
                        <i class="fas fa-file-invoice-dollar text-warning"></i>
                    </div>
                    <div class="p-4 text-center">
                        <h1 class="fw-bold text-danger mb-4">Rp {{ number_format($keuangan->saldo_hutang, 0, ',', '.') }}</h1>
                        <div class="alert alert-light border small text-muted">
                            <i class="fas fa-info-circle me-1"></i> Data pinjaman ini bersifat tetap berdasarkan laporan admin.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 p-4 bg-white rounded-3 shadow-sm border-start border-5 border-warning d-flex align-items-center">
            <i class="fas fa-calendar-check fa-2x text-primary me-3"></i>
            <div>
                <h6 class="mb-0 fw-bold">Update Terakhir Data</h6>
                <p class="mb-0 text-muted small">Seluruh data keuangan di atas disinkronkan langsung dari data pusat Koperasi sesuai periode laporan terbaru.</p>
            </div>
        </div>
    </div>
</body>
</html>