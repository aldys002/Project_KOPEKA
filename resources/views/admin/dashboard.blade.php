<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin - KOPEKA</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; background-color: #f4f7f6; }
        
        /* Navigasi Tahun */
        .year-nav { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
        .year-btn { 
            padding: 10px 20px; background: white; border: 2px solid #3498db; 
            color: #3498db; text-decoration: none; border-radius: 25px; 
            font-weight: bold; transition: 0.3s;
        }
        .year-btn.active { background: #3498db; color: white; }
        .year-btn:hover { background: #2980b9; color: white; }

        /* Grid Statistik */
        .grid-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 5px solid #2ecc71; }
        .card.hutang { border-left-color: #e74c3c; }
        .card.total { border-left-color: #3498db; }
        .card.anggota { border-left-color: #f1c40f; }
        .card h3 { margin: 0; font-size: 13px; color: #7f8c8d; text-transform: uppercase; }
        .card p { margin: 10px 0 0; font-size: 18px; font-weight: bold; color: #2c3e50; }
        .small-text { font-size: 11px; color: #95a5a6; font-weight: normal; }
        
        /* Menu & Modal */
        .menu-box { margin-top: 30px; padding: 20px; background: white; border-radius: 8px; width: fit-content; min-width: 350px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .btn-add { background: #27ae60; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; display: inline-block; margin-bottom: 10px; font-weight: bold; border: none; cursor: pointer; }
        .btn-logout { margin-top: 20px; background: #95a5a6; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-weight: bold; }

        /* Modal Styling */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
        .modal-content { background: white; margin: 10% auto; padding: 25px; width: 400px; border-radius: 10px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        
        .badge-info { background: #e67e22; color: white; padding: 5px 15px; border-radius: 5px; font-size: 16px; display: inline-block; margin-bottom: 10px; }
        .alert { padding: 15px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <h1>Dashboard Ringkasan Koperasi</h1>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <div class="badge-info">Periode Data: <strong>{{ $tahunAktif }}</strong></div>

    <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
    <label for="pilihTahun" style="font-weight: bold; color: #2c3e50;">Pilih Periode:</label>
    <select id="pilihTahun" onchange="window.location.href='/admin/dashboard?tahun=' + this.value" 
        style="padding: 8px 15px; border-radius: 5px; border: 2px solid #3498db; background: white; cursor: pointer; font-weight: bold; color: #3498db;">
        @foreach($daftarTahun as $th)
            <option value="{{ $th }}" {{ $tahunAktif == $th ? 'selected' : '' }}>
                Tahun {{ $th }}
            </option>
        @endforeach
    </select>
</div>
    
    <div class="grid-container">
        <div class="card anggota">
            <h3>Total Anggota</h3>
            <p>{{ $totalAnggota }} <span class="small-text">Orang</span></p>
            <div class="small-text" style="margin-top:5px;">
                <span style="color: #27ae60;">● {{ $anggotaAktif }} Aktif</span> | 
                <span style="color: #e74c3c;">● {{ $anggotaKeluar }} Out</span>
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
            <h3>Total Simpanan Keseluruhan</h3>
            <p>Rp {{ number_format($totalSimpananKeseluruhan, 0, ',', '.') }}</p>
        </div>

        <div class="card hutang">
            <h3>Total Piutang (Hutang)</h3>
            <p>Rp {{ number_format($totalHutang, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="menu-box">
        <h3>Menu Utama</h3>
        <hr>
        <button class="btn-add" onclick="document.getElementById('modalTambah').style.display='block'">
            + Tambah Anggota Baru
        </button>
        
        <ul style="line-height: 2.5; list-style: none; padding: 0;">
    <li>
        <a href="{{ route('admin.anggota.index', ['tahun' => $tahunAktif]) }}" style="font-weight: bold; color: #2980b9; text-decoration: none;">
            📂 Kelola Saldo Anggota ({{ $tahunAktif }})
        </a>
    </li>
    <li>
       <a href="{{ route('admin.laporan.bulanan') }}" style="color: #7f8c8d; text-decoration: none;">
    📊 Laporan Bulanan
</a>
    </li>
</ul>
        
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Logout System</button>
        </form>
    </div>

    <div id="modalTambah" class="modal">
        <div class="modal-content">
            <span style="float:right; cursor:pointer; font-size:20px;" onclick="document.getElementById('modalTambah').style.display='none'">&times;</span>
            <h2 style="margin-top:0;">Tambah Anggota</h2>
            <form action="{{ route('admin.anggota.tambah') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>NIPP</label>
                    <input type="text" name="nipp" placeholder="Contoh: 54321" required>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="users" placeholder="Nama Anggota" required>
                </div>
                <div class="form-group">
                    <label>Password Akun</label>
                    <input type="password" name="password" value="kai123" required>
                    <small style="color: gray;">Default: kai123</small>
                </div>
                <button type="submit" class="btn-add" style="width:100%;">Simpan Anggota Baru</button>
            </form>
        </div>
    </div>

    <script>
        // Tutup modal kalau klik di luar area modal
        window.onclick = function(event) {
            if (event.target == document.getElementById('modalTambah')) {
                document.getElementById('modalTambah').style.display = "none";
            }
        }
    </script>

</body>
</html>