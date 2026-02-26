<!DOCTYPE html>
<html>
<head>
    <title>Login KOPEKA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="text-center">Login Anggota</h4>
                        <hr>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        <form action="/login" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Nama Anggota</label>
                                <input type="text" name="nama_anggota" class="form-control" placeholder="Masukkan Nama Lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label>NIPP</label>
                                <input type="text" name="nipp" class="form-control" placeholder="Contoh: 11366" required>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Masuk</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>