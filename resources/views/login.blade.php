<!DOCTYPE html>
<html>
<head>
    <title>Login KOPEKA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --kai-blue: #003399; --kai-orange: #ED6B23; }
        .btn-primary { background-color: var(--kai-blue); border: none; }
        .btn-primary:hover { background-color: #002673; }
        .text-kai { color: var(--kai-blue); }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow border-0" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h4 class="text-center fw-bold text-kai">Login Anggota</h4>
                        <p class="text-center text-muted small">Koperasi Karyawan Rail Indonesia</p>
                        <hr>

                        @if(session('success'))
                            <div class="alert alert-success small">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger small">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="/login" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Nama Anggota</label>
                                <input type="text" name="nama_anggota" class="form-control" placeholder="Masukkan Nama Lengkap" required value="{{ old('nama_anggota') }}">
                            </div>
                           <div class="mb-3">
                                <label class="form-label small fw-bold">NIPP / NIK</label>
                                <input type="text" name="identity" class="form-control" placeholder="Masukkan NIPP atau NIK" required value="{{ old('identity') }}">
                                <small class="text-muted" style="font-size: 0.75rem;">Gunakan NIK jika Anda belum memiliki NIPP.</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">MASUK</button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="mb-0 small text-muted">Belum punya akun atau anggota baru?</p>
                            <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #ED6B23;">
                                DAFTAR SEKARANG <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                        
                    </div>
                </div>
                <p class="text-center mt-3 text-muted" style="font-size: 0.8rem;">&copy; 2025 KOPEKA - IT Support</p>
            </div>
        </div>
    </div>
</body>
</html>