<div class="alert-overlay" id="alertOverlay" onclick="handleAlertBg(event)">
    <div class="alert-popup" id="alertPopup">
        {{-- Injected by showAlert() --}}
    </div>
</div>

@push('js')
<script>
    /* ════════════════════════════════════════════════════════
       Alert overlay API
       Call showAlert(type) from any child view
       Types: 'success' | 'error' | 'warning' | 'info' | 'confirm'
       ════════════════════════════════════════════════════════ */
    const ALERT_CONFIG = {
        success: {
            badge      : 'Completed',
            badgeStyle : 'background:rgba(22,163,74,.1);color:#16a34a;border:1px solid rgba(22,163,74,.25)',
            ring       : 'rgba(22,163,74,.1)',
            ringColor  : '#16a34a',
            icon       : '✓',
            accent     : '#16a34a',
            accentTxt  : '#fff',
            title      : 'Action successful!',
            text       : 'The operation was completed successfully.',
            primary    : 'Continue',
            ghost      : 'Close',
        },
        error: {
            badge      : 'Error',
            badgeStyle : 'background:rgba(220,38,38,.08);color:#dc2626;border:1px solid rgba(220,38,38,.2)',
            ring       : 'rgba(220,38,38,.1)',
            ringColor  : '#dc2626',
            icon       : '✕',
            accent     : '#dc2626',
            accentTxt  : '#fff',
            title      : 'Something went wrong',
            text       : 'An unexpected error occurred. Please try again.',
            primary    : 'Try again',
            ghost      : 'Cancel',
        },
        warning: {
            badge      : 'Warning',
            badgeStyle : 'background:rgba(217,119,6,.1);color:#d97706;border:1px solid rgba(217,119,6,.25)',
            ring       : 'rgba(217,119,6,.1)',
            ringColor  : '#d97706',
            icon       : '⚠',
            accent     : '#d97706',
            accentTxt  : '#fff',
            title      : 'Are you sure?',
            text       : 'This action may have unintended consequences.',
            primary    : 'Proceed',
            ghost      : 'Go back',
        },
        info: {
            badge      : "Info",
            badgeStyle : 'background:rgba(14,165,233,.1);color:#0ea5e9;border:1px solid rgba(14,165,233,.25)',
            ring       : 'rgba(14,165,233,.1)',
            ringColor  : '#0ea5e9',
            icon       : '✦',
            accent     : '#0ea5e9',
            accentTxt  : '#fff',
            title      : 'Good to know',
            text       : 'Here is some information you might find useful.',
            primary    : 'Got it',
            ghost      : 'Dismiss',
        },
        confirm: {
            badge      : 'Destructive',
            badgeStyle : 'background:rgba(220,38,38,.08);color:#dc2626;border:1px solid rgba(220,38,38,.2)',
            ring       : 'rgba(220,38,38,.1)',
            ringColor  : '#dc2626',
            icon       : '⌫',
            accent     : '#dc2626',
            accentTxt  : '#fff',
            title      : 'Are you absolutely sure?',
            text       : 'This action is permanent and cannot be undone.',
            primary    : 'Yes, delete it',
            ghost      : 'Keep it safe',
            confirm    : true,
        },
    };

    let _confirmChecked = false;
    let _onConfirmCallback = null;

    function showAlert(type, options = {}, onConfirm = null) {
        const cfg = { ...ALERT_CONFIG[type], ...options };
        _confirmChecked    = false;
        _onConfirmCallback = onConfirm;

        const confirmExtra = cfg.confirm ? `
            <div class="alert-confirm-row" onclick="toggleAlertConfirm(this)">
                <div class="alert-confirm-box" id="alertConfirmBox"></div>
                <span class="alert-confirm-label">I understand this cannot be undone</span>
            </div>` : '';

        document.getElementById('alertPopup').innerHTML = `
            <button class="alert-btn-close" onclick="closeAlert()">✕</button>
            <span class="alert-badge" style="${cfg.badgeStyle}">${cfg.badge}</span>
            <div class="alert-icon-ring" style="background:${cfg.ring};color:${cfg.ringColor}">${cfg.icon}</div>
            <h3>${cfg.title}</h3>
            <p>${cfg.text}</p>
            ${confirmExtra}
            <div class="alert-btn-row">
                <button class="alert-btn" id="alertPrimaryBtn"
                    style="background:${cfg.accent};color:${cfg.accentTxt}">${cfg.primary}</button>
                <button class="alert-btn alert-btn-ghost" onclick="closeAlert()">${cfg.ghost}</button>
            </div>`;

        document.getElementById('alertPrimaryBtn').onclick = function () {
            if (cfg.confirm && !_confirmChecked) {
                shakeAlert();
                return;
            }
            closeAlert();
            if (typeof _onConfirmCallback === 'function') {
                _onConfirmCallback();
            }
            fireToast(type, cfg);
        };

        document.getElementById('alertOverlay').classList.add('open');
    }

    function closeAlert() {
        document.getElementById('alertOverlay').classList.remove('open');
    }

    function handleAlertBg(e) {
        if (e.target === document.getElementById('alertOverlay')) {
            closeAlert();
        }
    }

    function toggleAlertConfirm(row) {
        _confirmChecked = !_confirmChecked;
        const box = document.getElementById('alertConfirmBox');
        box.classList.toggle('checked', _confirmChecked);
        box.textContent   = _confirmChecked ? '✓' : '';
        row.style.borderColor = _confirmChecked ? 'rgba(220,38,38,0.4)' : '';
    }

    function shakeAlert() {
        const p = document.getElementById('alertPopup');
        p.style.animation = 'none';
        p.offsetHeight;
        p.style.animation = 'aShake 0.4s ease';
    }

    /* ════════════════════════════════════════════════════════
       Toast API
       Call fireToast(type, cfg) or use via showAlert callback
       ════════════════════════════════════════════════════════ */
    function fireToast(type, cfg) {
        const strip = document.getElementById('toastStrip');
        const t     = document.createElement('div');
        t.className = 'toast-item';
        t.innerHTML = `
            <div class="toast-indicator" style="background:${cfg.accent}"></div>
            <div class="toast-icon" style="background:${cfg.ring};color:${cfg.ringColor}">${cfg.icon}</div>
            <div class="flex-grow-1">
                <div class="toast-title">${type.charAt(0).toUpperCase() + type.slice(1)}</div>
                <div class="toast-msg">${cfg.title}</div>
            </div>
            <span class="toast-x" onclick="this.closest('.toast-item').remove()">✕</span>
            <div class="toast-progress" style="background:${cfg.accent}"></div>`;

        strip.appendChild(t);
        requestAnimationFrame(() => requestAnimationFrame(() => t.classList.add('show')));

        let timer = setTimeout(dismiss, 3200);

        function dismiss() {
            t.classList.remove('show');
            setTimeout(() => t.remove(), 400);
        }

        t.addEventListener('mouseenter', () => {
            clearTimeout(timer);
            t.querySelector('.toast-progress').style.animationPlayState = 'paused';
        });

        t.addEventListener('mouseleave', () => {
            t.querySelector('.toast-progress').style.animationPlayState = 'running';
            timer = setTimeout(dismiss, 1500);
        });
    }

    /* Shake keyframe */
    const _shakeStyle       = document.createElement('style');
    _shakeStyle.textContent = '@keyframes aShake{0%,100%{transform:translateX(0) scale(1)}20%{transform:translateX(-8px)}40%{transform:translateX(8px)}60%{transform:translateX(-5px)}80%{transform:translateX(5px)}}';
    document.head.appendChild(_shakeStyle);
</script>
@endpush