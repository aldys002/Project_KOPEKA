<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOPEKA - Koperasi Rail Indonesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --kai-blue: #003399;
            --kai-orange: #ED6B23;
            --kai-light-gray: #f4f4f4;
            --commuter-red: #d1121d;
        }

        body { font-family: 'Inter', sans-serif; background-color: #fff; color: #333; overflow-x: hidden; }

        /* --- NAVBAR --- */
        .navbar { 
            background: white; 
            padding: 5px 0; 
            border-bottom: 5px solid var(--kai-orange); 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
        }
        .navbar-brand-kai { display: flex; flex-direction: column; align-items: center; text-decoration: none; }
        .navbar-brand-kai img { height: 80px; width: auto; margin-bottom: -25px; }
        .navbar-brand-kai span { 
            font-size: 0.9rem; font-weight: 800; color: var(--commuter-red); 
            font-style: italic; margin-left: 75px; 
        }
        .nav-link { 
            font-weight: 700; color: var(--kai-blue) !important; 
            text-transform: uppercase; font-size: 0.95rem; padding-top: 20px !important; 
        }

        /* --- HERO (GAMBAR KERETA) --- */
        .hero-section {
            position: relative; height: 75vh;
            background: linear-gradient(rgba(0, 51, 153, 0.6), rgba(0, 51, 153, 0.3)), url("{{ asset('images/kereta.jpeg') }}") no-repeat center center;
            background-size: cover; display: flex; align-items: center; color: white; border-bottom-right-radius: 100px;
        }
        .hero-title { font-weight: 800; font-size: 4rem; line-height: 1.1; margin-bottom: 25px; }
        .hero-subtitle { font-size: 1.1rem; margin-bottom: 30px; max-width: 600px; opacity: 0.9; }

        .btn-masuk-utama {
            background-color: white; color: var(--kai-blue); font-weight: 800;
            padding: 15px 35px; border-radius: 50px; text-decoration: none;
            display: inline-flex; align-items: center; box-shadow: 0 10px 25px rgba(0,0,0,0.2); transition: 0.3s;
        }
        .btn-masuk-utama:hover { background-color: var(--kai-orange); color: white; transform: translateY(-5px); }

        /* --- LAYANAN ANGGOTA (Informasi Detail) --- */
        .layanan-section { background-color: var(--kai-light-gray); padding: 80px 0; text-align: center; }
        .feature-box {
            background: white; padding: 40px 20px; border-radius: 35px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); height: 100%;
            transition: 0.3s; border: 1px solid transparent;
        }
        .feature-box:hover { border-color: var(--kai-orange); transform: translateY(-10px); }
        .feature-icon-wrapper {
            width: 100px; height: 100px; border-radius: 25px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 25px; background: var(--kai-light-gray);
        }
        .feature-icon-wrapper img { width: 60px; }
        .feature-icon-wrapper i { font-size: 3rem; color: var(--commuter-red); }

        /* --- C-CORNER --- */
        .c-corner-section { padding: 80px 0; background-color: white; }
        .product-card { border: none; border-radius: 20px; background: var(--kai-light-gray); padding: 20px; text-align: left; }
        .btn-product { background-color: var(--commuter-red); color: white; border-radius: 10px; width: 100%; border: none; padding: 10px; font-weight: 700; }

        .footer-kai { background: var(--kai-blue); color: white; padding: 40px 0; text-align: center; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand-kai" href="#">
                <img src="{{ asset('images/logo-kai-.png') }}" alt="Logo KAI">
                <span>KOPEKA</span>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link px-3" href="#">Dashboard</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3" href="#" data-bs-toggle="dropdown">Layanan</a>
                        <ul class="dropdown-menu border-0 shadow">
                            <li><a class="dropdown-item" href="#">Simpanan</a></li>
                            <li><a class="dropdown-item" href="#">Pinjaman</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link px-3" href="#">Produk</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Membangun <br> Kesejahteraan <br> Bersama</h1>
            <p class="hero-subtitle">Nikmati kemudahan layanan keuangan anggota Koperasi Rail Indonesia. Aman, Terpercaya, dan Melayani dengan Setulus Hati.</p>
            <a href="{{ route('login') }}" class="btn-masuk-utama">
                Masuk Sekarang <i class="fas fa-arrow-right ms-3"></i>
            </a>
        </div>
    </section>

    <section class="layanan-section">
        <div class="container">
            <div class="mb-5 text-center">
                <h2 class="fw-bold">Informasi Layanan KOPEKA</h2>
                <p>Penjelasan lengkap mengenai saldo, kewajiban hutang, dan produk anggota.</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon-wrapper">
                            <img src="https://cdn-icons-png.flaticon.com/512/2489/2489756.png" alt="Simpanan">
                        </div>
                        <h4 class="fw-bold color-kai-blue">Informasi Simpanan</h4>
                        <p class="small text-muted">Pantau total Simpanan Pokok, Wajib, dan Sukarela Anda secara real-time.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon-wrapper">
                            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135706.png" alt="Hutang">
                        </div>
                        <h4 class="fw-bold color-kai-blue">Pinjaman & Hutang</h4>
                        <p class="small text-muted">Informasi detail mengenai sisa hutang pinjaman dan jumlah angsuran per bulan.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon-wrapper">
                            <i class="fas fa-shopping-basket"></i>
                        </div>
                        <h4 class="fw-bold color-kai-blue">Info Barang Jual</h4>
                        <p class="small text-muted">Katalog lengkap kebutuhan kantor seperti Lanyard dan atribut resmi di C-Corner.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="c-corner-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="fw-bold">Katalog Produk C-Corner</h2>
                <a href="#" class="text-danger fw-bold text-decoration-none">Lihat Semua <i class="fas fa-chevron-right ms-1"></i></a>
            </div>
            
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="product-card">
                        <div class="product-img-wrapper bg-white rounded-4 mb-3 d-flex align-items-center justify-content-center" style="height:180px">
                            <img src="https://id-test-11.slatic.net/p/3f7e5d8b8a8b8b8b8b8b8b8b8b8b8b8b.jpg" alt="Lanyard" style="width:65%">
                        </div>
                        <h6 class="fw-bold">Lanyard KAI Blue Edition</h6>
                        <div class="text-danger fw-bold mb-3">Rp 35.000</div>
                        <button class="btn-product">Beli Sekarang</button>
                    </div>
                </div>
                </div>
        </div>
    </section>

    <footer class="footer-kai">
        <div class="container">
            <p>© 2026 KOPEKA Rail Indonesia. Melayani dengan Setulus Hati.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>