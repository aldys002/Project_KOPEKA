<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOPEKA - Rail Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { 
            --kai-blue: #003399; 
            --kai-orange: #ED6B23; 
            --kai-dark: #1a252f;
            --kai-gray: #f0f2f8; 
            --commuter-red: #d1121d;
        }
        
        body { 
            background-color: var(--kai-gray); 
            font-family: 'Inter', sans-serif; 
        }
        
        /* ===== NAVBAR (Updated to match Welcome Style) ===== */
        .navbar { 
            background-color: white !important; 
            border-bottom: 5px solid var(--kai-orange); 
            padding: 5px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .navbar-brand-kai { 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            text-decoration: none; 
        }
        .navbar-brand-kai img { 
            height: 80px; 
            width: auto; 
            margin-bottom: -25px; 
        }
        .navbar-brand-kai span { 
            font-size: 0.9rem; 
            font-weight: 800; 
            color: var(--commuter-red); 
            font-style: italic; 
            margin-left: 75px; 
        }

        /* ===== HERO SECTION ===== */
        .hero-section { 
            position: relative;
            border-radius: 20px; 
            padding: 50px 45px; 
            margin-bottom: 30px; 
            overflow: hidden;
            min-height: 220px;
            display: flex;
            align-items: center;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background: url("{{ asset('images/kereta.jpeg') }}") no-repeat center center;
            background-size: cover;
            z-index: 0;
        }

        .hero-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0, 30, 100, 0.92) 40%, rgba(0, 51, 153, 0.65));
        }

        .hero-content {
            position: relative;
            z-index: 1;
            color: white;
            width: 100%;
        }

        .hero-label {
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--kai-orange);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .hero-label::before {
            content: '';
            width: 30px;
            height: 2px;
            background: var(--kai-orange);
            display: inline-block;
        }

        .hero-name {
            font-size: 2.4rem;
            font-weight: 800;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .hero-nipp {
            font-size: 0.95rem;
            opacity: 0.75;
            font-style: italic;
        }

        .hero-deco {
            position: absolute;
            right: 40px;
            bottom: -10px;
            font-size: 9rem;
            opacity: 0.07;
            color: white;
            z-index: 1;
        }

        /* ===== CARDS ===== */
        .card-kai { 
            border: none; 
            border-radius: 16px; 
            background: white; 
            overflow: hidden; 
            box-shadow: 0 6px 25px rgba(0,0,0,0.07); 
            height: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card-kai:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
        }

        .card-header-kai { 
            background: linear-gradient(135deg, var(--kai-blue), #0044cc);
            color: white; 
            padding: 18px 25px; 
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header-dark {
            background: linear-gradient(135deg, #1a252f, #2d3e50);
        }

        .card-header-kai .icon-badge {
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-amount {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .btn-kai { 
            background: linear-gradient(135deg, var(--kai-orange), #d45a1a);
            color: white; 
            border-radius: 50px; 
            font-weight: 700; 
            border: none; 
            padding: 12px 30px; 
            transition: 0.3s; 
            text-decoration: none; 
            display: inline-block;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            box-shadow: 0 5px 15px rgba(237,107,35,0.35);
        }
        .btn-kai:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 10px 25px rgba(237,107,35,0.45);
            color: white;
        }

        /* ===== INFO STRIP ===== */
        .info-strip {
            background: white;
            border-radius: 14px;
            padding: 22px 28px;
            border-left: 5px solid var(--kai-orange);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        /* ===== LOGOUT BUTTON ===== */
        .btn-logout {
            border: 2px solid #dc3545;
            color: #dc3545;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 8px 22px;
            transition: 0.3s;
        }
        .btn-logout:hover {
            background: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-light sticky-top mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand-kai" href="#">
                <img src="{{ asset('images/logo-kai-.png') }}" alt="Logo KAI">
                <span>KOPEKA</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf 
                <button class="btn btn-logout">
                    <i class="fas fa-sign-out-alt me-1"></i> Keluar
                </button>
            </form>
        </div>
    </nav>

    <div class="container pb-5">

        <div class="hero-section shadow-lg mb-4">
            <div class="hero-bg"></div>
            <i class="fas fa-train hero-deco"></i>

            <div class="hero-content">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="hero-label">Layanan Keuangan Anggota</div>
                        <h2 class="hero-name">Halo, {{ $user->users }}</h2>
                        <p class="hero-nipp">
                            <i class="fas fa-id-badge me-2"></i>NIPP: {{ $user->nipp }} &nbsp;·&nbsp; "Melayani dengan Setulus Hati"
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card-kai">
                    <div class="card-header-kai">
                        <span>Total Simpanan</span>
                        <div class="icon-badge">
                            <i class="fas fa-vault"></i>
                        </div>
                    </div>
                    <div class="p-4 text-center">
                        <p class="text-muted small mb-1 mt-2">Saldo Tersimpan</p>
                        <div class="card-amount text-dark">
                            Rp {{ number_format($keuangan->total_simpanan ?? 0, 0, ',', '.') }}
                        </div>
                        <a href="{{ route('user.simpanan') }}" class="btn-kai w-100 text-center">
                            <i class="fas fa-eye me-2"></i>Lihat Detail Simpanan
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-kai">
                    <div class="card-header-kai card-header-dark">
                        <span>Saldo Pinjaman</span>
                        <div class="icon-badge">
                            <i class="fas fa-file-invoice-dollar text-warning"></i>
                        </div>
                    </div>
                    <div class="p-4 text-center">
                        <p class="text-muted small mb-1 mt-2">Total Hutang Aktif</p>
                        <div class="card-amount text-danger">
                            Rp {{ number_format($keuangan->saldo_hutang ?? 0, 0, ',', '.') }}
                        </div>
                        <div class="alert alert-light border small text-muted rounded-3 mb-0">
                            <i class="fas fa-info-circle me-1 text-primary"></i> 
                            Data pinjaman bersifat tetap berdasarkan laporan admin.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-strip d-flex align-items-center gap-3">
            <div style="width:48px; height:48px; background: rgba(0,51,153,0.08); border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fas fa-calendar-check fa-lg text-primary"></i>
            </div>
            <div>
                <h6 class="mb-1 fw-bold">Update Terakhir Data</h6>
                <p class="mb-0 text-muted small">Seluruh data keuangan di atas disinkronkan langsung dari data pusat Koperasi sesuai periode laporan terbaru.</p>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>