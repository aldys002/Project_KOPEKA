<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Anggota - Admin Kopeka</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 13px; }
        .btn-edit { background-color: #ffc107; color: black; }
        .btn-delete { background-color: #dc3545; color: white; }
        .success { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Manajemen Anggota</h1>
    <a href="{{ route('admin.dashboard') }}">⬅ Kembali ke Dashboard</a>
    
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>NIPP</th>
                <th>Nama Anggota</th>
                <th>NIK</th>
                <th>Simpanan (Total)</th>
                <th>Hutang (2025)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($anggota as $row)
            <tr>
                <td>{{ $row->nipp }}</td>
                <td>{{ $row->nama_anggota }}</td>
                <td>{{ $row->nik }}</td>
                <td>
                    {{-- Kita panggil relasi simpanan yang sudah dibuat di Model User --}}
                    Rp {{ number_format($row->simpanan->total_simpanan ?? 0, 0, ',', '.') }}
                </td>
                <td>
                    Rp {{ number_format($row->hutang->saldo_hutang_2025 ?? 0, 0, ',', '.') }}
                </td>
                <td>
                    <a href="#" class="btn btn-edit">Edit Saldo</a>
                    <form action="#" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>