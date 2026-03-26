<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin — KOPEKA KAI Daop 6 Yogyakarta</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700;800&family=Oswald:wght@500;700&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --orange: #F15A22;
    --orange-dark: #C44010;
    --blue: #003087;
    --blue-dark: #001A50;
    --white: #FFFFFF;
    --card-bg: rgba(255,255,255,0.97);
    --text: #0F1F3D;
    --muted: #6B7A99;
    --border: #DDE3F0;
    --error: #D92020;
  }

  html, body {
    height: 100%;
    font-family: 'Sora', sans-serif;
  }

  /* ── FULL SCREEN BACKGROUND ── */
  body {
    background: var(--blue-dark);
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    overflow: hidden;
  }

  /* --- BAGIAN YANG DIEDIT: Menggunakan gambar dari web user --- */
  .bg-photo {
    position: fixed;
    inset: 0;
    /* Menggunakan asset gambar kereta yang sama dengan halaman user */
    background-image: url("{{ asset('images/kereta.jpeg') }}");
    background-size: cover;
    /* Mengatur posisi gambar agar pas di tengah */
    background-position: center center;
    background-repeat: no-repeat;
    z-index: 0;
  }
  /* ---------------------------------------------------------- */

  /* Multi-layer overlay: dark gradient + blue tint */
  .bg-photo::after {
    content: '';
    position: absolute;
    inset: 0;
    background:
      linear-gradient(to bottom,
        rgba(0,26,80,0.72) 0%,
        rgba(0,26,80,0.55) 40%,
        rgba(0,10,30,0.85) 100%
      );
  }

  /* Moving light streak */
  .light-streak {
    position: fixed;
    top: 0; left: -100%;
    width: 60%; height: 3px;
    background: linear-gradient(90deg, transparent, rgba(241,90,34,0.7), transparent);
    animation: streak 5s ease-in-out infinite;
    z-index: 1;
  }

  @keyframes streak {
    0%   { left: -60%; top: 35%; opacity: 0; }
    20%  { opacity: 1; }
    80%  { opacity: 1; }
    100% { left: 110%; top: 35%; opacity: 0; }
  }

  /* ── TOP BAR ── */
  .top-bar {
    position: fixed;
    top: 0; left: 0; right: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 40px;
    z-index: 10;
    background: linear-gradient(to bottom, rgba(0,26,80,0.9) 0%, transparent 100%);
  }

  .logo-lockup {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  /* KAI Circle Badge */
  .kai-badge {
    width: 52px; height: 52px;
    background: var(--white);
    border-radius: 50%;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    flex-shrink: 0;
    padding-bottom: 2px;
  }

  .kai-badge .letters {
    font-family: 'Oswald', sans-serif;
    font-weight: 700;
    font-size: 17px;
    color: var(--blue);
    line-height: 1;
    letter-spacing: 1px;
  }

  .kai-badge .stripe {
    width: 34px; height: 3px;
    background: var(--orange);
    border-radius: 2px;
    margin-top: 3px;
  }

  .logo-text {
    line-height: 1.15;
  }

  .logo-text .name {
    font-family: 'Oswald', sans-serif;
    font-weight: 700;
    font-size: 22px;
    color: var(--white);
    letter-spacing: 2px;
  }

  .logo-text .sub {
    font-size: 10px;
    color: rgba(255,255,255,0.5);
    letter-spacing: 1.5px;
    text-transform: uppercase;
    display: block;
  }

  .top-bar-right {
    font-size: 11px;
    color: rgba(255,255,255,0.45);
    letter-spacing: 1px;
    text-align: right;
    line-height: 1.6;
  }

  .top-bar-right strong {
    color: rgba(255,255,255,0.75);
    display: block;
    font-size: 12px;
  }

  /* ── CENTER CARD ── */
  .wrapper {
    position: relative;
    z-index: 5;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    animation: rise 0.6s cubic-bezier(.22,.84,.39,1) both;
  }

  @keyframes rise {
    from { transform: translateY(28px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
  }

  /* Tagline above card */
  .above-card {
    text-align: center;
    margin-bottom: 24px;
  }

  .above-card .daop-tag {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(241,90,34,0.15);
    border: 1px solid rgba(241,90,34,0.35);
    border-radius: 50px;
    padding: 5px 14px;
    font-size: 11px;
    font-weight: 600;
    color: #FFAA80;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 12px;
  }

  .above-card .daop-tag::before {
    content: '';
    width: 6px; height: 6px;
    background: var(--orange);
    border-radius: 50%;
    animation: pulse 1.8s ease-in-out infinite;
  }

  @keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.5; transform: scale(1.4); }
  }

  .above-card h1 {
    font-family: 'Oswald', sans-serif;
    font-size: clamp(28px, 4vw, 42px);
    font-weight: 700;
    color: var(--white);
    letter-spacing: 1px;
    text-shadow: 0 2px 20px rgba(0,0,0,0.5);
    line-height: 1.1;
  }

  .above-card h1 span { color: var(--orange); }

  /* Card */
  .card {
    background: var(--card-bg);
    border-radius: 20px;
    padding: 38px 36px 32px;
    width: 100%;
    max-width: 400px;
    box-shadow:
      0 30px 80px rgba(0,10,40,0.6),
      0 0 0 1px rgba(255,255,255,0.15);
    position: relative;
    overflow: hidden;
  }

  /* Top orange accent bar */
  .card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--blue) 0%, var(--orange) 100%);
  }

  /* Subtle watermark */
  .card-watermark {
    position: absolute;
    bottom: -16px; right: -16px;
    font-family: 'Oswald', sans-serif;
    font-size: 90px;
    font-weight: 700;
    color: rgba(0,48,135,0.04);
    line-height: 1;
    pointer-events: none;
    user-select: none;
    letter-spacing: -2px;
  }

  .card-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 4px;
    letter-spacing: -0.3px;
  }

  .card-sub {
    font-size: 12.5px;
    color: var(--muted);
    margin-bottom: 26px;
  }

  /* Error */
  .error-box {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    background: #FFF0F0;
    border-left: 3px solid var(--error);
    border-radius: 8px;
    padding: 11px 14px;
    margin-bottom: 20px;
    font-size: 13px;
    color: var(--error);
    font-weight: 500;
  }

  /* Form fields */
  .field { margin-bottom: 16px; }

  .field label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--text);
    margin-bottom: 7px;
  }

  .field-wrap {
    position: relative;
  }

  .field-icon {
    position: absolute;
    left: 13px; top: 50%;
    transform: translateY(-50%);
    color: #A0AECC;
    display: flex;
    pointer-events: none;
  }

  .field-wrap input {
    width: 100%;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: 12px 14px 12px 40px;
    font-family: 'Sora', sans-serif;
    font-size: 13.5px;
    color: var(--text);
    background: #F7F9FE;
    outline: none;
    transition: all 0.2s;
    appearance: none;
  }

  .field-wrap input::placeholder { color: #B0BCDA; }

  .field-wrap input:focus {
    border-color: var(--blue);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(0,48,135,0.09);
  }

  .eye-btn {
    position: absolute;
    right: 12px; top: 50%;
    transform: translateY(-50%);
    background: none; border: none;
    cursor: pointer; color: #A0AECC;
    display: flex; padding: 0;
    transition: color 0.2s;
  }
  .eye-btn:hover { color: var(--blue); }

  /* Separator */
  .sep {
    display: flex; align-items: center; gap: 10px;
    margin: 20px 0;
    font-size: 11px; color: #C5CEDF;
    letter-spacing: 1px; text-transform: uppercase;
  }
  .sep::before, .sep::after {
    content: ''; flex: 1; height: 1px; background: var(--border);
  }

  /* Submit */
  .btn-submit {
    width: 100%;
    padding: 14px;
    background: var(--orange);
    color: var(--white);
    border: none;
    border-radius: 10px;
    font-family: 'Sora', sans-serif;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 0.5px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    box-shadow: 0 5px 20px rgba(241,90,34,0.4);
    display: flex; align-items: center; justify-content: center; gap: 8px;
  }

  .btn-submit:hover {
    background: var(--orange-dark);
    transform: translateY(-1px);
    box-shadow: 0 8px 28px rgba(241,90,34,0.5);
  }

  .btn-submit:active { transform: translateY(0); }

  /* Shine sweep on hover */
  .btn-submit::after {
    content: '';
    position: absolute;
    top: 0; left: -75%;
    width: 50%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.22), transparent);
    transform: skewX(-20deg);
    transition: left 0.5s;
  }
  .btn-submit:hover::after { left: 130%; }

  /* Footer */
  .card-footer {
    margin-top: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 11px;
    color: var(--muted);
  }

  .card-footer .divot {
    width: 3px; height: 3px;
    background: var(--border);
    border-radius: 50%;
  }

  /* Bottom banner */
  .bottom-banner {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    height: 5px;
    background: linear-gradient(90deg,
      var(--blue) 0%, var(--blue) 60%,
      var(--orange) 60%, var(--orange) 100%
    );
    z-index: 10;
  }

  @media (max-width: 480px) {
    .top-bar { padding: 14px 20px; }
    .top-bar-right { display: none; }
    .card { padding: 28px 22px; border-radius: 16px; }
    .above-card h1 { font-size: 26px; }
  }
</style>
</head>
<body>

<div class="bg-photo"></div>
<div class="light-streak"></div>

<header class="top-bar">
  <div class="logo-lockup">
    <div class="kai-badge">
      <span class="letters">KAI</span>
      <span class="stripe"></span>
    </div>
    <div class="logo-text">
      <span class="name">KOPEKA</span>
      <span class="sub">Koperasi Karyawan KAI</span>
    </div>
  </div>
  <div class="top-bar-right">
    <strong>PT Kereta Api Indonesia (Persero)</strong>
    Daerah Operasi 6 Yogyakarta
  </div>
</header>

<div class="wrapper">

  <div class="above-card">
    <div class="daop-tag">Daop 6 Yogyakarta</div>
    <h1>Portal <span>Admin</span><br>KOPEKA</h1>
  </div>

  <div class="card">
    <div class="card-watermark">KAI</div>

    <div class="card-title">Selamat Datang 👋</div>
    <div class="card-sub">Masuk menggunakan akun admin KOPEKA Anda</div>

    @if($errors->has('error'))
    <div class="error-box">
      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      <span>{{ $errors->first('error') }}</span>
    </div>
    @endif

    <form action="{{ route('admin.login.submit') }}" method="POST" autocomplete="off">
      @csrf

      <div class="field">
        <label for="nipp">NIPP Admin</label>
        <div class="field-wrap">
          <span class="field-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
          </span>
          <input
            type="text"
            id="nipp"
            name="nipp"
            placeholder="Contoh: 123456789"
            value="{{ old('nipp') }}"
            required
            autocomplete="username"
          >
        </div>
      </div>

      <div class="field">
        <label for="password">Kata Sandi</label>
        <div class="field-wrap">
          <span class="field-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </span>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Masukkan kata sandi"
            required
            autocomplete="current-password"
          >
          <button type="button" class="eye-btn" onclick="togglePw(this)" title="Tampilkan/sembunyikan">
            <svg id="eye-show" xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>

      <div class="sep">atau masuk dengan</div>

      <button type="submit" class="btn-submit">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        Masuk ke Dashboard
      </button>
    </form>

    <div class="card-footer">
      <span>KOPEKA KAI</span>
      <span class="divot"></span>
      <span>Daop 6 Yogyakarta</span>
      <span class="divot"></span>
      <span>&copy; {{ date('Y') }}</span>
    </div>
  </div>

</div>

<div class="bottom-banner"></div>

<script>
  function togglePw(btn) {
    const inp = document.getElementById('password');
    const isPass = inp.type === 'password';
    inp.type = isPass ? 'text' : 'password';
    btn.querySelector('svg').innerHTML = isPass
      ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
      : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
  }
</script>
</body>
</html>