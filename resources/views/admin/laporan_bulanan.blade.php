<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan - Admin KOPEKA</title>
    
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
            --blue-lt:   rgba(0,51,160,0.07);
            --green:     #1BA46A;
            --green-lt:  #E6F6EC;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--surface);
            color: var(--ink);
            padding: 40px 24px;
            -webkit-font-smoothing: antialiased;
        }

        .container { max-width: 1200px; margin: 0 auto; }

        /* ── HEADER ── */
        .btn-back { 
            color: var(--blue); text-decoration: none; font-weight: 600; font-size: 14px; 
            display: inline-flex; align-items: center; gap: 8px; margin-bottom: 24px;
        }

        .card { 
            background: var(--white); border-radius: 24px; border: 1.5px solid var(--border);
            padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        }

        .header-area { 
            display: flex; justify-content: space-between; align-items: flex-start; 
            margin-bottom: 32px; flex-wrap: wrap; gap: 24px; 
        }

        .title-section h1 { font-family: 'Fraunces', serif; font-size: 32px; font-weight: 400; margin-bottom: 4px; }
        .title-section p { color: var(--muted); font-size: 15px; }

        /* ── ACTIONS (Filters & Export) ── */
        .actions-wrapper {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-box { 
            display: flex; gap: 12px; background: #fafbfc; padding: 12px 20px; 
            border-radius: 16px; border: 1.5px solid var(--border); align-items: center;
        }
        .form-select { 
            padding: 8px 12px; border: 1.5px solid var(--border); border-radius: 10px; 
            font-family: inherit; font-size: 14px; outline: none; background: white; cursor: pointer;
        }

        /* TOMBOL EXCEL BARU */
        .btn-export-excel {
            background: var(--green);
            color: white;
            padding: 12px 20px;
            border-radius: 16px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
            border: none;
            box-shadow: 0 4px 12px rgba(27, 164, 106, 0.2);
        }
        .btn-export-excel:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(27, 164, 106, 0.3);
            filter: brightness(1.1);
        }

        .search-container { margin-bottom: 24px; position: relative; max-width: 400px; }
        .search-container i { position: absolute; left: 16px; top: 14px; color: var(--muted); }
        .search-input { 
            width: 100%; padding: 12px 12px 12px 44px; border: 1.5px solid var(--border); 
            border-radius: 14px; outline: none; font-family: inherit; transition: 0.2s;
        }
        .search-input:focus { border-color: var(--blue); }

        /* ── TABLE ── */
        .alert-info { 
            background: var(--blue-lt); color: var(--blue); padding: 16px 20px; 
            border-radius: 14px; margin-bottom: 24px; font-size: 14px; display: flex; align-items: center; gap: 10px;
        }

        .table-responsive { border-radius: 16px; border: 1.5px solid var(--border); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; background: white; }
        
        th { 
            background: #fafbfc; padding: 16px 20px; font-family: 'DM Mono', monospace; 
            font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--muted);
            border-bottom: 1.5px solid var(--border); text-align: left;
        }

        td { padding: 14px 20px; border-bottom: 1px solid var(--border); }
        
        .nipp-badge { font-family: 'DM Mono', monospace; font-size: 11px; color: var(--muted); }

        /* ── MONEY INPUT ── */
        .input-money { 
            width: 100%; padding: 10px 12px; border: 1.5px solid var(--border); 
            border-radius: 8px; text-align: right; font-family: 'DM Mono', monospace; 
            font-size: 14px; transition: 0.2s; background: #fdfdfd;
        }
        .input-money:focus { 
            background: white; border-color: var(--green); outline: none; 
            box-shadow: 0 0 0 4px rgba(27, 164, 106, 0.1); 
        }
        .input-debt { border-color: #FFE5D9; background: #FFF9F6; }
        .input-debt:focus { border-color: var(--orange); box-shadow: 0 0 0 4px rgba(240, 90, 34, 0.1); }

        /* ── BUTTON SAVE ── */
        .btn-save { 
            background: var(--blue); color: var(--white); padding: 18px; 
            border: none; border-radius: 16px; cursor: pointer; font-size: 15px; 
            font-weight: 600; width: 100%; margin-top: 32px; transition: 0.3s;
            display: flex; align-items: center; justify-content: center; gap: 12px;
            box-shadow: 0 10px 20px rgba(0, 51, 160, 0.15);
        }
        .btn-save:hover { opacity: 0.9; transform: translateY(-2px); }
        
        .no-result { display: none; text-align: center; padding: 40px; color: var(--muted); font-style: italic; }
    </style>
</head>
<body>

<div class="container">
    <a href="{{ route('admin.dashboard', ['tahun' => $tahunAktif]) }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>

    <div class="card">
        <div class="header-area">
            <div class="title-section">
                <h1>Laporan <em>Bulanan</em></h1>
                <p>Input data simpanan dan cicilan anggota periode ini.</p>
            </div>

            <div class="actions-wrapper">
                <a href="{{ route('admin.export.simpanan', ['tahun' => $tahunAktif]) }}" class="btn-export-excel">
                    <i class="fas fa-file-excel"></i> Export {{ $tahunAktif }}
                </a>

                <div class="filter-box">
                    <i class="fas fa-calendar-alt" style="color: var(--blue);"></i>
                    <form action="{{ route('admin.laporan.bulanan') }}" method="GET" style="display: flex; gap: 8px;">
                        <select name="bulan" class="form-select" onchange="this.form.submit()">
                            @for($m=1; $m<=12; $m++)
                                <option value="{{ $m }}" {{ (int)$bulanAktif == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month((int)$m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                        <select name="tahun" class="form-select" onchange="this.form.submit()">
                            @foreach(range(2025, date('Y') + 2) as $th)
                                <option value="{{ $th }}" {{ (int)$tahunAktif == $th ? 'selected' : '' }}>
                                    {{ $th }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <div class="search-container">
            <i class="fas fa-search"></i>
            <input type="text" id="inputCariAnggota" onkeyup="cariAnggota()" 
                class="search-input" placeholder="Cari NIPP atau nama anggota...">
        </div>

        <div class="alert-info">
            <i class="fas fa-info-circle"></i> 
            <span>Mengupdate data untuk periode <strong>{{ \Carbon\Carbon::create()->month((int)$bulanAktif)->translatedFormat('F') }} {{ $tahunAktif }}</strong></span>
        </div>

        @if(session('success'))
            <div style="background: var(--green-lt); color: var(--green); padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 500;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.laporan.simpan') }}" method="POST">
            @csrf
            <input type="hidden" name="tahun" value="{{ $tahunAktif }}">
            <input type="hidden" name="bulan" value="{{ $bulanAktif }}">

            <div class="table-responsive">
                <table id="transaksiTable">
                    <thead>
                        <tr>
                            <th style="width: 300px;">Anggota</th>
                            <th>Pokok</th>
                            <th>Wajib</th>
                            <th>Sukarela</th>
                            <th style="color: var(--orange);">Saldo Hutang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggota as $u)
                        @php $t = $transaksi[$u->id] ?? null; @endphp
                        <tr class="data-row">
                            <td>
                                <div class="nama-cell" style="font-weight: 600; color: var(--ink);">{{ $u->users }}</div>
                                <span class="nipp-badge nipp-cell">{{ $u->nipp }}</span>
                            </td>
                            <td>
                                <input type="number" name="data[{{ $u->id }}][pokok]" 
                                    class="input-money" value="{{ $t ? (int)$t->pokok : 0 }}" min="0">
                            </td>
                            <td>
                                <input type="number" name="data[{{ $u->id }}][wajib]" 
                                    class="input-money" value="{{ $t ? (int)$t->wajib : 0 }}" min="0">
                            </td>
                            <td>
                                <input type="number" name="data[{{ $u->id }}][sukarela]" 
                                    class="input-money" value="{{ $t ? (int)$t->sukarela : 0 }}" min="0">
                            </td>
                            <td>
                                <input type="number" name="data[{{ $u->id }}][saldo_hutang]" 
                                    class="input-money input-debt" value="{{ $t ? (int)$t->saldo_hutang : 0 }}" min="0">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="noData" class="no-result">
                    <i class="fas fa-search-minus"></i> Anggota tidak ditemukan...
                </div>
            </div>

            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> SIMPAN DATA {{ strtoupper(\Carbon\Carbon::create()->month((int)$bulanAktif)->translatedFormat('F')) }}
            </button>
        </form>
    </div>
</div>

<script>
    function cariAnggota() {
        let input = document.getElementById("inputCariAnggota").value.toUpperCase();
        let table = document.getElementById("transaksiTable");
        let tr = table.getElementsByClassName("data-row");
        let noData = document.getElementById("noData");
        let count = 0;

        for (let i = 0; i < tr.length; i++) {
            let tdNipp = tr[i].getElementsByClassName("nipp-cell")[0];
            let tdNama = tr[i].getElementsByClassName("nama-cell")[0];
            
            if (tdNipp || tdNama) {
                let textNipp = tdNipp.textContent || tdNipp.innerText;
                let textNama = tdNama.textContent || tdNama.innerText;
                
                if (textNipp.toUpperCase().indexOf(input) > -1 || textNama.toUpperCase().indexOf(input) > -1) {
                    tr[i].style.display = "";
                    count++;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
        noData.style.display = (count === 0) ? "block" : "none";
    }
</script>

</body>
</html>