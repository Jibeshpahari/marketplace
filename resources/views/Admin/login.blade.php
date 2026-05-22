<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="Admin Login" />
  <meta name="robots" content="noindex, nofollow" />
  <meta name="theme-color" content="#ffffff" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/global/images/favicon.ico') }}" />
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/global/images/favicon-32x32.png') }}" />
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/global/images/favicon-16x16.png') }}" />
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/global/images/apple-touch-icon.png') }}" />
  <link rel="manifest" href="{{ asset('site.webmanifest') }}" />

  <title>Admin Login</title>

  <!-- Stylesheets -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet" />
  <link href="{{ asset('assets/global/css/login.css') }}" rel="stylesheet" />

  <!-- CSRF Token (Laravel) -->
  <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>

  <div class="login-card">

    <div class="card-header-text">
      <h2>Welcome back</h2>
      <p>Sign in to your admin account to continue.</p>
    </div>

    <div class="alert-custom" id="loginAlert" role="alert">
      <i class="bi bi-exclamation-circle-fill"></i>
      <span id="alertMsg">Invalid email or password.</span>
    </div>

    <form id="loginForm" novalidate>

      <div class="form-group">
        <label class="form-label" for="email">Email address</label>
        <div class="input-group-custom">
          <i class="bi bi-envelope input-icon"></i>
          <input type="email" id="email" name="email" class="form-control-custom" placeholder="user@example.com" autocomplete="email" required />
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <div class="input-group-custom">
          <i class="bi bi-lock input-icon"></i>
          <input type="password" id="password" name="password" class="form-control-custom has-toggle" placeholder="•••••••••••••••" autocomplete="current-password" required />
          <button type="button" class="toggle-pw" id="togglePw" aria-label="Toggle password visibility">
            <i class="bi bi-eye" id="toggleIcon"></i>
          </button>
        </div>
      </div>

      <div class="form-options">
        <label class="custom-check">
          <input type="checkbox" id="remember" />
          <span class="check-label">Keep me signed in</span>
        </label>
        <a href="#" class="forgot-link">Forgot password?</a>
      </div>

      <button type="submit" class="btn-login" id="submitBtn">
        <span id="btnText">Sign in to dashboard</span>
        <i class="bi bi-arrow-right" id="btnIcon"></i>
        <span id="btnSpinner" style="display:none; align-items:center; gap:6px;">
          <i class="bi bi-arrow-repeat" style="animation: spin 0.8s linear infinite; display:inline-block;"></i>
          Signing in…
        </span>
      </button>

    </form>

    <div class="divider"><span>or continue with</span></div>

    <div class="sso-grid">
      <a href="#" class="btn-sso google">
        <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
          <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844a4.14 4.14 0 0 1-1.796 2.716v2.259h2.908c1.702-1.567 2.684-3.875 2.684-6.615z" fill="#4285F4"/>
          <path d="M9 18c2.43 0 4.467-.806 5.956-2.184l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 0 0 9 18z" fill="#34A853"/>
          <path d="M3.964 10.706A5.41 5.41 0 0 1 3.682 9c0-.593.102-1.17.282-1.706V4.962H.957A8.996 8.996 0 0 0 0 9c0 1.452.348 2.827.957 4.038l3.007-2.332z" fill="#FBBC05"/>
          <path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 0 0 .957 4.962L3.964 7.294C4.672 5.163 6.656 3.58 9 3.58z" fill="#EA4335"/>
        </svg>
        Google
      </a>
      <a href="#" class="btn-sso microsoft">
        <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
          <rect x="0"  y="0"  width="8.5" height="8.5" fill="#F25022"/>
          <rect x="9.5" y="0"  width="8.5" height="8.5" fill="#7FBA00"/>
          <rect x="0"  y="9.5" width="8.5" height="8.5" fill="#00A4EF"/>
          <rect x="9.5" y="9.5" width="8.5" height="8.5" fill="#FFB900"/>
        </svg>
        Microsoft
      </a>
    </div>

    <div class="form-footer">
      Protected by 2FA &amp; end-to-end encryption.<br />
      Need access? <a href="#">Contact your administrator</a>.
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const togglePw   = document.getElementById('togglePw');
    const pwInput    = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    togglePw.addEventListener('click', () => {
      const isText = pwInput.type === 'text';
      pwInput.type = isText ? 'password' : 'text';
      toggleIcon.className = isText ? 'bi bi-eye' : 'bi bi-eye-slash';
    });

    const form      = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText   = document.getElementById('btnText');
    const btnIcon   = document.getElementById('btnIcon');
    const btnSpinner = document.getElementById('btnSpinner');
    const alertBox  = document.getElementById('loginAlert');
    const alertMsg  = document.getElementById('alertMsg');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      alertBox.classList.remove('show');
      const email = document.getElementById('email').value.trim();
      const pw    = document.getElementById('password').value;
      if (!email || !pw) {
        alertMsg.textContent = 'Please fill in both fields.';
        alertBox.classList.add('show');
        return;
      }
      btnText.style.display    = 'none';
      btnIcon.style.display    = 'none';
      btnSpinner.style.display = 'flex';
      submitBtn.disabled = true;
      await new Promise(r => setTimeout(r, 1800));
      btnText.style.display    = '';
      btnIcon.style.display    = '';
      btnSpinner.style.display = 'none';
      submitBtn.disabled = false;
      alertMsg.textContent = 'Invalid credentials. Please try again.';
      alertBox.classList.add('show');
      /*
        const res  = await fetch('/api/admin/login', { method:'POST', body: JSON.stringify({email, pw}), headers:{'Content-Type':'application/json'} });
        const data = await res.json();
        if (res.ok) { window.location.href = data.redirectTo || '/dashboard'; }
        else { alertMsg.textContent = data.message || 'Login failed.'; alertBox.classList.add('show'); }
      */
    });
  </script>
</body>
</html>
