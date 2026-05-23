<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment</title>
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
  padding: 2.2rem 2rem;
  width: 100%;
  max-width: 420px;
}

.card-header { margin-bottom: 1.8rem; }
.card-header h2 { font-size: 20px; font-weight: 700; color: #111; letter-spacing: -0.02em; }
.card-header p  { font-size: 13px; color: #888; margin-top: 3px; }

.field { margin-bottom: 1.1rem; }

.field label {
  display: block;
  font-size: 12px;
  font-weight: 600;
  color: #444;
  letter-spacing: 0.03em;
  margin-bottom: 6px;
  text-transform: uppercase;
}

.field input {
  width: 100%;
  border: 1.5px solid #e2e2ea;
  border-radius: 10px;
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  color: #111;
  padding: 12px 14px;
  outline: none;
  transition: border-color 0.18s, box-shadow 0.18s;
  background: #fafafa;
}

.field input:focus {
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79,70,229,0.10);
  background: #fff;
}

.field input::placeholder { color: #bbb; }
.field input.filled { background: #fff; border-color: #d0d0e0; }

.amount-row { display: flex; gap: 8px; align-items: stretch; }
.amount-wrap { flex: 1; position: relative; }
.amount-wrap .sym {
  position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
  font-size: 16px; color: #888; pointer-events: none; font-weight: 500;
}
.amount-wrap input { padding-left: 30px; font-size: 22px; font-weight: 600; color: #111; }

.rand-btn {
  background: #f4f4f8; border: 1.5px solid #e2e2ea; border-radius: 10px;
  color: #666; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600;
  letter-spacing: 0.06em; padding: 0 16px; cursor: pointer; transition: all 0.18s; white-space: nowrap;
}
.rand-btn:hover { border-color: #4f46e5; color: #4f46e5; background: rgba(79,70,229,0.05); }

.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

.cn-wrap { position: relative; }
.cn-wrap input { padding-right: 48px; letter-spacing: 0.08em; }
.card-brand {
  position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
  font-size: 11px; font-weight: 700; color: #aaa; letter-spacing: 0.05em;
  pointer-events: none; transition: color 0.2s;
}

.divider { height: 1px; background: #f0f0f5; margin: 1.4rem 0; }

.pay-btn {
  width: 100%; background: #111; border: none; border-radius: 12px;
  color: #fff; font-family: 'Inter', sans-serif; font-size: 15px; font-weight: 600;
  padding: 15px; cursor: pointer; transition: all 0.2s; letter-spacing: 0.01em;
}
.pay-btn:hover:not(:disabled) { background: #2d2d2d; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(0,0,0,0.15); }
.pay-btn:active:not(:disabled) { transform: translateY(0); }
.pay-btn:disabled { opacity: 0.5; cursor: not-allowed; }

.spinner {
  display: inline-block; width: 14px; height: 14px;
  border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff;
  border-radius: 50%; animation: spin 0.7s linear infinite;
  vertical-align: middle; margin-right: 7px;
}
@keyframes spin { to { transform: rotate(360deg); } }

.alert {
  display: none; border-radius: 10px; padding: 13px 15px;
  margin-top: 1rem; border: 1.5px solid; animation: slideIn 0.22s ease;
}
@keyframes slideIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }
.alert-row { display: flex; align-items: flex-start; gap: 10px; }
.alert-icon { font-size: 16px; flex-shrink: 0; line-height: 1.35; }
.alert-title { font-size: 13px; font-weight: 600; margin-bottom: 2px; }
.alert-body  { font-size: 12px; opacity: 0.8; line-height: 1.5; }
.alert.success { background: #f0fdf6; border-color: #86efac; color: #15803d; }
.alert.error   { background: #fff5f5; border-color: #fca5a5; color: #b91c1c; }
.alert.warning { background: #fffbeb; border-color: #fcd34d; color: #92400e; }

.test-section { margin-top: 1.6rem; }
.test-label {
  font-size: 11px; font-weight: 600; color: #aaa; letter-spacing: 0.1em;
  text-transform: uppercase; text-align: center; margin-bottom: 0.75rem;
}
.test-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.test-chip {
  background: #fafafa; border: 1.5px solid #e8e8f0; border-radius: 10px;
  padding: 10px 12px; cursor: pointer; transition: all 0.15s; user-select: none;
}
.test-chip:hover { border-color: #c8c8e0; background: #f4f4fb; transform: translateY(-1px); }
.test-chip:active { transform: translateY(0); }
.chip-top { display: flex; align-items: center; gap: 5px; margin-bottom: 4px; }
.chip-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
.chip-name { font-size: 11px; font-weight: 600; letter-spacing: 0.02em; }
.chip-num  { font-size: 11px; color: #999; font-family: 'Inter', monospace; letter-spacing: 0.05em; }
.chip-hint { font-size: 10px; color: #bbb; margin-top: 2px; }
.dot-green  { background: #22c55e; } .dot-red    { background: #ef4444; }
.dot-yellow { background: #f59e0b; } .dot-purple { background: #8b5cf6; }
.name-green  { color: #16a34a; } .name-red    { color: #dc2626; }
.name-yellow { color: #b45309; } .name-purple { color: #7c3aed; }

.secure-note {
  display: flex; align-items: center; justify-content: center;
  gap: 5px; font-size: 11px; color: #bbb; margin-top: 1rem;
}

@media (max-width: 480px) {
  .card { padding: 1.6rem 1.2rem; }
  .two-col { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<div class="card">

  <div class="card-header">
    <h2>Complete payment</h2>
    <p>Enter your card details to proceed</p>
  </div>

  {{-- ✅ FORM — posts to /payment/process with CSRF --}}
  <form id="payment-form" method="POST" action="{{ route('payment.process') }}">
    @csrf

    {{-- Amount --}}
    <div class="field">
      <label for="amount">Amount</label>
      <div class="amount-row">
        <div class="amount-wrap">
          <span class="sym">₹</span>
          <input
            type="number"
            id="amount"
            name="amount"
            value="499"
            min="1"
            placeholder="0"
          />
        </div>
        <button class="rand-btn" type="button" onclick="randomAmount()">RANDOM</button>
      </div>
    </div>

    <div class="divider"></div>

    {{-- Card number --}}
    <div class="field">
      <label for="card_number">Card number</label>
      <div class="cn-wrap">
        <input
          type="text"
          id="card-number"
          name="card_number"
          placeholder="1234 5678 9012 3456"
          maxlength="19"
          inputmode="numeric"
          autocomplete="cc-number"
          oninput="formatCardNumber(this)"
        />
        <span class="card-brand" id="card-brand"></span>
      </div>
    </div>

    {{-- Expiry + CVC --}}
    <div class="two-col">
      <div class="field">
        <label for="card_expiry">Expiry date</label>
        <input
          type="text"
          id="card-expiry"
          name="card_expiry"
          placeholder="MM / YY"
          maxlength="7"
          inputmode="numeric"
          autocomplete="cc-exp"
          oninput="formatExpiry(this)"
        />
      </div>
      <div class="field">
        <label for="card_cvc">Security code</label>
        <input
          type="text"
          id="card-cvc"
          name="card_cvc"
          placeholder="CVC"
          maxlength="4"
          inputmode="numeric"
          autocomplete="cc-csc"
          oninput="this.value=this.value.replace(/\D/g,'')"
        />
      </div>
    </div>

    {{-- Name --}}
    <div class="field">
      <label for="card_name">Name on card</label>
      <input
        type="text"
        id="card-name"
        name="card_name"
        placeholder="Full name"
        autocomplete="cc-name"
      />
    </div>

    {{-- Pay button --}}
    <button class="pay-btn" id="pay-btn" type="button" onclick="handlePay()">
      Pay ₹<span id="btn-amt">499</span>
    </button>

    {{-- Alerts --}}
    <div class="alert success" id="al-success">
      <div class="alert-row">
        <span class="alert-icon">✓</span>
        <div>
          <div class="alert-title">Payment successful</div>
          <div class="alert-body" id="msg-success"></div>
        </div>
      </div>
    </div>

    <div class="alert error" id="al-error">
      <div class="alert-row">
        <span class="alert-icon">✕</span>
        <div>
          <div class="alert-title">Payment failed</div>
          <div class="alert-body" id="msg-error"></div>
        </div>
      </div>
    </div>

    <div class="alert warning" id="al-warning">
      <div class="alert-row">
        <span class="alert-icon">⚠</span>
        <div>
          <div class="alert-title">Attention required</div>
          <div class="alert-body" id="msg-warning"></div>
        </div>
      </div>
    </div>

  </form>

  {{-- Quick fill test cards (outside form — just fills the fields) --}}
  <div class="test-section">
    <div class="test-label">Quick fill — test cards</div>
    <div class="test-grid">

      <div class="test-chip" onclick="fillCard('4242424242424242','12/29','123','Test User')">
        <div class="chip-top"><span class="chip-dot dot-green"></span><span class="chip-name name-green">Payment succeeds</span></div>
        <div class="chip-num">4242 4242 4242 4242</div>
        <div class="chip-hint">Successful charge</div>
      </div>

      <div class="test-chip" onclick="fillCard('4000000000000002','12/29','123','Test User')">
        <div class="chip-top"><span class="chip-dot dot-red"></span><span class="chip-name name-red">Card declined</span></div>
        <div class="chip-num">4000 0000 0000 0002</div>
        <div class="chip-hint">Generic decline</div>
      </div>

      <div class="test-chip" onclick="fillCard('4000000000009995','12/29','123','Test User')">
        <div class="chip-top"><span class="chip-dot dot-yellow"></span><span class="chip-name name-yellow">Insufficient funds</span></div>
        <div class="chip-num">4000 0000 0000 9995</div>
        <div class="chip-hint">Low balance warning</div>
      </div>

      <div class="test-chip" onclick="fillCard('4000002760003184','12/29','123','Test User')">
        <div class="chip-top"><span class="chip-dot dot-purple"></span><span class="chip-name name-purple">3DS Auth required</span></div>
        <div class="chip-num">4000 0027 6000 3184</div>
        <div class="chip-hint">Bank verification</div>
      </div>

    </div>
  </div>

  <div class="secure-note">
    <svg width="11" height="11" viewBox="0 0 16 16" fill="none">
      <rect x="2" y="5.5" width="12" height="9" rx="2" stroke="#bbb" stroke-width="1.5"/>
      <path d="M5 5.5V4.5a3 3 0 016 0v1" stroke="#bbb" stroke-width="1.5"/>
    </svg>
    Secured by Stripe · No real charges
  </div>

</div>

<script>
document.getElementById('amount').addEventListener('input', function() {
  document.getElementById('btn-amt').textContent = this.value || '0';
});

function randomAmount() {
  const pool = [99,149,199,249,299,349,399,449,499,599,699,799,999,1299,1499,1999];
  const v = pool[Math.floor(Math.random() * pool.length)];
  document.getElementById('amount').value = v;
  document.getElementById('btn-amt').textContent = v;
}

function formatCardNumber(el) {
  let v = el.value.replace(/\D/g, '').substring(0, 16);
  el.value = v.replace(/(.{4})/g, '$1 ').trim();
  el.classList.toggle('filled', v.length > 0);
  const brand = document.getElementById('card-brand');
  if      (v.startsWith('4'))  { brand.textContent = 'VISA'; brand.style.color = '#1a1f71'; }
  else if (v.startsWith('5'))  { brand.textContent = 'MC';   brand.style.color = '#eb001b'; }
  else if (v.startsWith('37')) { brand.textContent = 'AMEX'; brand.style.color = '#007bc1'; }
  else                         { brand.textContent = ''; }
}

function formatExpiry(el) {
  let v = el.value.replace(/\D/g, '').substring(0, 4);
  if (v.length >= 3) el.value = v.substring(0,2) + ' / ' + v.substring(2);
  else               el.value = v;
}

function fillCard(number, expiry, cvc, name) {
  const numFormatted = number.replace(/(.{4})/g, '$1 ').trim();
  document.getElementById('card-number').value = numFormatted;
  document.getElementById('card-expiry').value = expiry.substring(0,2) + ' / ' + expiry.substring(3);
  document.getElementById('card-cvc').value    = cvc;
  document.getElementById('card-name').value   = name;
  formatCardNumber(document.getElementById('card-number'));
  ['card-number','card-expiry','card-cvc','card-name'].forEach(id => {
    const el = document.getElementById(id);
    el.classList.add('filled');
    el.style.transition = 'background 0.3s';
    el.style.background = '#f0f4ff';
    setTimeout(() => { el.style.background = '#fff'; }, 500);
  });
  hideAlerts();
}

function handlePay() {
  hideAlerts();
  const amount = parseInt(document.getElementById('amount').value);
  const number = document.getElementById('card-number').value.replace(/\s/g, '');
  const expiry = document.getElementById('card-expiry').value.trim();
  const cvc    = document.getElementById('card-cvc').value.trim();
  const name   = document.getElementById('card-name').value.trim();

  if (!amount || amount < 1)  { showAlert('warning', 'Please enter a valid amount to continue.'); return; }
  if (number.length < 13)     { showAlert('warning', 'Please enter a valid card number.'); return; }
  if (!expiry || expiry.length < 4) { showAlert('warning', "Please enter your card's expiry date."); return; }
  if (!cvc || cvc.length < 3) { showAlert('warning', "Please enter your card's security code."); return; }
  if (!name)                  { showAlert('warning', 'Please enter the name on your card.'); return; }

  const btn = document.getElementById('pay-btn');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner"></span>Processing...';

  // Submit the form to Laravel after 1.2s delay
  setTimeout(() => {
    document.getElementById('payment-form').submit();
  }, 1200);
}

function showAlert(type, msg) {
  hideAlerts();
  document.getElementById('msg-' + type).textContent = msg;
  const el = document.getElementById('al-' + type);
  el.style.display = 'block';
  el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function hideAlerts() {
  ['success','error','warning'].forEach(t => {
    document.getElementById('al-' + t).style.display = 'none';
  });
}
</script>
</body>
</html>