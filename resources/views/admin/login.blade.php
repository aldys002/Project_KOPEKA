<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin — KOPEKA KAI Daop 6 Yogyakarta</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=DM+Mono:wght@400;500&family=Fraunces:opsz,wght@9..144,300;9..144,400;9..144,600&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --ink:       #0A0E1A;
    --ink-2:     #1C2236;
    --ink-3:     #3A4460;
    --muted:     #7A849E;
    --border:    #E2E6F0;
    --surface:   #F6F8FC;
    --white:     #FFFFFF;
    --orange:    #F05A22;
    --orange-lt: rgba(240,90,34,0.10);
    --blue:      #0033A0;
    --blue-dk:   #001A5E;
    --blue-lt:   rgba(0,51,160,0.07);
    --green:     #1BA46A;
  }

  html, body {
    height: 100%;
    font-family: 'DM Sans', sans-serif;
    -webkit-font-smoothing: antialiased;
  }

  body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    padding: 24px;
  }

  /* ── FULL SCREEN BG ── */
  .bg-full {
    position: fixed;
    inset: 0;
    background-image: url("{{ asset('images/kereta.jpeg') }}");
    background-size: cover;
    background-position: center center;
    z-index: 0;
    animation: subtle-zoom 20s ease-in-out infinite alternate;
  }

  @keyframes subtle-zoom {
    from { transform: scale(1.04); }
    to   { transform: scale(1.10); }
  }

  /* Multi-layer overlay */
  .bg-overlay {
    position: fixed;
    inset: 0;
    z-index: 1;
    background:
      linear-gradient(
        135deg,
        rgba(0,10,35,0.78) 0%,
        rgba(0,26,80,0.62) 50%,
        rgba(0,10,35,0.88) 100%
      );
  }

  /* Noise grain */
  .bg-overlay::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
    pointer-events: none;
  }

  /* Light streak */
  .streak {
    position: fixed;
    top: 0; left: -100%;
    width: 55%; height: 2px;
    background: linear-gradient(90deg, transparent, rgba(240,90,34,0.55), transparent);
    animation: streak 8s ease-in-out 2s infinite;
    z-index: 2;
  }

  @keyframes streak {
    0%   { left: -60%; top: 38%; opacity: 0; }
    15%  { opacity: 1; }
    85%  { opacity: 1; }
    100% { left: 110%; top: 38%; opacity: 0; }
  }

  /* ── TOP BAR ── */
  .top-bar {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 36px;
    background: linear-gradient(to bottom, rgba(0,10,35,0.65) 0%, transparent 100%);
    animation: fade-in 0.6s both;
  }

  @keyframes fade-in {
    from { opacity: 0; }
    to   { opacity: 1; }
  }

  .logo-lockup {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .kai-circle {
    width: 42px; height: 42px;
    background: var(--white);
    border-radius: 11px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 3px;
    flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(0,0,0,0.25);
  }

  .kai-circle span {
    font-family: 'DM Mono', monospace;
    font-size: 10.5px;
    font-weight: 500;
    color: var(--blue-dk);
    letter-spacing: 1px;
    line-height: 1;
  }

  .kai-circle .bar {
    width: 26px; height: 2.5px;
    background: var(--orange);
    border-radius: 2px;
  }

  .logo-text {
    line-height: 1.2;
  }

  .logo-text .name {
    font-family: 'DM Mono', monospace;
    font-size: 14px;
    font-weight: 500;
    color: var(--white);
    letter-spacing: 2.5px;
    display: block;
  }

  .logo-text .sub {
    font-size: 10px;
    color: rgba(255,255,255,0.42);
    letter-spacing: 1px;
    text-transform: uppercase;
    display: block;
  }

  .top-bar-right {
    font-size: 10.5px;
    color: rgba(255,255,255,0.38);
    letter-spacing: 1px;
    text-align: right;
    line-height: 1.65;
    font-family: 'DM Mono', monospace;
  }

  .top-bar-right strong {
    display: block;
    color: rgba(255,255,255,0.65);
    font-weight: 500;
    font-size: 11px;
  }

  /* ── CENTER WRAPPER ── */
  .center-wrap {
    position: relative;
    z-index: 5;
    width: 100%;
    max-width: 440px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    animation: fade-up 0.7s 0.2s both cubic-bezier(.22,.84,.39,1);
  }

  @keyframes fade-up {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* Above-card eyebrow */
  .above-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.14);
    backdrop-filter: blur(8px);
    border-radius: 50px;
    padding: 6px 16px;
    font-family: 'DM Mono', monospace;
    font-size: 10.5px;
    font-weight: 500;
    color: rgba(255,255,255,0.6);
    letter-spacing: 1.5px;
    text-transform: uppercase;
  }

  .above-tag .dot-pulse {
    width: 6px; height: 6px;
    background: var(--orange);
    border-radius: 50%;
    animation: pulse 1.8s ease-in-out infinite;
    flex-shrink: 0;
  }

  @keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.4; transform: scale(1.5); }
  }

  /* ── CARD ── */
  .card {
    width: 100%;
    background: rgba(255,255,255,0.97);
    backdrop-filter: blur(24px);
    border-radius: 20px;
    padding: 36px 36px 30px;
    box-shadow:
      0 32px 80px rgba(0,8,30,0.55),
      0 0 0 1px rgba(255,255,255,0.18);
    position: relative;
    overflow: hidden;
  }

  /* Top accent line */
  .card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--blue) 0%, var(--blue) 55%, var(--orange) 55%, var(--orange) 100%);
  }

  /* Watermark */
  .card-watermark {
    position: absolute;
    bottom: -20px; right: -10px;
    font-family: 'Fraunces', serif;
    font-size: 100px;
    font-weight: 600;
    font-style: italic;
    color: rgba(0,48,135,0.04);
    line-height: 1;
    pointer-events: none;
    user-select: none;
  }

  /* Card header */
  .card-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 28px;
    gap: 12px;
  }

  .card-titles {}

  .card-eyebrow {
    font-family: 'DM Mono', monospace;
    font-size: 10px;
    font-weight: 500;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--orange);
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .card-eyebrow::before {
    content: '';
    width: 18px; height: 1.5px;
    background: var(--orange);
    border-radius: 2px;
    flex-shrink: 0;
  }

  .card-title {
    font-family: 'Fraunces', serif;
    font-size: 26px;
    font-weight: 400;
    color: var(--ink);
    line-height: 1.2;
    letter-spacing: -0.3px;
  }

  .card-title em {
    font-style: italic;
    color: var(--blue);
  }

  .card-sub {
    font-size: 12.5px;
    color: var(--muted);
    line-height: 1.65;
    margin-top: 6px;
  }

  /* Secure badge top-right */
  .secure-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 10px;
    font-family: 'DM Mono', monospace;
    color: var(--green);
    background: rgba(27,164,106,0.09);
    border: 1px solid rgba(27,164,106,0.2);
    border-radius: 50px;
    padding: 5px 10px;
    letter-spacing: 0.5px;
    white-space: nowrap;
    flex-shrink: 0;
  }

  .secure-badge::before {
    content: '';
    width: 5px; height: 5px;
    background: var(--green);
    border-radius: 50%;
    animation: blink 2.2s ease-in-out infinite;
  }

  @keyframes blink {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.25; }
  }

  /* ── FORM ── */
  .form-header {
    margin-bottom: 40px;
  }

  .form-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: 'DM Mono', monospace;
    font-size: 10px;
    font-weight: 500;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--orange);
    margin-bottom: 12px;
  }

  .form-eyebrow::before {
    content: '';
    display: inline-block;
    width: 20px; height: 1.5px;
    background: var(--orange);
    border-radius: 2px;
  }

  .form-title {
    font-family: 'Fraunces', serif;
    font-size: 32px;
    font-weight: 400;
    color: var(--ink);
    line-height: 1.15;
    letter-spacing: -0.3px;
    margin-bottom: 8px;
  }

  .form-title em {
    font-style: italic;
    color: var(--blue);
  }

  .form-sub {
    font-size: 13px;
    color: var(--muted);
    line-height: 1.65;
  }

  /* Error box */
  .error-box {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: #FFF4F4;
    border: 1px solid #F7C0C0;
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 24px;
    font-size: 12.5px;
    color: #C0222A;
    font-weight: 500;
    line-height: 1.5;
  }

  /* Field */
  .field {
    margin-bottom: 20px;
  }

  .field-label {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
  }

  .field-label label {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--ink-3);
  }

  .field-optional {
    font-size: 10.5px;
    color: var(--muted);
  }

  .field-wrap {
    position: relative;
  }

  .field-wrap input {
    width: 100%;
    height: 48px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: 0 44px 0 44px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    color: var(--ink);
    background: var(--surface);
    outline: none;
    transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    appearance: none;
  }

  .field-wrap input::placeholder {
    color: #BCC5D8;
    font-weight: 300;
  }

  .field-wrap input:focus {
    border-color: var(--blue);
    background: var(--white);
    box-shadow: 0 0 0 3.5px rgba(0,51,160,0.08);
  }

  /* floating label indicator */
  .field-wrap input:not(:placeholder-shown) ~ .field-icon {
    color: var(--blue);
  }

  .field-icon {
    position: absolute;
    left: 14px; top: 50%;
    transform: translateY(-50%);
    color: #C0C9DC;
    display: flex;
    pointer-events: none;
    transition: color 0.2s;
  }

  .eye-btn {
    position: absolute;
    right: 12px; top: 50%;
    transform: translateY(-50%);
    background: none; border: none;
    cursor: pointer;
    color: #C0C9DC;
    display: flex; padding: 4px;
    border-radius: 6px;
    transition: color 0.2s, background 0.2s;
  }

  .eye-btn:hover {
    color: var(--blue);
    background: var(--blue-lt);
  }

  /* Divider */
  .divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 24px 0;
  }

  .divider::before, .divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
  }

  .divider span {
    font-size: 10.5px;
    font-family: 'DM Mono', monospace;
    color: #C0C9DC;
    letter-spacing: 1px;
    text-transform: uppercase;
    white-space: nowrap;
  }

  /* Submit button */
  .btn-submit {
    width: 100%;
    height: 50px;
    background: var(--ink);
    color: var(--white);
    border: none;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.3px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    position: relative;
    overflow: hidden;
    transition: background 0.22s, transform 0.15s, box-shadow 0.22s;
    box-shadow: 0 4px 18px rgba(10,14,26,0.18);
  }

  .btn-submit:hover {
    background: var(--blue);
    transform: translateY(-1px);
    box-shadow: 0 8px 28px rgba(0,51,160,0.28);
  }

  .btn-submit:active {
    transform: translateY(0);
    box-shadow: 0 3px 10px rgba(0,51,160,0.18);
  }

  /* Shine sweep */
  .btn-submit::after {
    content: '';
    position: absolute;
    top: 0; left: -80%;
    width: 50%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.13), transparent);
    transform: skewX(-15deg);
    transition: left 0.55s ease;
  }

  .btn-submit:hover::after { left: 140%; }

  /* Arrow icon inside button */
  .btn-arrow {
    width: 26px; height: 26px;
    border-radius: 6px;
    background: rgba(255,255,255,0.12);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: background 0.2s, transform 0.2s;
  }

  .btn-submit:hover .btn-arrow {
    background: rgba(255,255,255,0.2);
    transform: translateX(3px);
  }

  /* Footer */
  .form-footer {
    margin-top: 28px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 14px;
  }

  .form-footer-info {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11.5px;
    color: var(--muted);
  }

  .form-footer-info .dot {
    width: 3px; height: 3px;
    border-radius: 50%;
    background: var(--border);
  }

  .secure-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 10.5px;
    font-family: 'DM Mono', monospace;
    color: var(--green);
    background: rgba(27,164,106,0.08);
    border: 1px solid rgba(27,164,106,0.18);
    border-radius: 50px;
    padding: 4px 10px;
    letter-spacing: 0.5px;
  }

  .secure-badge::before {
    content: '';
    width: 5px; height: 5px;
    background: var(--green);
    border-radius: 50%;
    animation: blink 2s ease-in-out infinite;
  }

  @keyframes blink {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.3; }
  }

  /* Bottom rule */
  .bottom-bar {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg,
      var(--blue) 0%, var(--blue) 58%,
      var(--orange) 58%, var(--orange) 100%
    );
    z-index: 100;
  }

  /* ── RESPONSIVE ── */
  @media (max-width: 520px) {
    .top-bar { padding: 16px 20px; }
    .top-bar-right { display: none; }
    .card { padding: 28px 22px 24px; border-radius: 16px; }
    .card-title { font-size: 22px; }
    body { padding: 16px; padding-top: 80px; padding-bottom: 32px; }
  }
</style>
</head>
<body>

<!-- BG layers -->
<div class="bg-full"></div>
<div class="bg-overlay"></div>
<div class="streak"></div>

<!-- TOP BAR -->
<header class="top-bar">
  <div class="logo-lockup">
    <div class="kai-circle">
      <span>KAI</span>
      <div class="bar"></div>
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

<!-- CENTER CARD -->
<div class="center-wrap">

  <div class="above-tag">
    <span class="dot-pulse"></span>
    Portal Admin · Daop 6 Yogyakarta
  </div>

  <div class="card">
    <div class="card-watermark">KAI</div>

    <div class="card-header">
      <div class="card-titles">
        <div class="card-eyebrow">Admin Access</div>
        <div class="card-title">Selamat <em>Datang</em></div>
        <div class="card-sub">Masuk menggunakan akun admin KOPEKA Anda.</div>
      </div>
      <div class="secure-badge">Aman</div>
    </div>

    @if($errors->has('error'))
    <div class="error-box">
      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      <span>{{ $errors->first('error') }}</span>
    </div>
    @endif

    <form action="{{ route('admin.login.submit') }}" method="POST" autocomplete="off">
      @csrf

      <div class="field">
        <div class="field-label">
          <label for="nipp">NIPP Admin</label>
        </div>
        <div class="field-wrap">
          <span class="field-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
              <rect x="2" y="7" width="20" height="14" rx="2.5"/>
              <path d="M16 3H8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z"/>
              <line x1="8" y1="13" x2="10" y2="13"/>
              <line x1="8" y1="17" x2="16" y2="17"/>
            </svg>
          </span>
          <input type="text" id="nipp" name="nipp" placeholder="Contoh: 123456789" value="{{ old('nipp') }}" required autocomplete="username">
        </div>
      </div>

      <div class="field">
        <div class="field-label">
          <label for="password">Kata Sandi</label>
        </div>
        <div class="field-wrap">
          <span class="field-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
              <rect x="3" y="11" width="18" height="11" rx="2.5"/>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
          </span>
          <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required autocomplete="current-password">
          <button type="button" class="eye-btn" onclick="togglePw(this)" title="Tampilkan/sembunyikan">
            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
      </div>

      <div class="divider"><span>lanjutkan</span></div>

      <button type="submit" class="btn-submit">
        Masuk ke Dashboard
        <div class="btn-arrow">
          <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </div>
      </button>

    </form>

    <div class="form-footer">
      <div class="form-footer-info">
        <span>KOPEKA KAI</span>
        <div class="dot"></div>
        <span>Daop 6 Yogyakarta</span>
        <div class="dot"></div>
        <span>&copy; {{ date('Y') }}</span>
      </div>
    </div>

  </div>
</div>

<div class="bottom-bar"></div>

<script>
  function togglePw(btn) {
    const inp = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    const isPass = inp.type === 'password';
    inp.type = isPass ? 'text' : 'password';
    icon.innerHTML = isPass
      ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
      : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
  }

  // Stagger field focus ring reveal
  document.querySelectorAll('.field-wrap input').forEach((inp, i) => {
    inp.style.animationDelay = `${0.35 + i * 0.1}s`;
    inp.style.animation = 'fade-up 0.5s both cubic-bezier(.22,.84,.39,1)';
  });
</script>
</body>
</html>