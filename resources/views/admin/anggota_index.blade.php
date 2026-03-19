<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota {{ $tahunAktif }} - Admin Kopeka</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 20px; background-color: #f4f7f6; }
        .container { max-width: 1300px; margin: 0 auto; }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px; }
        .search-container { margin-bottom: 20px; position: relative; max-width: 500px; }
        .search-container i { position: absolute; left: 15px; top: 12px; color: #bdc3c7; }
        .search-input { width: 100%; padding: 10px 10px 10px 40px; border: 2px solid #3498db; border-radius: 25px; outline: none; box-sizing: border-box; transition: 0.3s; font-size: 14px; }
        .table-responsive { overflow-x: auto; background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; min-width: 1000px; }
        th, td { padding: 12px 15px; border: 1px solid #e1e1e1; text-align: left; }
        th { background-color: #2c3e50; color: white; font-size: 12px; text-transform: uppercase; }
        tr.out-row { background-color: #fff5f5; opacity: 0.8; } 
        .btn { padding: 8px 12px; border-radius: 4px; font-size: 11px; cursor: pointer; border: none; font-weight: bold; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; }
        .btn-edit { background-color: #f1c40f; color: #000; }
        .btn-status { background-color: #34495e; color: white; }
        .btn-aktif { background-color: #2ecc71; color: white; }
        .btn-delete { background-color: #e74c3c; color: white; }
        .btn-back { color: #3498db; border: 2px solid #3498db; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; }
        .badge-status { padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; }
        .bg-success { background: #d4edda; color: #155724; }
        .bg-danger { background: #f8d7da; color: #721c24; }
        .modal { display: none; position: fixed; z-index: 999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); }
        .modal-content { background: white; margin: 2% auto; padding: 25px; width: 450px; border-radius: 10px; position: relative; }
        .form-group { margin-bottom: 12px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .btn-save { background-color: #27ae60; color: white; width: 100%; padding: 12px; margin-top: 10px; cursor: pointer; border: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-flex">
        <div>
            <h1 style="margin:0;"><i class="fas fa-users-cog"></i> Manajemen Anggota</h1>
            <span style="background: #e67e22; color: white; padding: 3px 10px; border-radius: 15px; font-size: 14px;">Tahun Buku: {{ $tahunAktif }}</span>
        </div>
        <a href="{{ route('admin.dashboard', ['tahun' => $tahunAktif]) }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div style="padding: 15px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px; border-left: 5px solid #28a745;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="search-container">
        <i class="fas fa-search"></i>
        <input type="text" id="inputCariAnggota" onkeyup="cariAnggota()" class="search-input" placeholder="Cari NIPP atau nama anggota...">
    </div>

    <div class="table-responsive">
        <table id="tabelAnggota">
            <thead>
                <tr>
                    <th>NIPP</th>
                    <th>Nama Anggota</th>
                    <th>S. Pokok</th>
                    <th>S. Wajib</th>
                    <th>S. Sukarela</th>
                    <th>Total Simpanan</th>
                    <th>Saldo Hutang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($anggota as $row)
                @php
                    $simpanan = $row->simpanans->first();
                    $hutang = $row->hutangs->first();
                    $isOut = $row->status == 'keluar';
                @endphp
                <tr class="data-row {{ $isOut ? 'out-row' : '' }}">
                    <td class="nipp-cell"><strong>{{ $row->nipp }}</strong></td>
                    <td class="nama-cell">
                        <div style="font-weight: bold;">{{ $row->users }}</div>
                        <span class="badge-status {{ $isOut ? 'bg-danger' : 'bg-success' }}">
                            {{ $isOut ? 'Keluar' : 'Aktif' }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($simpanan->pokok ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($simpanan->wajib ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($simpanan->sukarela ?? 0, 0, ',', '.') }}</td>
                    <td style="color: #27ae60; font-weight: bold;">Rp {{ number_format($simpanan->total_simpanan ?? 0, 0, ',', '.') }}</td>
                    <td style="color: #e74c3c; font-weight: bold;">Rp {{ number_format($hutang->saldo_hutang ?? 0, 0, ',', '.') }}</td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <button class="btn btn-edit" onclick="openModal('{{ $row->nipp }}', '{{ addslashes($row->users) }}', {{ $simpanan->pokok ?? 0 }}, {{ $simpanan->wajib ?? 0 }}, {{ $simpanan->sukarela ?? 0 }}, {{ $hutang->saldo_hutang ?? 0 }})">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form action="{{ route('admin.toggle.status', $row->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn {{ $isOut ? 'btn-aktif' : 'btn-status' }}">
                                    <i class="fas {{ $isOut ? 'fa-user-check' : 'fa-user-slash' }}"></i>
                                </button>
                            </form>

                            <form action="{{ route('admin.anggota.hapus', $row->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Menghapus anggota akan menghapus seluruh saldo & riwayat bulanan secara permanen! Lanjutkan?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL EDIT SALDO --}}
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <span style="float:right; cursor:pointer; font-size:24px;" onclick="closeModal()">&times;</span>
        <h2 id="modalName">Nama Anggota</h2>
        <p id="modalNipp" style="color: #666;"></p>
        
        <form action="{{ route('admin.simpanan.update') }}" method="POST">
            @csrf
            <input type="hidden" name="nipp" id="form_nipp_simpanan">
            <input type="hidden" name="tahun" value="{{ $tahunAktif }}">
            <div class="form-group">
                <label>Pokok</label>
                <input type="number" name="pokok" id="form_pokok">
            </div>
            <div class="form-group">
                <label>Wajib</label>
                <input type="number" name="wajib" id="form_wajib">
            </div>
            <div class="form-group">
                <label>Sukarela</label>
                <input type="number" name="sukarela" id="form_sukarela">
            </div>
            <button type="submit" class="btn btn-save">Update Simpanan</button>
        </form>

        <hr style="margin:20px 0; border:1px dashed #eee;">

        <form action="{{ route('admin.hutang.update') }}" method="POST">
            @csrf
            <input type="hidden" name="nipp" id="form_nipp_hutang">
            <input type="hidden" name="tahun" value="{{ $tahunAktif }}">
            <div class="form-group">
                <label>Saldo Hutang Saat Ini</label>
                <input type="number" name="saldo_hutang" id="form_hutang">
            </div>
            <button type="submit" class="btn btn-save" style="background: #e67e22;">Update Hutang</button>
        </form>
    </div>
</div>

<script>
    function cariAnggota() {
        let input = document.getElementById("inputCariAnggota").value.toUpperCase();
        let rows = document.getElementsByClassName("data-row");
        for (let i = 0; i < rows.length; i++) {
            let txt = rows[i].innerText.toUpperCase();
            rows[i].style.display = txt.indexOf(input) > -1 ? "" : "none";
        }
    }
    function openModal(nipp, nama, p, w, s, h) {
        document.getElementById('modalEdit').style.display = 'block';
        document.getElementById('modalName').innerText = nama;
        document.getElementById('modalNipp').innerText = 'NIPP: ' + nipp;
        document.getElementById('form_nipp_simpanan').value = nipp;
        document.getElementById('form_nipp_hutang').value = nipp;
        document.getElementById('form_pokok').value = p;
        document.getElementById('form_wajib').value = w;
        document.getElementById('form_sukarela').value = s;
        document.getElementById('form_hutang').value = h;
    }
    function closeModal() { document.getElementById('modalEdit').style.display = 'none'; }
</script>
</body>
</html>