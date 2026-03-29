<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOPEKA - Koperasi Rail Indonesia</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --blue: #002b80;
            --blue-dark: #001a4d;
            --orange: #f26419;
            --orange-glow: rgba(242, 100, 25, 0.4);
            --dark-bg: #05070a;
            --card-bg: rgba(255, 255, 255, 0.03);
            --text-muted: #a0a6bd;
            --commuter-red: #d1121d;
            --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--dark-bg);
            color: #ffffff;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            padding: 0 8%;
            height: 75px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-bottom: 3px solid var(--orange);
            transition: var(--transition);
        }

        .navbar-brand-kai { 
            display: flex; 
            align-items: center; 
            gap: 12px;
            text-decoration: none;
        }
        
        .navbar-brand-kai img { height: 32px; width: auto; }

        .brand-text {
            display: flex;
            flex-direction: column;
            border-left: 2px solid #eee;
            padding-left: 10px;
        }

        .brand-text .main-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--blue);
            line-height: 1;
            letter-spacing: 1px;
        }

        .brand-text .sub-title {
            font-size: 0.6rem;
            font-weight: 700;
            color: var(--commuter-red);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-links { display: flex; align-items: center; gap: 30px; list-style: none; }
        .nav-links a {
            color: var(--blue-dark);
            text-decoration: none; 
            font-size: 0.8rem;
            font-weight: 700; 
            text-transform: uppercase;
            transition: 0.3s;
        }

        .nav-links a:hover { color: var(--orange); }

        .btn-login {
            background: var(--blue);
            color: white !important;
            padding: 10px 22px !important;
            border-radius: 8px;
            font-size: 0.8rem !important;
            box-shadow: 0 4px 12px rgba(0, 43, 128, 0.15);
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }
        
        .btn-login:hover {
            background: var(--blue-dark);
            transform: translateY(-2px);
        }

        /* ===== HERO SECTION ===== */
        .hero {
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            padding: 75px 8% 0;
        }

        .hero-bg {
            position: absolute; inset: 0;
            background: url("https://images.unsplash.com/photo-1532105956626-9569c03602f6?q=80&w=2000") center/cover no-repeat;
        }

        .hero-bg::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(5, 7, 10, 0.95) 30%, rgba(0, 43, 128, 0.4) 100%);
        }

        .hero-content { position: relative; z-index: 2; max-width: 850px; }

        .hero-tag {
            display: inline-block;
            padding: 6px 14px;
            background: rgba(242, 100, 25, 0.1);
            border: 1px solid var(--orange);
            color: var(--orange);
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .hero-title {
            font-weight: 800;
            font-size: clamp(2.5rem, 7vw, 4.5rem);
            line-height: 1.1;
            margin-bottom: 25px;
            letter-spacing: -2px;
        }

        .hero-title .accent {
            color: var(--orange);
            text-shadow: 0 0 30px var(--orange-glow);
        }

        .hero-sub {
            font-size: 1.1rem; color: var(--text-muted);
            max-width: 600px; margin-bottom: 40px;
        }

        .btn-main {
            padding: 16px 35px;
            background: var(--orange);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: var(--transition);
        }

        .btn-main:hover {
            transform: translateY(-5px);
            background: #ff7a33;
        }

        /* ===== SECTION ABOUT & LAYANAN ===== */
        .section-padding { padding: 100px 8%; }
        .section-dark-alt { background: #0a0c10; }
        
        .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
        .about-image { border-radius: 30px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.5); }
        .about-image img { width: 100%; display: block; }
        
        .about-content .section-label { color: var(--orange); font-weight: 700; text-transform: uppercase; letter-spacing: 2px; font-size: 0.85rem; margin-bottom: 15px; display: block; }
        .about-content h2 { font-size: 2.8rem; font-weight: 800; margin-bottom: 25px; line-height: 1.2; }
        .about-content p { color: var(--text-muted); margin-bottom: 20px; font-size: 1.05rem; }

        .header-box { margin-bottom: 60px; border-left: 5px solid var(--orange); padding-left: 25px; }
        .section-title-alt { font-size: 2.5rem; font-weight: 800; color: #fff; }

        .cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
        .card { background: var(--card-bg); border: 1px solid rgba(255,255,255,0.08); border-radius: 24px; padding: 45px 35px; transition: var(--transition); }
        .card:hover { background: rgba(255,255,255,0.06); border-color: var(--orange); transform: translateY(-10px); }
        .card-icon { width: 60px; height: 60px; background: rgba(242, 100, 25, 0.1); border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; color: var(--orange); margin-bottom: 25px; }
        .card-title { font-size: 1.4rem; font-weight: 700; margin-bottom: 15px; color: #fff; }
        .card-text { color: var(--text-muted); font-size: 0.95rem; }

        /* ===== FOOTER UPDATE (REFERENSI SS) ===== */
        .main-footer {
            background: #080a0d; /* Biru sangat gelap sesuai Gambar 2 */
            padding: 80px 8% 50px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1.2fr;
            gap: 50px;
        }

        .footer-col h4 {
            color: #ffffff;
            font-size: 1.2rem;
            font-weight: 800;
            margin-bottom: 25px;
            position: relative;
        }

        .footer-col h4::after {
            content: '';
            position: absolute;
            left: 0; bottom: -8px;
            width: 30px; height: 3px;
            background: var(--orange);
        }

        .footer-info-list { list-style: none; }
        .footer-info-list li {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .footer-info-list i { color: var(--orange); margin-top: 5px; width: 18px; }

        .social-box { display: flex; gap: 15px; margin-top: 20px; }
        .social-box a {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.05);
            display: flex; align-items: center; justify-content: center;
            border-radius: 10px; color: white; transition: 0.3s;
        }
        .social-box a:hover { background: var(--orange); transform: translateY(-3px); }

        /* Baris Paling Bawah (Copyright Hitam Pekat sesuai Gambar 1) */
        .bottom-bar {
            background: #000000; 
            padding: 25px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        .bottom-bar p { color: #ffffff; font-size: 0.85rem; }
        .bottom-bar .brand-accent { color: var(--orange); font-weight: 800; }

        .bottom-socials { display: flex; gap: 20px; }
        .bottom-socials a { color: #ffffff; font-size: 1.1rem; opacity: 0.7; transition: 0.3s; }
        .bottom-socials a:hover { opacity: 1; color: var(--orange); }

        @media (max-width: 992px) {
            .footer-grid { grid-template-columns: 1fr; gap: 40px; }
            .bottom-bar { flex-direction: column; gap: 15px; text-align: center; }
            .nav-links { display: none; }
            .about-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a class="navbar-brand-kai" href="#beranda">
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/56/Logo_PT_Kereta_Api_Indonesia_%28Persero%29_2020.svg" alt="Logo KAI">
            <div class="brand-text">
                <span class="main-title">KOPEKA</span>
                <span class="sub-title">Rail Indonesia</span>
            </div>
        </a>
        <ul class="nav-links">
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#tentang">Tentang</a></li>
            <li><a href="#layanan">Layanan</a></li>
            <li><a href="{{ route('login') }}" class="btn-login"><i class="fas fa-sign-in-alt"></i> Masuk / Login</a></li>
        </ul>
    </nav>

    <section class="hero" id="beranda">
        <div class="hero-bg"></div>
        <div class="hero-content" data-aos="fade-up">
            <span class="hero-tag">Digitalisasi Koperasi Rail Indonesia</span>
            <h1 class="hero-title">Sinergi Membangun <br><span class="accent">Ekonomi Insan Kereta.</span></h1>
            <p class="hero-sub">Wadah gotong royong digital bagi seluruh pegawai KAI untuk mencapai kesejahteraan finansial yang berkelanjutan melalui pengelolaan dana yang profesional.</p>
            <div class="hero-actions">
                <a href="#layanan" class="btn-main">Jelajahi Layanan <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <section class="section-padding" id="tentang">
        <div class="container">
            <div class="about-grid">
                <div class="about-image" data-aos="fade-right">
                    <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=1000" alt="Meeting">
                </div>
                <div class="about-content" data-aos="fade-left">
                    <span class="section-label">Tentang Kami</span>
                    <h2>Koperasi Pegawai PT KAI</h2>
                    <p>KOPEKA hadir sebagai mitra finansial terpercaya bagi seluruh pegawai PT Kereta Api Indonesia (Persero) dengan menjunjung tinggi nilai integritas.</p>
                    <div style="display: flex; gap: 30px; margin-top: 30px;">
                        <div><h4 style="color: var(--orange); font-size: 1.5rem;">20+</h4><p style="font-size: 0.8rem;">Tahun Melayani</p></div>
                        <div><h4 style="color: var(--orange); font-size: 1.5rem;">100%</h4><p style="font-size: 0.8rem;">Transparansi</p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding section-dark-alt" id="layanan">
        <div class="container">
            <div class="header-box" data-aos="fade-right">
                <span style="color: var(--orange); font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Ekosistem Kami</span>
                <h2 class="section-title-alt">Layanan Digital Terintegrasi</h2>
            </div>

            <div class="cards-grid">
                <div class="card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-icon"><i class="fas fa-vault"></i></div>
                    <h3 class="card-title">Simpanan Masa Depan</h3>
                    <p class="card-text">Pengelolaan Simpanan Pokok, Wajib, dan Sukarela dengan sistem bagi hasil yang adil melalui dashboard digital.</p>
                </div>
                <div class="card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-icon"><i class="fas fa-hand-holding-dollar"></i></div>
                    <h3 class="card-title">Pinjaman Terjangkau</h3>
                    <p class="card-text">Akses dana darurat atau kredit barang dengan bunga rendah dan proses administrasi cepat tanpa birokrasi rumit.</p>
                </div>
                <div class="card" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-icon"><i class="fas fa-shopping-bag"></i></div>
                    <h3 class="card-title">C-Corner & Atribut</h3>
                    <p class="card-text">Pusat penyediaan atribut resmi KAI (Lanyard, Seragam, Pin) dengan sistem pembayaran payroll yang praktis.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="main-footer">
        <div class="footer-grid">
            <div class="footer-col" data-aos="fade-up">
                <h4>Koperasi <span style="color:var(--orange)">KOPEKA</span></h4>
                <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 20px;">
                    Membangun ekonomi anggota dengan integritas dan inovasi digital untuk masa depan insan KAI yang lebih baik.
                </p>
                <div class="social-box">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>

            <div class="footer-col" data-aos="fade-up" data-aos-delay="100">
                <h4>Jam Kerja</h4>
                <ul class="footer-info-list">
                    <li><i class="far fa-clock"></i> Senin - Jumat: 08:00 - 17:00 WIB</li>
                    <li><i class="fas fa-calendar-times"></i> Sabtu - Minggu & Hari Libur: Tutup</li>
                </ul>
            </div>

            <div class="footer-col" data-aos="fade-up" data-aos-delay="200">
                <h4>Official Info</h4>
                <ul class="footer-info-list">
                    <li><i class="fas fa-map-marker-alt"></i> Jl. Lempuyangan, Bausasran, Danurejan, Kota Yogyakarta, Daerah Istimewa Yogyakarta</li>
                    <li><i class="fas fa-phone-alt"></i> (022) 1234 5678</li>
                    <li><i class="fas fa-envelope"></i> admin@kopeka-rail.co.id</li>
                </ul>
            </div>
        </div>
    </footer>

    <div class="bottom-bar">
        <p>© 2026 <span class="brand-accent">KOPEKA</span> Rail Indonesia. Melayani dengan Setulus Hati.</p>
        <div class="bottom-socials">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
            <a href="#"><i class="fas fa-envelope"></i></a>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, duration: 1000 });
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                nav.style.height = '65px';
                nav.style.boxShadow = '0 10px 30px rgba(0,0,0,0.2)';
            } else {
                nav.style.height = '75px';
                nav.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>