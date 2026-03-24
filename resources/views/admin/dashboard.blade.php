<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - KOPEKA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; background-color: #f4f7f6; color: #2c3e50; }
        
        /* Badge & Header */
        h1 { font-weight: 800; margin-bottom: 5px; }
        .badge-info { background: #e67e22; color: white; padding: 5px 15px; border-radius: 5px; font-size: 14px; display: inline-block; margin-bottom: 20px; font-weight: bold; }
        .alert { padding: 15px; background: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb; }

        /* Filter Tahun */
        .filter-section { margin-bottom: 25px; display: flex; align-items: center; gap: 15px; background: white; padding: 15px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); width: fit-content; }
        select { padding: 8px 15px; border-radius: 5px; border: 2px solid #3498db; background: white; cursor: pointer; font-weight: bold; color: #3498db; outline: none; }

        /* Grid Statistik */
        .grid-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-top: 20px; }
        .card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 6px solid #2ecc71; transition: 0.3s; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
        .card.hutang { border-left-color: #e74c3c; }
        .card.total { border-left-color: #3498db; }
        .card.anggota { border-left-color: #f1c40f; }
        .card h3 { margin: 0; font-size: 12px; color: #7f8c8d; text-transform: uppercase; letter-spacing: 1px; }
        .card p { margin: 12px 0 0; font-size: 22px; font-weight: 800; color: #2c3e50; }
        .small-text { font-size: 12px; color: #95a5a6; font-weight: normal; }
        
        /* Menu Utama */
        .menu-box { margin-top: 30px; padding: 25px; background: white; border-radius: 12px; width: 400px; box-shadow: 0 4px 10px rgba(0,0,0,0.08); }
        .menu-box h3 { margin-top: 0; font-weight: 800; border-bottom: 2px solid #f4f7f6; padding-bottom: 10px; margin-bottom: 15px; }
        .btn-add { background: #27ae60; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; display: block; width: 100%; text-align: center; font-weight: bold; border: none; cursor: pointer; transition: 0.3s; margin-bottom: 15px; }
        .btn-add:hover { background: #219150; }
        .menu-list { list-style: none; padding: 0; margin: 0; }
        .menu-list li { margin-bottom: 12px; }
        .menu-list a { display: flex; align-items: center; gap: 10px; color: #34495e; text-decoration: none; font-weight: 600; padding: 8px 0; transition: 0.2s; }
        .menu-list a:hover { color: #3498db; transform: translateX(5px); }
        .btn-logout { margin-top: 15px; background: #ecf0f1; color: #c0392b; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold; width: 100%; transition: 0.3s; }
        .btn-logout:hover { background: #e74c3c; color: white; }

        /* Modal Styling */
        .modal { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); }
        .modal-content { background: white; margin: 5% auto; padding: 30px; width: 500px; border-radius: 15px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); position: relative; }
        .close-modal { position: absolute; right: 20px; top: 15px; font-size: 24px; cursor: pointer; color: #95a5a6; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px; }
        .form-group input { width: 100%; padding: 10px; border: 2px solid #eee; border-radius: 8px; box-sizing: border-box; outline: none; transition: 0.3s; }
        .form-group input:focus { border-color: #3498db; }
        .info-aktivasi { background: #fff9db; padding: 12px; border-radius: 8px; border-left: 4px solid #f1c40f; margin-bottom: 20px; font-size: 12px; color: #856404; }
        .row-flex { display: flex; gap: 15px; }
        .row-flex .form-group { flex: 1; }
    </style>
</head>
<body>

    <h1>Dashboard Ringkasan Koperasi</h1>

    @if(session('success'))
        <div class="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="badge-info">Periode Data: <strong>{{ $tahunAktif }}</strong></div>

    <div class="filter-section">
        <label for="pilihTahun" style="font-weight: bold;"><i class="fas fa-calendar-alt me-2"></i>Pilih Periode:</label>
        <select id="pilihTahun" onchange="window.location.href='/admin/dashboard?tahun=' + this.value">
            @foreach($daftarTahun as $th)
                <option value="{{ $th }}" {{ $tahunAktif == $th ? 'selected' : '' }}>
                    Tahun {{ $th }}
                </option>
            @endforeach
        </select>
    </div>
    
    <div class="grid-container">
        <div class="card anggota">
            <h3><i class="fas fa-users me-2"></i>Total Anggota</h3>
            <p>{{ $totalAnggota }} <span class="small-text">Orang</span></p>
            <div class="small-text" style="margin-top:8px; font-weight: bold;">
                <span style="color: #27ae60;">● {{ $anggotaAktif }} Aktif</span> | 
                <span style="color: #e74c3c;">● {{ $anggotaKeluar }} Keluar</span>
            </div>
        </div>

        <div class="card">
            <h3>Total Pokok</h3>
            <p>Rp {{ number_format($totalPokok, 0, ',', '.') }}</p>
        </div>
        <div class="card">
            <h3>Total Wajib</h3>
            <p>Rp {{ number_format($totalWajib, 0, ',', '.') }}</p>
        </div>
        <div class="card">
            <h3>Total Sukarela</h3>
            <p>Rp {{ number_format($totalSukarela, 0, ',', '.') }}</p>
        </div>

        <div class="card total">
            <h3>Total Simpanan ({{ $tahunAktif }})</h3>
            <p>Rp {{ number_format($totalSimpananKeseluruhan, 0, ',', '.') }}</p>
        </div>

        <div class="card hutang">
            <h3>Total Piutang (Hutang)</h3>
            <p>Rp {{ number_format($totalHutang, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="menu-box">
        <h3>Menu Utama Admin</h3>
        <button class="btn-add" onclick="document.getElementById('modalTambah').style.display='block'">
            <i class="fas fa-user-plus me-2"></i> Tambah Anggota & Saldo Awal
        </button>
        
        <ul class="menu-list">
            <li>
                <a href="{{ route('admin.anggota.index', ['tahun' => $tahunAktif]) }}">
                    <i class="fas fa-folder-open" style="color: #3498db;"></i> Kelola Saldo Anggota ({{ $tahunAktif }})
                </a>
            </li>
            <li>
                <a href="{{ route('admin.laporan.bulanan') }}">
                    <i class="fas fa-chart-bar" style="color: #95a5a6;"></i> Laporan Bulanan Massal
                </a>
            </li>
        </ul>
        
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt me-2"></i> Logout System
            </button>
        </form>
    </div>

    <div id="modalTambah" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="document.getElementById('modalTambah').style.display='none'">&times;</span>
            <h2 style="margin-top:0; font-weight: 800;">Daftar Anggota Baru</h2>
            <hr style="border: 1px solid #f4f7f6; margin-bottom: 20px;">

            <form action="{{ route('admin.anggota.tambah') }}" method="POST">
                @csrf
                <div class="row-flex">
                    <div class="form-group">
                        <label>NIPP</label>
                        <input type="text" name="nipp" placeholder="Contoh: 12345" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>Tahun Buku</label>
                        <input type="number" name="tahun" value="{{ $tahunAktif }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Lengkap Anggota</label>
                    <input type="text" name="users" placeholder="Masukkan nama lengkap" required>
                </div>

                <h4 style="margin: 20px 0 10px 0; color: #3498db; font-size: 14px; text-transform: uppercase;">
                    <i class="fas fa-money-bill-wave me-1"></i> Saldo Awal (Opsional)
                </h4>

                <div class="row-flex">
                    <div class="form-group">
                        <label>S. Pokok</label>
                        <input type="number" name="pokok" value="0">
                    </div>
                    <div class="form-group">
                        <label>S. Wajib</label>
                        <input type="number" name="wajib" value="0">
                    </div>
                </div>

                <div class="row-flex">
                    <div class="form-group">
                        <label>S. Sukarela</label>
                        <input type="number" name="sukarela" value="0">
                    </div>
                    <div class="form-group">
                        <label style="color: #e74c3c;">Saldo Hutang</label>
                        <input type="number" name="saldo_hutang" value="0">
                    </div>
                </div>

                <div class="info-aktivasi">
                    <i class="fas fa-key me-1"></i> 
                    Admin cukup daftarkan identitas. User akan melakukan <strong>aktivasi password</strong> secara mandiri.
                </div>

                <button type="submit" class="btn-add">
                    <i class="fas fa-save me-2"></i> Simpan Anggota & Saldo
                </button>
            </form>
        </div>
    </div>

    <script>
        window.onclick = function(event) {
            let modal = document.getElementById('modalTambah');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
 
</body>
</html>