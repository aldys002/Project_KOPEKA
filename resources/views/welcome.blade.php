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
            --kai-dark: #1a252f;
        }

        body { font-family: 'Inter', sans-serif; background-color: #fff; color: #333; }

        /* Navbar Style */
        .navbar { 
            background: white; 
            padding: 1px 0; 
            border-bottom: 5px solid var(--kai-orange); 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand { font-weight: 800; color: var(--kai-blue) !important; font-size: 1.8rem; }
        .navbar-brand img {
            height: 65px;
            width: auto;
            object-fit: contain;
        }
        .nav-link { 
            font-weight: 700; 
            color: var(--kai-blue) !important; 
            text-transform: uppercase; 
            font-size: 0.85rem; 
            letter-spacing: 0.5px;
        }

        /* Dropdown Style */
        .dropdown-menu { 
            background-color: var(--kai-dark); 
            border: none; 
            border-radius: 0; 
            padding: 0;
            min-width: 220px;
            margin-top: 15px;
        }
        .dropdown-item { 
            color: rgba(255,255,255,0.8) !important; 
            padding: 12px 25px; 
            border-bottom: 1px dashed rgba(255,255,255,0.1);
            font-size: 0.9rem;
            transition: 0.3s;
        }
        .dropdown-item:hover { 
            background-color: rgba(255,255,255,0.1); 
            color: var(--kai-orange) !important; 
            padding-left: 30px;
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            height: 85vh;
            background: url("{{ asset('images/kereta.jpeg') }}") no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
            overflow: hidden;
            border-bottom-right-radius: 150px;
        }

        .hero-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to right, rgba(0, 51, 153, 0.85), rgba(237, 107, 35, 0.45));
            z-index: 1;
        }

        .hero-content { position: relative; z-index: 2; color: white; }
        .hero-title { font-weight: 800; font-size: 4rem; line-height: 1.1; margin-bottom: 20px; }
        .hero-sub { font-size: 1.2rem; opacity: 0.9; margin-bottom: 35px; max-width: 550px; }

        .btn-masuk {
            background-color: white;
            color: var(--kai-blue);
            font-weight: 700;
            padding: 16px 45px;
            border-radius: 50px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: 0.3s;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            border: none;
        }
        .btn-masuk:hover { 
            background-color: var(--kai-orange); 
            color: white; 
            transform: translateY(-5px); 
        }

        /* Hero Image Placeholder */
        .hero-image-slot {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 420px;
        }
        .hero-image-slot img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 24px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.35);
        }
        /* Placeholder tampilan saat belum ada gambar */
        .hero-img-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 24px;
            border: 3px dashed rgba(255,255,255,0.4);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.6);
            font-size: 0.95rem;
            gap: 12px;
            backdrop-filter: blur(4px);
            background: rgba(255,255,255,0.08);
        }
        .hero-img-placeholder i { font-size: 3rem; opacity: 0.5; }

        /* Card Section */
        .card-service {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: 0.3s;
        }
        .card-service:hover { transform: translateY(-10px); }
        .card-img-container { height: 250px; overflow: hidden; position: relative; }
        .card-img-container img { width: 100%; height: 100%; object-fit: cover; }
        .card-body-custom { padding: 30px; background: white; }
        
        .footer-kai { background: var(--kai-blue); color: white; padding: 80px 0 30px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <!-- 
                LOGO KAI: Ganti src di bawah dengan path logo kamu.
                Contoh Laravel: {{ asset('images/logo-kai.png') }}
                Atau path langsung: /images/logo-kai.png
            -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <img src="{{ asset('images/logo-kai-.png') }}" alt="Logo KAI KOPEKA">
                <span style="font-size: 1.0rem; font-weight: 800; color: #003399;">KOPEKA</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#">Tentang Kami</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3" href="#" id="dropSimp" role="button" data-bs-toggle="dropdown">
                            Simpanan
                        </a>
                        <ul class="dropdown-menu shadow-lg border-top border-warning border-3">
                            <li><a class="dropdown-item" href="#">Simpanan Pokok</a></li>
                            <li><a class="dropdown-item" href="#">Simpanan Wajib</a></li>
                            <li><a class="dropdown-item" href="#">Simpanan Sukarela</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3" href="#" id="dropPinj" role="button" data-bs-toggle="dropdown">
                            Pinjaman
                        </a>
                        <ul class="dropdown-menu shadow-lg border-top border-warning border-3">
                            <li><a class="dropdown-item" href="#">Pinjaman Kesejahteraan</a></li>
                            <li><a class="dropdown-item" href="#">Pinjaman Pendidikan</a></li>
                            <li><a class="dropdown-item" href="#">Informasi Bunga</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="row hero-content align-items-center g-5">

                <!-- Teks Kiri -->
                <div class="col-lg-6">
                    <h1 class="hero-title">Membangun <br> Kesejahteraan <br> Bersama</h1>
                    <p class="hero-sub">Nikmati kemudahan layanan keuangan anggota Koperasi Rail Indonesia. Aman, Terpercaya, dan Melayani dengan Setulus Hati.</p>
                    <a href="{{ route('login') }}" class="btn-masuk">
                        Masuk Sekarang <i class="fas fa-arrow-right ms-3"></i>
                    </a>
                </div>
                
            </div>
        </div>
    </section>

    <section class="py-5 my-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card-service">
                        <div class="card-img-container">
                            <img src="https://images.unsplash.com/photo-1553729459-efe14ef6055d?q=80&w=2070" alt="Simpanan">
                        </div>
                        <div class="card-body-custom">
                            <h3 class="fw-bold text-primary">SIMPANAN</h3>
                            <p class="text-secondary">Kelola masa depan finansial Anda dengan program simpanan anggota yang kompetitif.</p>
                            <a href="#" class="btn btn-outline-primary rounded-pill px-4">Lihat Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-service">
                        <div class="card-img-container">
                            <img src="https://images.unsplash.com/photo-1454165833767-02a698d48767?q=80&w=2070" alt="Pinjaman">
                        </div>
                        <div class="card-body-custom">
                            <h3 class="fw-bold text-primary">PINJAMAN</h3>
                            <p class="text-secondary">Solusi dana cepat dan mudah untuk kebutuhan darurat, pendidikan, atau modal usaha.</p>
                            <a href="#" class="btn btn-outline-primary rounded-pill px-4">Lihat Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer-kai">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h2 class="fw-bold mb-4"><i class="fas fa-train me-2"></i>KOPEKA</h2>
                    <h4 class="fw-bold text-warning">Mulai Persiapkan Masa Depanmu Sekarang</h4>
                </div>
                <div class="col-md-3 mb-4 small">
                    <h6 class="fw-bold">LAYANAN</h6>
                    <ul class="list-unstyled opacity-75 mt-3">
                        <li>Simpanan Berjangka</li>
                        <li>Pinjaman Kredit</li>
                        <li>Beasiswa Anggota</li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="fw-bold small">HUBUNGI KAMI</h6>
                    <h4 class="text-warning mt-3 fw-bold">+62 819-0370-9333</h4>
                    <p class="small opacity-75">JL. Lempuyangan, No. 1, Tegal Panggung, Danurejan, Yogyakarta, DI Yogyakarta, Indonesia</p>
                </div>
            </div>
            <hr class="my-5 opacity-25">
            <p class="text-center small opacity-50 mb-0">© 2026 Koperasi Konsumen KAI Internasional. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>