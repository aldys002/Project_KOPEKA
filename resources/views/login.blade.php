<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login KOPEKA - Rail Indonesia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --kai-blue: #003399; --kai-orange: #ED6B23; }
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Roboto, sans-serif; }
        .login-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .btn-primary { background-color: var(--kai-blue); border: none; border-radius: 10px; padding: 12px; transition: 0.3s; }
        .btn-primary:hover { background-color: #002673; transform: translateY(-2px); }
        .text-kai { color: var(--kai-blue); }
        .form-control { border-radius: 10px; padding: 12px; border: 1px solid #ddd; }
        .form-control:focus { border-color: var(--kai-blue); box-shadow: none; }
        .logo-section { text-align: center; margin-bottom: 25px; }
    </style>
</head>
<body class="d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card login-card p-2">
                    <div class="card-body p-4">
                        <div class="logo-section">
                            <i class="fas fa-train fa-3x text-kai mb-2"></i>
                            <h4 class="fw-bold text-kai mb-0">Login Anggota</h4>
                            <p class="text-muted small">Koperasi Karyawan Rail Indonesia</p>
                        </div>
                        
                        <hr class="mb-4 opacity-50">

                        {{-- Notifikasi Sukses Setelah Register --}}
                        @if(session('success'))
                            <div class="alert alert-success border-0 small shadow-sm mb-4">
                                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                            </div>
                        @endif

                        {{-- Notifikasi Error Login --}}
                        @if($errors->any())
                            <div class="alert alert-danger border-0 small shadow-sm mb-4">
                                <i class="fas fa-exclamation-triangle me-1"></i> {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('login.submit') }}" method="POST">
                            @csrf {{-- WAJIB: Keamanan CSRF Laravel --}}
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Nama Lengkap</label>
                                <input type="text" name="nama_anggota" class="form-control" placeholder="Sesuai KTP" required value="{{ old('nama_anggota') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">NIPP / NIK</label>
                                <input type="text" name="identity" class="form-control" placeholder="Masukkan Nomor Identitas" required value="{{ old('identity') }}">
                                <div class="form-text" style="font-size: 0.75rem;">Gunakan NIK jika Anda belum memiliki NIPP.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-bold">MASUK SEKARANG</button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="mb-0 small text-muted">Belum punya akun?</p>
                            <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: var(--kai-orange);">
                                DAFTAR ANGGOTA <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                        
                    </div>
                </div>
                <p class="text-center mt-4 text-muted" style="font-size: 0.8rem;">&copy; 2025 KOPEKA - IT Support System</p>
            </div>
        </div>
    </div>
</body>
</html>