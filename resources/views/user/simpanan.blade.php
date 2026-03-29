<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Simpanan - KOPEKA</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --blue: #002b80;
            --blue-dark: #001540;
            --blue-mid: #0a3299;
            --orange: #f26419;
            --commuter-red: #c8101a;
            --surface: #f4f5fb;
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

        /* ===== NAVBAR ===== */
        .navbar {
            background: rgba(255, 255, 255, 0.97) !important;
            backdrop-filter: blur(20px);
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

        .brand-text { display: flex; flex-direction: column; gap: 1px; }

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

        /* ===== HERO STRIP ===== */
        .hero-strip {
            background: var(--blue-dark);
            position: relative;
            overflow: hidden;
            padding: 28px 0 32px;
        }

        .hero-strip::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 36px 36px;
        }

        .hero-strip-glow {
            position: absolute;
            top: -80px;
            right: -80px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(242,100,25,0.15) 0%, transparent 65%);
            pointer-events: none;
        }

        .hero-strip-glow-left {
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(0,80,200,0.2) 0%, transparent 65%);
            pointer-events: none;
        }

        .hero-content { position: relative; z-index: 1; }

        .hero-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.72rem;
            color: rgba(255,255,255,0.4);
            font-weight: 500;
            margin-bottom: 16px;
        }

        .hero-breadcrumb a {
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            transition: color 0.2s;
        }

        .hero-breadcrumb a:hover { color: rgba(255,255,255,0.8); }
        .hero-breadcrumb i { font-size: 0.5rem; }

        .hero-top-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .hero-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
            line-height: 1.1;
            margin-bottom: 12px;
        }

        .hero-user-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .hero-avatar {
            width: 34px;
            height: 34px;
            background: rgba(255,255,255,0.12);
            border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: white;
        }

        .hero-user-info { line-height: 1.25; }
        .hero-user-name { font-size: 0.85rem; font-weight: 700; color: white; }
        .hero-user-nipp { font-size: 0.7rem; color: rgba(255,255,255,0.45); font-weight: 500; }

        .hero-total-box { text-align: right; }

        .hero-total-label {
            font-size: 0.62rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255,255,255,0.4);
            font-weight: 700;
            margin-bottom: 4px;
        }

        .hero-total-amount {
            font-size: 2.2rem;
            font-weight: 800;
            color: #ffb07a;
            letter-spacing: -1px;
            line-height: 1;
        }

        .hero-total-currency {
            font-size: 1rem;
            font-weight: 600;
            vertical-align: super;
            margin-right: 3px;
        }

        .hero-status-row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.68rem;
            font-weight: 600;
            color: #4ade80;
            background: rgba(74,222,128,0.1);
            border: 1px solid rgba(74,222,128,0.25);
            border-radius: 50px;
            padding: 4px 12px;
        }

        .status-badge-dot {
            width: 6px;
            height: 6px;
            background: #4ade80;
            border-radius: 50%;
            animation: blink 2s infinite;
        }

        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }

        .hero-meta-text {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.35);
            font-weight: 500;
        }

        /* ===== CONTENT AREA ===== */
        .content-area { padding: 48px 0 64px; }

        /* ===== SECTION HEADING ===== */
        .section-heading {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .section-line {
            flex: 1;
            height: 1px;
            background: var(--border);
            margin-left: 16px;
        }

        /* ===== SIMPANAN ROWS ===== */
        .simpanan-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 0;
            border-bottom: 1px solid var(--border);
        }

        .simpanan-row:first-child { border-top: 1px solid var(--border); }

        .row-left {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
        }

        .row-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .row-icon.pokok    { background: rgba(0,43,128,0.07);   color: var(--blue); }
        .row-icon.wajib    { background: rgba(242,100,25,0.08);  color: var(--orange); }
        .row-icon.sukarela { background: rgba(34,197,94,0.08);  color: #16a34a; }

        .row-label {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--blue-dark);
            margin-bottom: 2px;
        }

        .row-desc {
            font-size: 0.72rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .row-progress-wrap {
            flex: 1;
            max-width: 200px;
            margin: 0 40px;
        }

        .row-progress-track {
            height: 4px;
            background: var(--border);
            border-radius: 99px;
            overflow: hidden;
        }

        .row-progress-fill {
            height: 100%;
            border-radius: 99px;
            transition: width 1s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .row-progress-fill.pokok    { background: var(--blue); }
        .row-progress-fill.wajib    { background: var(--orange); }
        .row-progress-fill.sukarela { background: #22c55e; }

        .row-pct {
            font-size: 0.65rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-top: 5px;
            text-align: right;
        }

        .row-right { text-align: right; }

        .row-amount {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--blue-dark);
            letter-spacing: -0.3px;
        }

        .row-amount.green { color: #16a34a; }

        .row-amount-label {
            font-size: 0.65rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 2px;
        }

        /* ===== TOTAL FULL ROW ===== */
        .total-row-full {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 36px;
            padding: 28px 36px;
            background: var(--blue-dark);
            border-radius: 18px;
            position: relative;
            overflow: hidden;
        }

        .total-row-full::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .total-row-full-glow {
            position: absolute;
            right: -40px;
            top: -40px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(242,100,25,0.18) 0%, transparent 65%);
        }

        .total-left { position: relative; z-index: 1; }

        .total-tag {
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255,255,255,0.35);
            margin-bottom: 4px;
        }

        .total-label-main {
            font-size: 1rem;
            font-weight: 700;
            color: white;
        }

        .total-right {
            position: relative;
            z-index: 1;
            text-align: right;
        }

        .total-amount-full {
            font-size: 2.4rem;
            font-weight: 800;
            color: #ffb07a;
            letter-spacing: -1.5px;
            line-height: 1;
        }

        .total-amount-full .cur {
            font-size: 1rem;
            font-weight: 600;
            vertical-align: super;
            margin-right: 3px;
        }

        .total-note {
            font-size: 0.68rem;
            color: rgba(255,255,255,0.3);
            margin-top: 5px;
            font-weight: 500;
        }

        /* ===== BACK BUTTON ===== */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1.5px solid var(--border);
            color: var(--blue-dark);
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.82rem;
            padding: 11px 22px;
            text-decoration: none;
            transition: var(--transition);
            margin-top: 32px;
        }

        .btn-back:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: rgba(0,43,128,0.03);
            box-shadow: 0 6px 20px rgba(0,43,128,0.08);
        }

        .btn-back i { font-size: 0.72rem; }

        /* ===== ANIMATIONS ===== */
        .fade-up {
            opacity: 0;
            transform: translateY(18px);
            animation: fadeUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }

        .d1 { animation-delay: 0.05s; }
        .d2 { animation-delay: 0.12s; }
        .d3 { animation-delay: 0.19s; }
        .d4 { animation-delay: 0.26s; }

        .d5 { animation-delay: 0.40s; }

        /* ===== CHART SECTION ===== */
        .chart-section {
            margin-top: 48px;
        }

        .chart-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .chart-title-group { }

        .chart-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--blue-dark);
            margin-bottom: 2px;
        }

        .chart-subtitle {
            font-size: 0.72rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .chart-legend {
            display: flex;
            gap: 16px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .chart-wrap {
            background: white;
            border-radius: 18px;
            border: 1px solid var(--border);
            padding: 28px 28px 20px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.03);
        }

        .chart-canvas-wrap {
            position: relative;
            height: 260px;
        }

        @media (max-width: 768px) {
            .hero-top-row { flex-direction: column; }
            .hero-total-box { text-align: left; }
            .hero-total-amount { font-size: 1.6rem; }
            .row-progress-wrap { display: none; }
            .total-amount-full { font-size: 1.8rem; }
            .total-row-full { flex-direction: column; align-items: flex-start; gap: 16px; }
            .total-right { text-align: left; }
            .chart-legend { flex-wrap: wrap; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
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
        </div>
    </nav>

    <!-- HERO STRIP -->
    <div class="hero-strip">
        <div class="hero-strip-glow"></div>
        <div class="hero-strip-glow-left"></div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-breadcrumb">
                    <a href="{{ route('user.dashboard') }}">Dashboard</a>
                    <i class="fas fa-chevron-right"></i>
                    <span>Rincian Simpanan</span>
                </div>
                <div class="hero-top-row">
                    <div>
                        <h1 class="hero-title">Rincian Simpanan</h1>
                        <div class="hero-user-row">
                            <div class="hero-avatar">{{ strtoupper(substr($user->users, 0, 1)) }}</div>
                            <div class="hero-user-info">
                                <div class="hero-user-name">{{ $user->users }}</div>
                                <div class="hero-user-nipp">NIPP {{ $user->nipp ?? $user->nik }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-status-row">
                    <div class="status-badge">
                        <div class="status-badge-dot"></div>
                        Rekening Aktif
                    </div>
                    <span class="hero-meta-text">Data diperbarui otomatis dari sistem pusat KOPEKA</span>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content-area">
        <div class="container">

            <div class="section-heading fade-up d1">
                <span class="section-title">Rincian per Kategori</span>
                <div class="section-line"></div>
            </div>

            <div class="fade-up d2">
                <!-- Pokok -->
                <div class="simpanan-row">
                    <div class="row-left">
                        <div class="row-icon pokok"><i class="fas fa-landmark"></i></div>
                        <div>
                            <div class="row-label">Simpanan Pokok</div>
                            <div class="row-desc">Setoran awal keanggotaan</div>
                        </div>
                    </div>
                    <div class="row-progress-wrap">
                        <div class="row-progress-track">
                            <div class="row-progress-fill pokok" id="bar-pokok" style="width:0%"></div>
                        </div>
                        <div class="row-pct" id="pct-pokok"></div>
                    </div>
                    <div class="row-right">
                        <div class="row-amount">Rp {{ number_format($simpanan->pokok ?? 0, 0, ',', '.') }}</div>
                        <div class="row-amount-label">Saldo saat ini</div>
                    </div>
                </div>

                <!-- Wajib -->
                <div class="simpanan-row">
                    <div class="row-left">
                        <div class="row-icon wajib"><i class="fas fa-calendar-check"></i></div>
                        <div>
                            <div class="row-label">Simpanan Wajib</div>
                            <div class="row-desc">Potongan rutin bulanan</div>
                        </div>
                    </div>
                    <div class="row-progress-wrap">
                        <div class="row-progress-track">
                            <div class="row-progress-fill wajib" id="bar-wajib" style="width:0%"></div>
                        </div>
                        <div class="row-pct" id="pct-wajib"></div>
                    </div>
                    <div class="row-right">
                        <div class="row-amount">Rp {{ number_format($simpanan->wajib ?? 0, 0, ',', '.') }}</div>
                        <div class="row-amount-label">Saldo saat ini</div>
                    </div>
                </div>

                <!-- Sukarela -->
                <div class="simpanan-row">
                    <div class="row-left">
                        <div class="row-icon sukarela"><i class="fas fa-piggy-bank"></i></div>
                        <div>
                            <div class="row-label">Simpanan Sukarela</div>
                            <div class="row-desc">Tabungan tambahan anggota</div>
                        </div>
                    </div>
                    <div class="row-progress-wrap">
                        <div class="row-progress-track">
                            <div class="row-progress-fill sukarela" id="bar-sukarela" style="width:0%"></div>
                        </div>
                        <div class="row-pct" id="pct-sukarela"></div>
                    </div>
                    <div class="row-right">
                        <div class="row-amount green">Rp {{ number_format($simpanan->sukarela ?? 0, 0, ',', '.') }}</div>
                        <div class="row-amount-label">Saldo saat ini</div>
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="total-row-full fade-up d3">
                <div class="total-row-full-glow"></div>
                <div class="total-left">
                    <div class="total-tag">Akumulasi Simpanan</div>
                    <div class="total-label-main">Total Keseluruhan</div>
                </div>
                <div class="total-right">
                    <div class="total-amount-full">
                        <span class="cur">Rp</span>{{ number_format($simpanan->total_simpanan ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="total-note">Pokok + Wajib + Sukarela</div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="chart-section fade-up d5">
                <div class="chart-header">
                    <div class="chart-title-group">
                        <div class="chart-title">Perkembangan Simpanan Bulanan</div>
                        <div class="chart-subtitle">Akumulasi total simpanan 12 bulan terakhir</div>
                    </div>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <div class="legend-dot" style="background: #002b80;"></div> Wajib
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background: #f26419;"></div> Sukarela
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background: #22c55e;"></div> Total
                        </div>
                    </div>
                </div>
                <div class="chart-wrap">
                    <div class="chart-canvas-wrap">
                        <canvas id="simpananChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Back -->
            <div class="fade-up d4">
                <a href="{{ route('user.dashboard') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const pokok    = {{ $simpanan->pokok ?? 0 }};
        const wajib    = {{ $simpanan->wajib ?? 0 }};
        const sukarela = {{ $simpanan->sukarela ?? 0 }};
        const total    = pokok + wajib + sukarela;

        function animateBar(barId, pctId, val) {
            const pct = total > 0 ? Math.round((val / total) * 100) : 0;
            document.getElementById(barId).style.width = pct + '%';
            document.getElementById(pctId).textContent = pct + '% dari total';
        }

        setTimeout(() => {
            animateBar('bar-pokok',    'pct-pokok',    pokok);
            animateBar('bar-wajib',    'pct-wajib',    wajib);
            animateBar('bar-sukarela', 'pct-sukarela', sukarela);
        }, 400);

        // ===== CHART =====
        const months = ['Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des', 'Jan', 'Feb', 'Mar'];

        // Simulate cumulative growth from simpanan data (backend should replace this with real $riwayat data)
        const baseWajib    = wajib    > 0 ? wajib    / 12 : 150000;
        const baseSukarela = sukarela > 0 ? sukarela / 12 : 50000;

        const dataWajib    = months.map((_, i) => Math.round(baseWajib    * (i + 1)));
        const dataSukarela = months.map((_, i) => Math.round(baseSukarela * (i + 1) * (1 + i * 0.02)));
        const dataTotal    = months.map((_, i) => dataWajib[i] + dataSukarela[i] + (pokok > 0 ? pokok : 200000));

        const ctx = document.getElementById('simpananChart').getContext('2d');

        const gradBlue = ctx.createLinearGradient(0, 0, 0, 260);
        gradBlue.addColorStop(0, 'rgba(0,43,128,0.12)');
        gradBlue.addColorStop(1, 'rgba(0,43,128,0)');

        const gradOrange = ctx.createLinearGradient(0, 0, 0, 260);
        gradOrange.addColorStop(0, 'rgba(242,100,25,0.10)');
        gradOrange.addColorStop(1, 'rgba(242,100,25,0)');

        const gradGreen = ctx.createLinearGradient(0, 0, 0, 260);
        gradGreen.addColorStop(0, 'rgba(34,197,94,0.12)');
        gradGreen.addColorStop(1, 'rgba(34,197,94,0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Wajib',
                        data: dataWajib,
                        borderColor: '#002b80',
                        backgroundColor: gradBlue,
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: '#002b80',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        tension: 0.4,
                        fill: true,
                    },
                    {
                        label: 'Sukarela',
                        data: dataSukarela,
                        borderColor: '#f26419',
                        backgroundColor: gradOrange,
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: '#f26419',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        tension: 0.4,
                        fill: true,
                    },
                    {
                        label: 'Total',
                        data: dataTotal,
                        borderColor: '#22c55e',
                        backgroundColor: gradGreen,
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointBackgroundColor: '#22c55e',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        tension: 0.4,
                        fill: true,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#001540',
                        titleColor: 'rgba(255,255,255,0.5)',
                        bodyColor: '#fff',
                        padding: 12,
                        borderColor: 'rgba(255,255,255,0.06)',
                        borderWidth: 1,
                        cornerRadius: 10,
                        callbacks: {
                            label: ctx => {
                                const val = ctx.parsed.y;
                                return ` ${ctx.dataset.label}: Rp ${val.toLocaleString('id-ID')}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        border: { display: false },
                        ticks: {
                            color: '#7a82a0',
                            font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }
                        }
                    },
                    y: {
                        grid: { color: 'rgba(0,43,128,0.05)', drawBorder: false },
                        border: { display: false, dash: [4, 4] },
                        ticks: {
                            color: '#7a82a0',
                            font: { family: 'Plus Jakarta Sans', size: 11 },
                            callback: val => 'Rp ' + (val >= 1000000
                                ? (val / 1000000).toFixed(1) + 'jt'
                                : (val / 1000).toFixed(0) + 'rb')
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>