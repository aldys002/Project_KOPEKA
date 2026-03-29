<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — KOPEKA KAI Daop 6 Yogyakarta</title>
    
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=DM+Mono:wght@400;500&family=Fraunces:opsz,wght@9..144,300;9..144,400;9..144,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink:       #0A0E1A;
            --ink-2:     #1C2236;
            --ink-3:     #3A4460;
            --muted:     #7A849E;
            --border:    #E2E6F0;
            --surface:   #F6F8FC;
            --white:     #FFFFFF;
            --orange:    #F05A22;
            --orange-lt: rgba(240,90,34,0.10);
            --blue:      #0033A0;
            --blue-dk:   #001A5E;
            --blue-lt:   rgba(0,51,160,0.07);
            --green:     #1BA46A;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--surface);
            color: var(--ink);
            min-height: 100vh;
            padding-top: 80px;
            -webkit-font-smoothing: antialiased;
        }

        /* ── TOP BAR / NAVBAR ── */
        .top-bar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 72px;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 36px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            z-index: 1000;
        }

        .logo-lockup { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .kai-circle {
            width: 40px; height: 40px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 10px;
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 2px;
        }
        .kai-circle span { font-family: 'DM Mono', monospace; font-size: 10px; font-weight: 600; color: var(--blue-dk); line-height: 1; }
        .kai-circle .bar { width: 24px; height: 2.5px; background: var(--orange); border-radius: 1px; }
        .logo-text .name { font-family: 'DM Mono', monospace; font-size: 15px; font-weight: 600; color: var(--ink); letter-spacing: 1px; }

        .nav-actions { display: flex; align-items: center; gap: 16px; }

        .year-select-wrap { 
            background: var(--surface); 
            padding: 6px 14px; 
            border-radius: 10px; 
            border: 1.5px solid var(--border); 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }
        .year-select-wrap label { font-family: 'DM Mono', monospace; font-size: 11px; color: var(--muted); text-transform: uppercase; font-weight: 500; }
        .year-select-wrap select { border: none; background: transparent; font-weight: 600; color: var(--blue); outline: none; cursor: pointer; font-size: 14px; font-family: inherit; }

        .btn-nav-add { 
            background: var(--blue); 
            color: var(--white); 
            border: none; 
            padding: 10px 18px; 
            border-radius: 10px; 
            font-size: 13.5px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: 0.22s; 
            display: flex; 
            align-items: center; 
            gap: 8px; 
        }
        .btn-nav-add:hover { background: var(--blue-dk); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,51,160,0.2); }

        .btn-logout-icon { 
            color: var(--muted); 
            background: none; 
            border: 1.5px solid var(--border); 
            width: 42px; 
            height: 42px; 
            border-radius: 10px; 
            cursor: pointer; 
            transition: 0.2s; 
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-logout-icon:hover { color: #E74C3C; border-color: #FADBD8; background: #FDEDEC; }

        /* ── MAIN CONTENT ── */
        .container { max-width: 1200px; margin: 0 auto; padding: 40px 24px; }

        .welcome-header { margin-bottom: 36px; }
        .welcome-header h1 { font-family: 'Fraunces', serif; font-size: 36px; font-weight: 400; color: var(--ink); margin-bottom: 6px; }
        .welcome-header h1 em { font-style: italic; color: var(--blue); }
        .welcome-header p { color: var(--muted); font-size: 15px; }

        /* ── STATS GRID ── */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 48px; }
        .stat-card { 
            background: var(--white); 
            padding: 28px; 
            border-radius: 20px; 
            border: 1.5px solid var(--border); 
            position: relative; 
            overflow: hidden; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,8,30,0.06); border-color: var(--blue-lt); }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 5px; height: 100%; background: var(--border); }
        .stat-card.blue::before { background: var(--blue); }
        .stat-card.orange::before { background: var(--orange); }
        .stat-card.green::before { background: var(--green); }

        .stat-label { font-family: 'DM Mono', monospace; font-size: 10.5px; text-transform: uppercase; letter-spacing: 1.5px; color: var(--muted); margin-bottom: 14px; display: block; font-weight: 500; }
        .stat-value { font-size: 26px; font-weight: 600; color: var(--ink); margin-bottom: 6px; }
        .stat-sub { font-size: 12.5px; color: var(--muted); line-height: 1.5; }

        /* ── MENU CARDS (STACKED) ── */
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px; }
        .menu-card { 
            text-decoration: none;
            background: var(--white);
            padding: 36px;
            border-radius: 24px;
            border: 1.5px solid var(--border);
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .menu-card:hover { border-color: var(--ink); transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.04); }
        
        .menu-icon { 
            width: 54px; height: 54px; 
            border-radius: 14px; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 22px; 
            margin-bottom: 8px;
        }
        .menu-card.blue .menu-icon { background: var(--blue-lt); color: var(--blue); }
        .menu-card.orange .menu-icon { background: var(--orange-lt); color: var(--orange); }

        .menu-card h2 { font-family: 'Fraunces', serif; font-size: 24px; color: var(--ink); font-weight: 400; }
        .menu-card p { color: var(--muted); font-size: 14.5px; line-height: 1.65; flex-grow: 1; }
        .menu-card .action-text { display: flex; align-items: center; gap: 8px; font-weight: 600; font-size: 13.5px; transition: gap 0.2s; }
        .menu-card.blue .action-text { color: var(--blue); }
        .menu-card.orange .action-text { color: var(--orange); }
        .menu-card:hover .action-text { gap: 12px; }

        /* ── MODAL ── */
        .modal { display: none; position: fixed; inset: 0; background: rgba(10, 14, 26, 0.75); backdrop-filter: blur(6px); z-index: 2000; align-items: center; justify-content: center; padding: 20px; }
        .modal-content { background: var(--white); width: 100%; max-width: 520px; border-radius: 24px; padding: 40px; position: relative; animation: slideUp 0.4s ease-out; }
        @keyframes slideUp { from { opacity:0; transform: translateY(40px); } to { opacity:1; transform: translateY(0); } }

        .modal-header h2 { font-family: 'Fraunces', serif; font-size: 28px; font-weight: 400; margin-bottom: 8px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; color: var(--muted); margin-bottom: 8px; letter-spacing: 0.5px; }
        .form-group input { width: 100%; height: 48px; background: var(--surface); border: 1.5px solid var(--border); border-radius: 12px; padding: 0 16px; font-family: inherit; font-size: 14.5px; transition: 0.2s; }
        .form-group input:focus { border-color: var(--blue); outline: none; background: var(--white); box-shadow: 0 0 0 4px var(--blue-lt); }
        .flex-row { display: flex; gap: 16px; }
        .flex-row > .form-group { flex: 1; }

        /* Bottom Bar */
        .bottom-bar { position: fixed; bottom: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, var(--blue) 58%, var(--orange) 58%); z-index: 1000; }

        @media (max-width: 768px) {
            .top-bar { padding: 0 20px; }
            .logo-text { display: none; }
            .nav-actions .btn-nav-add span { display: none; }
            .welcome-header h1 { font-size: 28px; }
        }
    </style>
</head>
<body>

    <header class="top-bar">
        <a href="#" class="logo-lockup">
            <div class="kai-circle">
                <span>KAI</span>
                <div class="bar"></div>
            </div>
            <div class="logo-text">
                <span class="name">KOPEKA</span>
            </div>
        </a>

        <div class="nav-actions">
            <div class="year-select-wrap">
                <label><i class="fas fa-calendar-alt"></i></label>
                <select onchange="window.location.href='/admin/dashboard?tahun=' + this.value">
                    @foreach($daftarTahun as $th)
                        <option value="{{ $th }}" {{ $tahunAktif == $th ? 'selected' : '' }}>{{ $th }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn-nav-add" onclick="document.getElementById('modalTambah').style.display='flex'">
                <i class="fas fa-plus"></i>
                <span>Tambah Anggota</span>
            </button>

            <form action="{{ route('admin.logout') }}" method="POST" id="logout-form" style="display:none;">@csrf</form>
            <button class="btn-logout-icon" onclick="document.getElementById('logout-form').submit()" title="Keluar dari Sistem">
                <i class="fas fa-power-off"></i>
            </button>
        </div>
    </header>

    <main class="container">
        <div class="welcome-header">
            <h1>Dashboard <em>Admin</em></h1>
            <p>Manajemen data operasional KOPEKA Daop 6 Yogyakarta — Periode Buku {{ $tahunAktif }}</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card blue">
                <span class="stat-label">Statistik Anggota</span>
                <div class="stat-value">{{ $totalAnggota }} <span style="font-size: 14px; font-weight: 400; color: var(--muted);">Anggota</span></div>
                <div class="stat-sub">
                    <span style="color: var(--green); font-weight: 600;">● {{ $anggotaAktif }} Aktif</span> 
                    <span style="margin-left:12px; color: var(--orange); font-weight: 600;">● {{ $anggotaKeluar }} Keluar</span>
                </div>
            </div>
            
            <div class="stat-card">
                <span class="stat-label">Simpanan Pokok</span>
                <div class="stat-value">Rp {{ number_format($totalPokok, 0, ',', '.') }}</div>
                <div class="stat-sub">Total akumulasi dana pokok</div>
            </div>

            <div class="stat-card">
                <span class="stat-label">Simpanan Wajib</span>
                <div class="stat-value">Rp {{ number_format($totalWajib, 0, ',', '.') }}</div>
                <div class="stat-sub">Total akumulasi dana wajib</div>
            </div>

            <div class="stat-card green">
                <span class="stat-label">Total Saldo {{ $tahunAktif }}</span>
                <div class="stat-value">Rp {{ number_format($totalSimpananKeseluruhan, 0, ',', '.') }}</div>
                <div class="stat-sub">Gabungan seluruh jenis simpanan</div>
            </div>

            <div class="stat-card orange">
                <span class="stat-label">Total Piutang</span>
                <div class="stat-value" style="color: var(--orange);">Rp {{ number_format($totalHutang, 0, ',', '.') }}</div>
                <div class="stat-sub">Saldo pinjaman anggota belum lunas</div>
            </div>
        </div>

        <div class="menu-grid">
            
            <a href="{{ route('admin.anggota.index', ['tahun' => $tahunAktif]) }}" class="menu-card blue">
                <div class="menu-icon"><i class="fas fa-users-viewfinder"></i></div>
                <h2>Kelola Saldo Anggota</h2>
                <p>Input simpanan rutin, kelola saldo awal, dan pantau histori transaksi simpan-pinjam setiap anggota secara detail.</p>
                <div class="action-text">
                    Buka Manajemen Saldo <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <a href="{{ route('admin.laporan.bulanan') }}" class="menu-card orange">
                <div class="menu-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                <h2>Laporan Bulanan</h2>
                <p>Lihat rekapitulasi transaksi bulanan secara massal, cetak laporan keuangan, dan ekspor data anggota untuk keperluan audit.</p>
                <div class="action-text">
                    Lihat Laporan Bulanan <i class="fas fa-arrow-right"></i>
                </div>
            </a>

        </div>
    </main>

    <div id="modalTambah" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Tambah <em>Anggota</em></h2>
                <p style="color: var(--muted); font-size: 14px; margin-bottom: 28px;">Daftarkan anggota baru dan tentukan saldo awal jika ada.</p>
            </div>
            
            <form action="{{ route('admin.anggota.tambah') }}" method="POST">
                @csrf
                <div class="flex-row">
                    <div class="form-group">
                        <label>Nomor Induk (NIPP)</label>
                        <input type="text" name="nipp" placeholder="Contoh: 12345" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>Tahun Buku</label>
                        <input type="number" name="tahun" value="{{ $tahunAktif }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Lengkap Anggota</label>
                    <input type="text" name="users" placeholder="Masukkan nama lengkap sesuai sistem" required>
                </div>

                <div style="background: var(--surface); padding: 20px; border-radius: 16px; margin: 24px 0; border: 1px dashed var(--border);">
                    <span class="stat-label" style="margin-bottom: 16px; color: var(--blue);">Saldo Awal (Entry Baru)</span>
                    <div class="flex-row">
                        <div class="form-group">
                            <label>S. Pokok</label>
                            <input type="number" name="pokok" value="0">
                        </div>
                        <div class="form-group">
                            <label>S. Wajib</label>
                            <input type="number" name="wajib" value="0">
                        </div>
                    </div>
                    <div class="flex-row">
                        <div class="form-group">
                            <label>S. Sukarela</label>
                            <input type="number" name="sukarela" value="0">
                        </div>
                        <div class="form-group">
                            <label style="color: var(--orange);">Saldo Hutang</label>
                            <input type="number" name="saldo_hutang" value="0" style="color: var(--orange);">
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; margin-top: 8px;">
                    <button type="submit" class="btn-nav-add" style="flex: 2; height: 50px; justify-content: center;">
                        <i class="fas fa-save"></i> Simpan Data Anggota
                    </button>
                    <button type="button" onclick="document.getElementById('modalTambah').style.display='none'" 
                            style="flex: 1; height: 50px; background: none; border: 1.5px solid var(--border); border-radius: 12px; color: var(--muted); cursor: pointer; font-weight: 600;">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="bottom-bar"></div>

    <script>
        // Menutup modal saat mengklik area di luar konten modal
        window.onclick = function(event) {
            let modal = document.getElementById('modalTambah');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>