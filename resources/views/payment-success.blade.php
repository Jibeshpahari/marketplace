<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Successful</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'Inter', sans-serif;
  background: #f0f2f5;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem 1rem;
}

.card {
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 2px 24px rgba(0,0,0,0.08);
  padding: 2.8rem 2rem;
  width: 100%;
  max-width: 420px;
  text-align: center;
}

/* Animated checkmark circle */
.icon-wrap {
  width: 72px;
  height: 72px;
  background: #f0fdf6;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.6rem;
  animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes popIn {
  from { transform: scale(0); opacity: 0; }
  to   { transform: scale(1); opacity: 1; }
}

.icon-wrap svg {
  animation: drawCheck 0.3s ease 0.2s both;
}

@keyframes drawCheck {
  from { opacity: 0; transform: scale(0.5); }
  to   { opacity: 1; transform: scale(1); }
}

/* Text */
.title {
  font-size: 22px;
  font-weight: 700;
  color: #111;
  letter-spacing: -0.02em;
  margin-bottom: 0.5rem;
}

.subtitle {
  font-size: 14px;
  color: #888;
  line-height: 1.6;
  margin-bottom: 2rem;
}

/* Session ID box */
.session-box {
  background: #f8f8fb;
  border: 1.5px solid #e8e8f0;
  border-radius: 10px;
  padding: 12px 16px;
  margin-bottom: 2rem;
  text-align: left;
}

.session-label {
  font-size: 11px;
  font-weight: 600;
  color: #aaa;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  margin-bottom: 5px;
}

.session-id {
  font-family: 'Inter', monospace;
  font-size: 11px;
  color: #555;
  word-break: break-all;
  line-height: 1.5;
}

/* Divider */
.divider {
  height: 1px;
  background: #f0f0f5;
  margin: 0 0 2rem;
}

/* Buttons */
.btn-primary {
  display: block;
  width: 100%;
  background: #111;
  border: none;
  border-radius: 12px;
  color: #fff;
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  font-weight: 600;
  padding: 14px;
  cursor: pointer;
  text-decoration: none;
  transition: all 0.2s;
  margin-bottom: 10px;
}

.btn-primary:hover {
  background: #2d2d2d;
  transform: translateY(-1px);
  box-shadow: 0 6px 18px rgba(0,0,0,0.12);
}

.btn-secondary {
  display: block;
  width: 100%;
  background: transparent;
  border: 1.5px solid #e2e2ea;
  border-radius: 12px;
  color: #555;
  font-family: 'Inter', sans-serif;
  font-size: 14px;
  font-weight: 500;
  padding: 13px;
  cursor: pointer;
  text-decoration: none;
  transition: all 0.2s;
}

.btn-secondary:hover {
  border-color: #bbb;
  color: #111;
}

/* Secure note */
.secure-note {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 5px;
  font-size: 11px;
  color: #bbb;
  margin-top: 1.4rem;
}
</style>
</head>
<body>

<div class="card">

  {{-- Animated check icon --}}
  <div class="icon-wrap">
    <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
      <circle cx="16" cy="16" r="16" fill="#dcfce7"/>
      <path d="M10 16.5l4.5 4.5 7.5-9" stroke="#16a34a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </div>

  <div class="title">Payment successful</div>
  <div class="subtitle">
    Your payment has been confirmed.<br>
    A receipt has been sent to your email.
  </div>

  {{-- Session ID from Stripe --}}
  @if($sessionId)
  <div class="session-box">
    <div class="session-label">Transaction reference</div>
    <div class="session-id">{{ $sessionId }}</div>
  </div>
  @endif

  <div class="divider"></div>

  {{-- Actions --}}
  <a href="/" class="btn-primary">Back to home</a>
  <a href="/payment" class="btn-secondary">Make another payment</a>

  <div class="secure-note">
    <svg width="11" height="11" viewBox="0 0 16 16" fill="none">
      <rect x="2" y="5.5" width="12" height="9" rx="2" stroke="#bbb" stroke-width="1.5"/>
      <path d="M5 5.5V4.5a3 3 0 016 0v1" stroke="#bbb" stroke-width="1.5"/>
    </svg>
    Secured by Stripe
  </div>

</div>

{{-- As you know, I am making a multivendor-like ecommerce site and Amazon, so I need a graph tree of the features and functionalities with a  priority tag, so I know which I should work on first. I need It mainly for 3 user types: customer(user), Vendor, Admin. But for now, give me only the admin, with page mention, and some features are used multiple places so mention all of them you know better, you can say it was the blueprint of the system architecture --}}

</body>
</html>