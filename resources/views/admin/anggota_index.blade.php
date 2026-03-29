<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota {{ $tahunAktif }} - Admin KOPEKA</title>
    
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600&family=DM+Mono:wght@400;500&family=Fraunces:opsz,wght@9..144,300;9..144,400;9..144,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink:       #0A0E1A;
            --muted:     #7A849E;
            --border:    #E2E6F0;
            --surface:   #F6F8FC;
            --white:     #FFFFFF;
            --orange:    #F05A22;
            --blue:      #0033A0;
            --blue-dk:   #001A5E;
            --blue-lt:   rgba(0,51,160,0.07);
            --green:     #1BA46A;
            --red:       #E74C3C;
            --yellow-lt: #FEF9E7;
            --yellow:    #D4AC0D;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--surface);
            color: var(--ink);
            padding: 40px 24px;
            -webkit-font-smoothing: antialiased;
        }

        .container { max-width: 1300px; margin: 0 auto; }

        /* ── HEADER ── */
        .header-flex { 
            display: flex; 
            justify-content: space-between; 
            align-items: flex-end; 
            margin-bottom: 40px; 
            flex-wrap: wrap; 
            gap: 20px; 
        }

        .header-flex h1 { 
            font-family: 'Fraunces', serif; 
            font-size: 36px; 
            font-weight: 400; 
            margin-bottom: 8px;
        }
        .header-flex h1 em { font-style: italic; color: var(--blue); }

        .btn-back { 
            color: var(--blue); 
            text-decoration: none; 
            font-weight: 600; 
            font-size: 14px; 
            display: flex; 
            align-items: center; 
            gap: 8px; 
            padding: 10px 20px;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            background: var(--white);
            transition: 0.2s;
        }
        .btn-back:hover { border-color: var(--blue); background: var(--blue-lt); }

        /* ── SEARCH ── */
        .search-container { margin-bottom: 30px; position: relative; max-width: 450px; }
        .search-container i { position: absolute; left: 18px; top: 16px; color: var(--muted); }
        .search-input { 
            width: 100%; 
            padding: 14px 14px 14px 48px; 
            border: 1.5px solid var(--border); 
            border-radius: 16px; 
            outline: none; 
            font-size: 15px; 
            font-family: inherit;
            transition: 0.3s; 
        }
        .search-input:focus { border-color: var(--blue); box-shadow: 0 0 0 4px var(--blue-lt); }

        /* ── TABLE ── */
        .table-responsive { 
            background: var(--white); 
            border-radius: 24px; 
            border: 1.5px solid var(--border);
            overflow: hidden; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }
        table { width: 100%; border-collapse: collapse; min-width: 1000px; }
        
        th { 
            background-color: #fafbfc; 
            color: var(--muted); 
            font-family: 'DM Mono', monospace;
            font-size: 11px; 
            text-transform: uppercase; 
            letter-spacing: 1px;
            padding: 20px 24px;
            border-bottom: 1.5px solid var(--border);
            text-align: left;
        }

        td { padding: 18px 24px; border-bottom: 1px solid var(--border); font-size: 14.5px; }
        tr.out-row { background-color: #fcfcfd; }
        tr.out-row td { opacity: 0.6; }

        .nipp-badge { font-family: 'DM Mono', monospace; font-weight: 600; color: var(--blue); background: var(--blue-lt); padding: 4px 8px; border-radius: 6px; }
        
        .badge-status { 
            padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 700; 
            text-transform: uppercase; display: inline-block; margin-top: 4px;
        }
        .bg-success { background: #E6F6EC; color: var(--green); }
        .bg-danger { background: #FDEDEC; color: var(--red); }

        /* ── BUTTONS ── */
        .btn-group { display: flex; gap: 8px; }
        .btn-action { 
            width: 38px; height: 38px; border-radius: 10px; border: none; 
            cursor: pointer; display: flex; align-items: center; justify-content: center; 
            transition: 0.2s; font-size: 14px;
        }
        .btn-edit-id { background: var(--yellow-lt); color: var(--yellow); }
        .btn-edit-id:hover { background: #F9E79F; }
        .btn-status { background: var(--blue-lt); color: var(--blue); }
        .btn-aktif { background: #E6F6EC; color: var(--green); }
        .btn-delete { background: #FDEDEC; color: var(--red); }
        .btn-delete:hover { background: #FADBD8; }

        /* ── MODAL ── */
        .modal { display: none; position: fixed; inset: 0; background: rgba(10, 14, 26, 0.7); backdrop-filter: blur(4px); z-index: 2000; align-items: center; justify-content: center; }
        .modal-content { 
            background: var(--white); width: 100%; max-width: 420px; 
            border-radius: 24px; padding: 40px; position: relative; 
            animation: slideUp 0.3s ease-out;
        }
        @keyframes slideUp { from { opacity:0; transform: translateY(20px); } to { opacity:1; transform: translateY(0); } }

        .modal-header h2 { font-family: 'Fraunces', serif; font-size: 28px; font-weight: 400; margin-bottom: 20px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; color: var(--muted); margin-bottom: 8px; }
        .form-group input { 
            width: 100%; padding: 12px; border: 1.5px solid var(--border); 
            border-radius: 12px; font-family: inherit; outline: none; transition: 0.2s;
        }
        .form-group input:focus { border-color: var(--blue); }
        .form-group input:disabled { background: var(--surface); color: var(--muted); }

        .btn-save { 
            background: var(--blue); color: var(--white); width: 100%; 
            padding: 14px; border: none; border-radius: 12px; 
            font-weight: 600; cursor: pointer; margin-top: 10px; 
        }

        .alert-success {
            padding: 16px 24px; background: #E6F6EC; color: var(--green);
            border-radius: 16px; margin-bottom: 30px; border: 1px solid #D1F2DE;
            display: flex; align-items: center; gap: 12px; font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-flex">
        <div>
            <h1>Manajemen <em>Anggota</em></h1>
            <span style="font-family: 'DM Mono', monospace; font-size: 12px; background: var(--orange); color: white; padding: 5px 12px; border-radius: 20px;">
                TAHUN BUKU {{ $tahunAktif }}
            </span>
        </div>
        <a href="{{ route('admin.dashboard', ['tahun' => $tahunAktif]) }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
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
                    <th>Nama Anggota / NIK</th>
                    <th>Pokok</th>
                    <th>Wajib</th>
                    <th>Sukarela</th>
                    <th style="color: var(--green);">Total Simpanan</th>
                    <th style="color: var(--orange);">Hutang</th>
                    <th style="text-align: center;">Aksi</th>
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
                    <td><span class="nipp-badge">{{ $row->nipp }}</span></td>
                    <td>
                        <div style="font-weight: 600; color: var(--ink);">{{ $row->users }}</div>
                        <div style="font-size: 11px; color: var(--muted);">NIK: {{ $row->nik ?? '-' }}</div>
                        <span class="badge-status {{ $isOut ? 'bg-danger' : 'bg-success' }}">
                            {{ $isOut ? 'Keluar' : 'Aktif' }}
                        </span>
                    </td>
                    <td>{{ number_format($simpanan->pokok ?? 0, 0, ',', '.') }}</td>
                    <td>{{ number_format($simpanan->wajib ?? 0, 0, ',', '.') }}</td>
                    <td>{{ number_format($simpanan->sukarela ?? 0, 0, ',', '.') }}</td>
                    <td style="color: var(--green); font-weight: 600;">{{ number_format($simpanan->total_simpanan ?? 0, 0, ',', '.') }}</td>
                    <td style="color: var(--orange); font-weight: 600;">{{ number_format($hutang->saldo_hutang ?? 0, 0, ',', '.') }}</td>
                    <td>
                        <div class="btn-group" style="justify-content: center;">
                            <button class="btn-action btn-edit-id" title="Edit Nama/NIK" 
                                onclick="openEditModal({{ $row->id }}, '{{ $row->nipp }}', '{{ addslashes($row->users) }}', '{{ $row->nik }}')">
                                <i class="fas fa-user-edit"></i>
                            </button>

                            <form action="{{ route('admin.toggle.status', $row->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-action {{ $isOut ? 'btn-aktif' : 'btn-status' }}" title="Ubah Status">
                                    <i class="fas {{ $isOut ? 'fa-user-check' : 'fa-user-slash' }}"></i>
                                </button>
                            </form>

                            <form action="{{ route('admin.anggota.hapus', $row->id) }}" method="POST" onsubmit="return confirm('Hapus permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus Permanen">
                                    <i class="fas fa-trash-alt"></i>
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

<div id="modalEditIdentitas" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Identitas</h2>
        </div>
        
        <form action="{{ route('admin.anggota.update.identitas') }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="edit_id">
            
            <div class="form-group">
                <label>NIPP (Tidak Bisa Diubah)</label>
                <input type="text" id="edit_nipp" disabled>
            </div>

            <div class="form-group">
                <label>Nama Anggota</label>
                <input type="text" name="users" id="edit_nama" required>
            </div>

            <div class="form-group">
                <label>NIK</label>
                <input type="text" name="nik" id="edit_nik">
            </div>

            <button type="submit" class="btn-save">Simpan Perubahan</button>
        </form>

        <button onclick="closeModal()" style="width: 100%; background: none; border: none; color: var(--muted); margin-top: 15px; cursor: pointer; font-size: 13px;">Batal</button>
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

    function openEditModal(id, nipp, nama, nik) {
        document.getElementById('modalEditIdentitas').style.display = 'flex';
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nipp').value = nipp;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_nik').value = (nik === 'null' || nik === '') ? '' : nik;
    }

    function closeModal() { 
        document.getElementById('modalEditIdentitas').style.display = 'none'; 
    }
    
    window.onclick = function(event) {
        if (event.target == document.getElementById('modalEditIdentitas')) closeModal();
    }
</script>
</body>
</html>