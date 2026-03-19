<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan - KOPEKA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; background-color: #f4f7f6; color: #2c3e50; }
        .container { max-width: 1200px; margin: 0 auto; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-top: 5px solid #3498db; }
        .header-area { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
        .title-section h1 { margin: 0; font-size: 24px; color: #2c3e50; }
        .title-section p { margin: 5px 0 0; color: #7f8c8d; font-size: 14px; }

        .controls-row { display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
       .search-container { margin-bottom: 20px; position: relative; max-width: 500px; }
        .search-container i { position: absolute; left: 15px; top: 12px; color: #bdc3c7; }
        .search-input { 
            width: 100%; padding: 10px 10px 10px 40px; border: 2px solid #3498db; 
            border-radius: 25px; outline: none; box-sizing: border-box; transition: 0.3s; 
            font-size: 14px;
        }
        .search-input:focus { box-shadow: 0 0 8px rgba(52, 152, 219, 0.3); }

        .filter-box { display: flex; gap: 10px; background: #ebf5fb; padding: 8px 15px; border-radius: 25px; align-items: center; }
        .form-control { padding: 8px 12px; border: 1px solid #dcdde1; border-radius: 6px; font-size: 14px; outline: none; }

        .alert-info { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #17a2b8; font-size: 14px; }

        .table-responsive { overflow-x: auto; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; min-width: 800px; }
        th { background-color: #f8f9fa; color: #34495e; font-weight: bold; text-transform: uppercase; font-size: 11px; padding: 15px; border-bottom: 2px solid #dee2e6; text-align: left; }
        td { padding: 12px 15px; border-bottom: 1px solid #eee; vertical-align: middle; }
        tr:hover { background-color: #fdfdfd; }
        .no-result { display: none; text-align: center; padding: 20px; color: #e74c3c; font-weight: bold; background: #fff; border: 1px solid #eee; }

        .input-money { width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; text-align: right; font-family: 'Courier New', Courier, monospace; font-weight: bold; }
        .input-money:focus { background-color: #fff; border-color: #2ecc71; box-shadow: 0 0 5px rgba(46, 204, 113, 0.3); outline: none; }

        .btn-save { background: #27ae60; color: white; padding: 15px 30px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; width: 100%; margin-top: 25px; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .btn-save:hover { background: #219150; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }

        .btn-back { text-decoration: none; color: #3498db; font-size: 14px; font-weight: bold; display: inline-flex; align-items: center; gap: 5px; margin-bottom: 20px; }
        .nipp-badge { background: #f1f2f6; color: #57606f; padding: 2px 6px; border-radius: 4px; font-size: 11px; }
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
                <h1><i class="fas fa-edit text-primary"></i> Laporan Bulanan & Setoran</h1>
                <p>Input data simpanan dan cicilan anggota per periode bulan.</p>
            </div>

            <div class="filter-box">
                <i class="fas fa-calendar-alt text-primary"></i>
                <form action="{{ route('admin.laporan.bulanan') }}" method="GET" style="display: flex; gap: 10px;">
                    <select name="bulan" class="form-control" onchange="this.form.submit()">
                        @for($m=1; $m<=12; $m++)
                            <option value="{{ $m }}" {{ (int)$bulanAktif == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month((int)$m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="tahun" class="form-control" onchange="this.form.submit()">
                        @foreach(range(2025, date('Y') + 5) as $th)
                            <option value="{{ $th }}" {{ (int)$tahunAktif == $th ? 'selected' : '' }}>
                                Tahun {{ $th }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="search-container">
            <i class="fas fa-search"></i>
            <input type="text" id="inputCariAnggota" onkeyup="cariAnggota()" 
                class="search-input" placeholder="Cari NIPP atau nama anggota...">
        </div>

        <div class="alert-info">
            <i class="fas fa-info-circle"></i> 
            <strong>Informasi:</strong> Data bulan <strong>{{ \Carbon\Carbon::create()->month((int)$bulanAktif)->translatedFormat('F') }} {{ $tahunAktif }}</strong> akan diupdate.
        </div>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
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
                            <th>Identitas Anggota</th>
                            <th width="160">Pokok (Rp)</th>
                            <th width="160">Wajib (Rp)</th>
                            <th width="160">Sukarela (Rp)</th>
                            <th width="160">Saldo Hutang (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggota as $u)
                        @php $t = $transaksi[$u->id] ?? null; @endphp
                        <tr class="data-row">
                            <td class="nama-wrapper">
                                <div class="nama-cell" style="font-weight: bold; color: #2c3e50;">{{ $u->users }}</div>
                                <span class="nipp-badge nipp-cell">NIPP: {{ $u->nipp }}</span>
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
                                    class="input-money" value="{{ $t ? (int)$t->saldo_hutang : 0 }}" min="0" 
                                    style="background-color: #fff9e6; border-color: #f1c40f;">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="noData" class="no-result">
                    <i class="fas fa-search-minus"></i> Data anggota tidak ditemukan...
                </div>
            </div>

            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> SIMPAN SEMUA DATA BULAN {{ strtoupper(\Carbon\Carbon::create()->month((int)$bulanAktif)->translatedFormat('F')) }}
            </button>
        </form>
    </div>
</div>

<script>
    function filterTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toUpperCase();
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
                
                if (textNipp.toUpperCase().indexOf(filter) > -1 || textNama.toUpperCase().indexOf(filter) > -1) {
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