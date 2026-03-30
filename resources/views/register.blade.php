<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Anggota - KOPEKA RAIL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --kai-blue: #003399; --kai-orange: #ED6B23; }
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .register-card { border: none; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); overflow: hidden; }
        .card-header-kai { background: var(--kai-blue); color: white; padding: 30px; text-align: center; }
        .btn-kai { background: var(--kai-orange); color: white; border-radius: 50px; font-weight: bold; padding: 12px; transition: 0.3s; border: none; }
        .btn-kai:hover { background: #d45a1a; transform: translateY(-2px); color: white; }
        .form-control { border-radius: 10px; padding: 12px; border: 1px solid #ddd; }
        .form-control:focus { border-color: var(--kai-blue); box-shadow: none; }
        .input-group-text { border-radius: 10px 0 0 10px; background-color: #f8f9fa; }
        .form-identity { border-radius: 0 10px 10px 0 !important; }
        
        /* Style Tambahan untuk Validasi */
        .is-invalid { border-color: #dc3545 !important; }
        .password-requirements { font-size: 0.75rem; color: #6c757d; margin-top: 5px; }
        .requirement.valid { color: #198754; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card register-card">
                    <div class="card-header-kai">
                        <i class="fas fa-user-shield fa-3x mb-3"></i>
                        <h4 class="mb-0 fw-bold">Aktivasi Akun Anggota</h4>
                        <p class="small mb-0 opacity-75">Koperasi Pegawai Kereta Api (KOPEKA)</p>
                    </div>
                    <div class="card-body p-4 p-md-5 bg-white">
                        
                        {{-- Alert Error Umum --}}
                        @if($errors->has('error'))
                            <div class="alert alert-danger border-0 small shadow-sm mb-4">
                                <i class="fas fa-exclamation-triangle me-2"></i> {{ $errors->first('error') }}
                            </div>
                        @endif

                        {{-- Form Register/Aktivasi --}}
                        <form action="{{ route('register.submit') }}" method="POST" id="registerForm">
                            @csrf 

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase">Nama Lengkap (Sesuai Data Koperasi)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" name="nama_anggota" class="form-control @error('nama_anggota') is-invalid @enderror" 
                                           placeholder="Contoh: Zubaedah" value="{{ old('nama_anggota') }}" required>
                                </div>
                                @error('nama_anggota') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase">NIPP atau NIK</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card text-muted"></i></span>
                                    <input type="text" name="identity" class="form-control form-identity @error('identity') is-invalid @enderror" 
                                           placeholder="Masukkan NIPP atau NIK" value="{{ old('identity') }}" required>
                                </div>
                                @error('identity') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <hr class="my-4 opacity-50">

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase">Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Minimal 8 karakter" required>
                                </div>
                                <div class="password-requirements" id="passwordRequirements">
                                    <div id="req-length"><i class="fas fa-circle me-1"></i> Minimal 8 karakter</div>
                                    <div id="req-alpha"><i class="fas fa-circle me-1"></i> Kombinasi huruf dan angka</div>
                                </div>
                                @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-check-double text-muted"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control" 
                                           placeholder="Ulangi password baru" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-kai w-100 shadow-sm mt-2">AKTIFKAN AKUN SAYA</button>
                            
                            <div class="text-center mt-4">
                                <p class="small text-muted">Sudah melakukan aktivasi? 
                                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: var(--kai-blue)">Masuk di sini</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-4 text-muted small">
                    &copy; 2026 KOPEKA RAIL INDONESIA. All Rights Reserved.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Simple client-side feedback for password rules
        const password = document.getElementById('password');
        const reqLength = document.getElementById('req-length');
        const reqAlpha = document.getElementById('req-alpha');

        password.addEventListener('input', function() {
            const val = this.value;
            
            // Validate Length
            if (val.length >= 8) {
                reqLength.classList.add('valid');
                reqLength.querySelector('i').className = 'fas fa-check-circle me-1';
            } else {
                reqLength.classList.remove('valid');
                reqLength.querySelector('i').className = 'fas fa-circle me-1';
            }

            // Validate Alpha + Numeric
            const hasLetter = /[a-zA-Z]/.test(val);
            const hasNumber = /[0-9]/.test(val);
            if (hasLetter && hasNumber) {
                reqAlpha.classList.add('valid');
                reqAlpha.querySelector('i').className = 'fas fa-check-circle me-1';
            } else {
                reqAlpha.classList.remove('valid');
                reqAlpha.querySelector('i').className = 'fas fa-circle me-1';
            }
        });
    </script>
</body>
</html>