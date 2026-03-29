<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOPEKA - Rail Dashboard</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root { 
            --blue: #002b80;
            --blue-dark: #001540;
            --blue-mid: #0a3299;
            --orange: #f26419;
            --orange-light: rgba(242, 100, 25, 0.12);
            --orange-glow: rgba(242, 100, 25, 0.35);
            --commuter-red: #c8101a;
            --surface: #f4f5fb;
            --card-bg: #ffffff;
            --text-muted: #7a82a0;
            --border: rgba(0, 43, 128, 0.07);
            --transition: all 0.45s cubic-bezier(0.22, 1, 0.36, 1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body { 
            background-color: var(--surface);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--blue-dark);
            min-height: 100vh;
        }

        /* ===== BACKGROUND TEXTURE ===== */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 10% -10%, rgba(0, 43, 128, 0.05) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 90% 110%, rgba(242, 100, 25, 0.04) 0%, transparent 55%);
            pointer-events: none;
            z-index: 0;
        }

        /* ===== NAVBAR ===== */
        .navbar { 
            background: rgba(255, 255, 255, 0.97) !important; 
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 14px 0;
            box-shadow: 0 1px 0 var(--border), 0 8px 32px rgba(0,0,0,0.04);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand-kai { 
            display: flex; 
            align-items: center; 
            gap: 14px;
            text-decoration: none;
        }
        
        .navbar-brand-kai img { height: 36px; width: auto; }

        .brand-divider {
            width: 1px;
            height: 32px;
            background: linear-gradient(to bottom, transparent, #dde1ee, transparent);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .brand-text .main-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--blue);
            line-height: 1;
            letter-spacing: 2px;
        }

        .brand-text .sub-title {
            font-size: 0.58rem;
            font-weight: 500;
            color: var(--commuter-red);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .nav-time {
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--text-muted);
            letter-spacing: 0.5px;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1.5px solid var(--border);
            color: var(--blue-dark);
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.78rem;
            padding: 8px 18px;
            transition: var(--transition);
            background: transparent;
            letter-spacing: 0.3px;
            cursor: pointer;
        }

        .btn-logout:hover {
            border-color: var(--commuter-red);
            color: var(--commuter-red);
            background: rgba(200, 16, 26, 0.04);
        }

        .btn-logout i { font-size: 0.7rem; }

        /* ===== MAIN WRAPPER ===== */
        .page-wrapper {
            position: relative;
            z-index: 1;
        }

        /* ===== HERO ===== */
        .hero-dashboard { 
            position: relative;
            border-radius: 28px; 
            padding: 0;
            margin-top: 32px;
            margin-bottom: 32px; 
            overflow: hidden;
            background: var(--blue-dark);
            box-shadow: 0 24px 60px rgba(0, 21, 64, 0.22), 0 1px 0 rgba(255,255,255,0.08) inset;
        }

        .hero-bg-photo {
            position: absolute;
            inset: 0;
            background: url("https://images.unsplash.com/photo-1532105956626-9569c03602f6?q=80&w=2000") center/cover;
            opacity: 0.18;
        }

        .hero-bg-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .hero-bg-glow {
            position: absolute;
            top: -60px;
            right: -60px;
            width: 360px;
            height: 360px;
            background: radial-gradient(circle, rgba(242, 100, 25, 0.2) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-body {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: stretch;
        }

        .hero-accent-bar {
            width: 5px;
            background: linear-gradient(to bottom, var(--orange), #ff9d5c);
            border-radius: 28px 0 0 28px;
            flex-shrink: 0;
        }

        .hero-content {
            color: white;
            padding: 44px 44px 44px 40px;
            flex: 1;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 14px;
            background: rgba(242, 100, 25, 0.15);
            border: 1px solid rgba(242, 100, 25, 0.4);
            color: #ffb07a;
            border-radius: 50px;
            font-size: 0.68rem;
            font-weight: 600;
            margin-bottom: 18px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .hero-tag::before {
            content: '';
            width: 6px;
            height: 6px;
            background: var(--orange);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.7); }
        }

        .hero-name {
            font-size: 2.6rem;
            font-weight: 800;
            letter-spacing: -1.5px;
            line-height: 1.05;
            margin-bottom: 16px;
        }

        .hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .hero-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem;
            color: rgba(255,255,255,0.6);
            font-weight: 400;
        }

        .hero-meta-item .badge-val {
            color: rgba(255,255,255,0.9);
            font-weight: 600;
        }

        .hero-meta-dot {
            width: 4px;
            height: 4px;
            background: rgba(255,255,255,0.25);
            border-radius: 50%;
        }

        .hero-stat-row {
            display: flex;
            gap: 32px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .hero-stat { }
        .hero-stat-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255,255,255,0.4);
            font-weight: 600;
            margin-bottom: 3px;
        }
        .hero-stat-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
        }
        .hero-stat-value.orange { color: #ff9d5c; }

        /* ===== SECTION LABEL ===== */
        .section-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
            margin-bottom: 16px;
        }

        /* ===== CARDS ===== */
        .card-rail { 
            border: 1px solid var(--border);
            border-radius: 24px; 
            background: var(--card-bg);
            padding: 32px 30px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.03);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .card-rail::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(135deg, rgba(0,43,128,0.03) 0%, transparent 60%);
            pointer-events: none;
        }

        .card-rail:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 48px rgba(0,43,128,0.09);
            border-color: rgba(0,43,128,0.12);
        }

        .card-header-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .card-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            display: block;
        }

        .icon-box {
            width: 44px;
            height: 44px;
            background: rgba(0, 43, 128, 0.06);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: var(--blue);
            flex-shrink: 0;
        }

        .icon-box.red {
            color: var(--commuter-red);
            background: rgba(200, 16, 26, 0.06);
        }

        .card-value {
            font-size: 2.1rem;
            font-weight: 800;
            color: var(--blue-dark);
            letter-spacing: -1px;
            line-height: 1;
            margin-bottom: 6px;
        }

        .card-value .currency {
            font-size: 1rem;
            font-weight: 600;
            vertical-align: super;
            letter-spacing: 0;
            margin-right: 3px;
        }

        .card-value.negative { color: var(--commuter-red); }

        .card-sublabel {
            font-size: 0.73rem;
            color: var(--text-muted);
            font-weight: 400;
            margin-bottom: 24px;
        }

        .btn-action { 
            background: var(--blue);
            color: white; 
            border-radius: 12px; 
            font-weight: 600; 
            border: none; 
            padding: 12px 20px; 
            transition: var(--transition); 
            text-decoration: none; 
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.82rem;
            letter-spacing: 0.3px;
        }

        .btn-action:hover { 
            background: var(--blue-mid);
            color: white;
            box-shadow: 0 10px 24px rgba(0,43,128,0.25);
        }

        .btn-action i { font-size: 0.75rem; }

        .info-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--surface);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.75rem;
            color: var(--text-muted);
            border: 1px solid var(--border);
        }

        .info-pill i {
            color: var(--blue);
            font-size: 0.8rem;
        }

        /* ===== CARD DECORATIVE LINES ===== */
        .card-rail .deco-line {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--blue) 0%, transparent 100%);
            border-radius: 0 0 24px 24px;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .card-rail.red-accent .deco-line {
            background: linear-gradient(90deg, var(--commuter-red) 0%, transparent 100%);
        }

        .card-rail:hover .deco-line {
            opacity: 1;
        }

        /* ===== SYNC STRIP ===== */
        .sync-strip {
            background: white;
            border-radius: 16px;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            margin-top: 32px;
        }

        .sync-dot {
            width: 10px;
            height: 10px;
            background: #22c55e;
            border-radius: 50%;
            flex-shrink: 0;
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.15);
            animation: syncPulse 2.5s infinite;
        }

        @keyframes syncPulse {
            0%, 100% { box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.15); }
            50% { box-shadow: 0 0 0 8px rgba(34, 197, 94, 0.05); }
        }

        .sync-text h6 {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--blue-dark);
            margin-bottom: 1px;
        }

        .sync-text p {
            font-size: 0.73rem;
            color: var(--text-muted);
            margin: 0;
        }

        .sync-badge {
            margin-left: auto;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #22c55e;
            background: rgba(34, 197, 94, 0.08);
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 6px;
            padding: 4px 10px;
            flex-shrink: 0;
        }

        /* ===== ANIMATION ===== */
        .fade-up {
            opacity: 0;
            transform: translateY(24px);
            animation: fadeUp 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand-kai" href="#">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/56/Logo_PT_Kereta_Api_Indonesia_%28Persero%29_2020.svg" alt="Logo KAI">
                <div class="brand-divider"></div>
                <div class="brand-text">
                    <span class="main-title">KOPEKA</span>
                    <span class="sub-title">Rail Indonesia</span>
                </div>
            </a>
            <div class="nav-right">
                <span class="nav-time" id="navTime"></span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf 
                    <button class="btn-logout" type="submit">
                        <i class="fas fa-power-off"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="page-wrapper">
        <div class="container pb-5">

            <!-- HERO -->
            <div class="hero-dashboard fade-up">
                <div class="hero-bg-photo"></div>
                <div class="hero-bg-grid"></div>
                <div class="hero-bg-glow"></div>
                <div class="hero-body">
                    <div class="hero-accent-bar"></div>
                    <div class="hero-content">
                        <div class="hero-tag">Rail Member Dashboard</div>
                        <h2 class="hero-name">Selamat Datang,<br>{{ $user->users }}</h2>
                        <div class="hero-meta">
                            <div class="hero-meta-item">
                                <span>NIPP</span>
                                <span class="badge-val">{{ $user->nipp }}</span>
                            </div>
                            <div class="hero-meta-dot"></div>
                            <div class="hero-meta-item">
                                <span>Status</span>
                                <span class="badge-val">Anggota Aktif</span>
                            </div>
                        </div>
                        <div class="hero-stat-row">
                            <div class="hero-stat">
                                <div class="hero-stat-label">Periode</div>
                                <div class="hero-stat-value" id="heroPeriod"></div>
                            </div>
                            <div class="hero-stat">
                                <div class="hero-stat-label">Koperasi</div>
                                <div class="hero-stat-value">KOPEKA</div>
                            </div>
                            <div class="hero-stat">
                                <div class="hero-stat-label">Sistem</div>
                                <div class="hero-stat-value orange">Aktif</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARDS LABEL -->
            <div class="section-label fade-up delay-1">Ringkasan Keuangan</div>

            <!-- CARDS ROW -->
            <div class="row g-4 mb-0 fade-up delay-2">
                <!-- SIMPANAN -->
                <div class="col-md-6">
                    <div class="card-rail">
                        <div class="deco-line"></div>
                        <div class="card-header-row">
                            <span class="card-label">Total Simpanan Terakumulasi</span>
                            <div class="icon-box">
                                <i class="fas fa-vault"></i>
                            </div>
                        </div>
                        <div class="card-value">
                            <span class="currency">Rp</span>{{ number_format($keuangan->total_simpanan ?? 0, 0, ',', '.') }}
                        </div>
                        <p class="card-sublabel">Saldo simpanan per hari ini</p>
                        <a href="{{ route('user.simpanan') }}" class="btn-action">
                            <i class="fas fa-chart-line"></i> Lihat Rincian Simpanan
                        </a>
                    </div>
                </div>

                <!-- PINJAMAN -->
                <div class="col-md-6">
                    <div class="card-rail red-accent">
                        <div class="deco-line"></div>
                        <div class="card-header-row">
                            <span class="card-label">Saldo Pinjaman Berjalan</span>
                            <div class="icon-box red">
                                <i class="fas fa-hand-holding-dollar"></i>
                            </div>
                        </div>
                        <div class="card-value negative">
                            <span class="currency">Rp</span>{{ number_format($keuangan->saldo_hutang ?? 0, 0, ',', '.') }}
                        </div>
                        <p class="card-sublabel">Sisa pokok pinjaman aktif</p>
                        <div class="info-pill">
                            <i class="fas fa-rotate"></i>
                            Potongan otomatis via payroll setiap bulan
                        </div>
                    </div>
                </div>
            </div>

            <!-- SYNC STRIP -->
            <div class="sync-strip fade-up delay-3">
                <div class="sync-dot"></div>
                <div class="sync-text">
                    <h6>Sinkronisasi Real-Time</h6>
                    <p>Data keuangan diperbarui otomatis dari sistem pusat Koperasi Rail Indonesia.</p>
                </div>
                <span class="sync-badge">Live</span>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('navTime').textContent = now.toLocaleDateString('id-ID', options);

            const monthYear = now.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
            const el = document.getElementById('heroPeriod');
            if (el) el.textContent = monthYear;
        }
        updateTime();
        setInterval(updateTime, 60000);
    </script>
</body>
</html>