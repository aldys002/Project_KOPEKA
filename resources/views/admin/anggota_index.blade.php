<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Anggota - Admin Kopeka</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 20px; background-color: #f4f7f6; }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        
        /* Table Styling */
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        th, td { padding: 12px 15px; border: 1px solid #e1e1e1; text-align: left; }
        th { background-color: #2c3e50; color: white; font-size: 12px; text-transform: uppercase; }
        tr:hover { background-color: #f1f9ff; }

        /* Button Styling */
        .btn { padding: 8px 12px; border-radius: 4px; font-size: 12px; cursor: pointer; border: none; font-weight: bold; text-decoration: none; display: inline-block; }
        .btn-edit { background-color: #f1c40f; color: #000; }
        .btn-back { color: #3498db; text-decoration: none; font-weight: bold; }
        
        /* Modal Styling */
        .modal { display: none; position: fixed; z-index: 999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); }
        .modal-content { background: white; margin: 5% auto; padding: 25px; width: 450px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .modal-header { border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .btn-save { background-color: #27ae60; color: white; width: 100%; padding: 12px; margin-top: 10px; font-size: 14px; }
        .close { float: right; font-size: 24px; cursor: pointer; color: #aaa; }
    </style>
</head>
<body>

    <div class="header-flex">
        <h1>Daftar Anggota & Saldo</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn-back">⬅ Kembali ke Dashboard</a>
    </div>

    @if(session('success'))
        <div style="padding: 15px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>NIPP</th>
                <th>Nama Anggota</th>
                <th>S. Pokok</th>
                <th>S. Wajib</th>
                <th>S. Sukarela</th>
                <th>Total Simpanan</th>
                <th>Hutang (2025)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($anggota as $row)
            <tr>
                <td><strong>{{ $row->nipp }}</strong></td>
                <td>{{ $row->nama_anggota }}</td>
                <td>{{ number_format($row->simpanan->pokok ?? 0, 0, ',', '.') }}</td>
                <td>{{ number_format($row->simpanan->wajib ?? 0, 0, ',', '.') }}</td>
                <td>{{ number_format($row->simpanan->sukarela ?? 0, 0, ',', '.') }}</td>
                <td style="color: #27ae60; font-weight: bold;">{{ number_format($row->simpanan->total_simpanan ?? 0, 0, ',', '.') }}</td>
                <td style="color: #e74c3c; font-weight: bold;">{{ number_format($row->hutang->saldo_hutang_2025 ?? 0, 0, ',', '.') }}</td>
                <td>
                    <button class="btn btn-edit" onclick="openModal('{{ $row->nipp }}', '{{ $row->nama_anggota }}', {{ $row->simpanan->pokok ?? 0 }}, {{ $row->simpanan->wajib ?? 0 }}, {{ $row->simpanan->sukarela ?? 0 }}, {{ $row->hutang->saldo_hutang_2025 ?? 0 }})">
                        ✏️ Edit Saldo
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div id="modalEdit" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-header">
                <h2 id="modalName">Nama Anggota</h2>
                <p id="modalNipp" style="color: #666;"></p>
            </div>

            <form action="{{ route('admin.simpanan.update') }}" method="POST">
                @csrf
                <input type="hidden" name="nipp" id="form_nipp_simpanan">
                <div class="form-group">
                    <label>Simpanan Pokok</label>
                    <input type="number" name="pokok" id="form_pokok">
                </div>
                <div class="form-group">
                    <label>Simpanan Wajib</label>
                    <input type="number" name="wajib" id="form_wajib">
                </div>
                <div class="form-group">
                    <label>Simpanan Sukarela</label>
                    <input type="number" name="sukarela" id="form_sukarela">
                </div>
                <button type="submit" class="btn btn-save">Update Data Simpanan</button>
            </form>

            <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

            <form action="{{ route('admin.hutang.update') }}" method="POST">
                @csrf
                <input type="hidden" name="nipp" id="form_nipp_hutang">
                <div class="form-group">
                    <label>Saldo Hutang (2025)</label>
                    <input type="number" name="saldo_hutang_2025" id="form_hutang">
                </div>
                <button type="submit" class="btn btn-save" style="background-color: #e67e22;">Update Data Hutang</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(nipp, nama, pokok, wajib, sukarela, hutang) {
            document.getElementById('modalEdit').style.display = 'block';
            document.getElementById('modalName').innerText = nama;
            document.getElementById('modalNipp').innerText = 'NIPP: ' + nipp;
            
            // Set values to forms
            document.getElementById('form_nipp_simpanan').value = nipp;
            document.getElementById('form_nipp_hutang').value = nipp;
            document.getElementById('form_pokok').value = pokok;
            document.getElementById('form_wajib').value = wajib;
            document.getElementById('form_sukarela').value = sukarela;
            document.getElementById('form_hutang').value = hutang;
        }

        function closeModal() {
            document.getElementById('modalEdit').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('modalEdit')) {
                closeModal();
            }
        }
    </script>
</body>
</html>