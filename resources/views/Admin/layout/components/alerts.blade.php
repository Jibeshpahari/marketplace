<div class="toast-strip" id="toastStrip"></div>

<div class="alert-overlay" id="alertOverlay">
    <div class="alert-popup" id="alertPopup"></div>
</div>

@if (session('success') || session('error') || session('warning') || session('info') || $errors->any())
    @push('js')
    <script>
        $(function () {
            @if ($errors->any())
                notify('error', @json($errors->first()), '{{ session('notify_mode', 'toast') }}');
            @else
                @php
                    $flashType = collect(['success', 'error', 'warning', 'info'])
                        ->first(fn ($t) => session()->has($t));
                    $flashMode = session('notify_mode', 'toast');
                @endphp
                notify('{{ $flashType }}', @json(session($flashType)), '{{ $flashMode }}');
            @endif
        });
    </script>
    @endpush
@endif

@push('js')
<script>
    const NOTIFY_CONFIG = {
        success: {
            icon: '✓', ring: 'rgba(22,163,74,.1)', ringColor: '#16a34a', accent: '#16a34a', accentTxt: '#fff',
            badge: 'Completed', badgeStyle: 'background:rgba(22,163,74,.1);color:#16a34a;border:1px solid rgba(22,163,74,.25)',
            title: 'Action successful!', primary: 'Continue', ghost: 'Close',
        },
        error: {
            icon: '✕', ring: 'rgba(220,38,38,.1)', ringColor: '#dc2626', accent: '#dc2626', accentTxt: '#fff',
            badge: 'Error', badgeStyle: 'background:rgba(220,38,38,.08);color:#dc2626;border:1px solid rgba(220,38,38,.2)',
            title: 'Something went wrong', primary: 'Try again', ghost: 'Cancel',
        },
        warning: {
            icon: '⚠', ring: 'rgba(217,119,6,.1)', ringColor: '#d97706', accent: '#d97706', accentTxt: '#fff',
            badge: 'Warning', badgeStyle: 'background:rgba(217,119,6,.1);color:#d97706;border:1px solid rgba(217,119,6,.25)',
            title: 'Are you sure?', primary: 'Proceed', ghost: 'Go back',
        },
        info: {
            icon: '✦', ring: 'rgba(14,165,233,.1)', ringColor: '#0ea5e9', accent: '#0ea5e9', accentTxt: '#fff',
            badge: 'Info', badgeStyle: 'background:rgba(14,165,233,.1);color:#0ea5e9;border:1px solid rgba(14,165,233,.25)',
            title: 'Good to know', primary: 'Got it', ghost: 'Dismiss',
        },
        confirm: {
            icon: '⌫', ring: 'rgba(220,38,38,.1)', ringColor: '#dc2626', accent: '#dc2626', accentTxt: '#fff',
            badge: 'Destructive', badgeStyle: 'background:rgba(220,38,38,.08);color:#dc2626;border:1px solid rgba(220,38,38,.2)',
            title: 'Are you absolutely sure?', primary: 'Yes, delete it', ghost: 'Keep it safe', confirm: true,
        },
    };

    function notify(type, message, mode = 'toast', onConfirm = null) {
        if (mode === 'toast' || mode === 'both') {
            fireToast(type, message);
        }
        if (mode === 'alert' || mode === 'both') {
            showAlert(type, { text: message }, onConfirm);
        }
    }

    function fireToast(type, message) {
        const cfg = NOTIFY_CONFIG[type];
        const $t = $(`
            <div class="toast-item">
                <div class="toast-icon" style="background:${cfg.ring};color:${cfg.ringColor}">${cfg.icon}</div>
                <div class="flex-grow-1">
                    <div class="toast-title">${type.charAt(0).toUpperCase() + type.slice(1)}</div>
                    <div class="toast-msg">${message}</div>
                </div>
                <span class="toast-x">✕</span>
                <div class="toast-progress" style="background:${cfg.accent}"></div>
            </div>
        `);

        $t.find('.toast-x').on('click', () => $t.remove());
        $('#toastStrip').append($t);
        requestAnimationFrame(() => requestAnimationFrame(() => $t.addClass('show')));

        let timer = setTimeout(dismiss, 3200);

        function dismiss() {
            $t.removeClass('show');
            setTimeout(() => $t.remove(), 400);
        }

        $t.on('mouseenter', () => {
            clearTimeout(timer);
            $t.find('.toast-progress').css('animationPlayState', 'paused');
        });

        $t.on('mouseleave', () => {
            $t.find('.toast-progress').css('animationPlayState', 'running');
            timer = setTimeout(dismiss, 1500);
        });
    }

    let _confirmChecked = false;
    let _onConfirmCallback = null;

    function showAlert(type, options = {}, onConfirm = null) {
        const cfg = { ...NOTIFY_CONFIG[type], ...options };
        _confirmChecked = false;
        _onConfirmCallback = onConfirm;

        const confirmExtra = cfg.confirm ? `
            <div class="alert-confirm-row">
                <div class="alert-confirm-box" id="alertConfirmBox"></div>
                <span class="alert-confirm-label">I understand this cannot be undone</span>
            </div>` : '';

        const $popup = $('#alertPopup').html(`
            <button class="alert-btn-close">✕</button>
            <span class="alert-badge" style="${cfg.badgeStyle}">${cfg.badge}</span>
            <div class="alert-icon-ring" style="background:${cfg.ring};color:${cfg.ringColor}">${cfg.icon}</div>
            <h3>${cfg.title}</h3>
            <p>${cfg.text}</p>
            ${confirmExtra}
            <div class="alert-btn-row">
                <button class="alert-btn" id="alertPrimaryBtn" style="background:${cfg.accent};color:${cfg.accentTxt}">${cfg.primary}</button>
                <button class="alert-btn alert-btn-ghost" id="alertGhostBtn">${cfg.ghost}</button>
            </div>
        `);

        $popup.find('.alert-btn-close, #alertGhostBtn').on('click', closeAlert);

        $popup.find('.alert-confirm-row').on('click', function () {
            toggleAlertConfirm($(this));
        });

        $('#alertPrimaryBtn').on('click', function () {
            if (cfg.confirm && !_confirmChecked) {
                shakeAlert();
                return;
            }
            closeAlert();
            if (typeof _onConfirmCallback === 'function') {
                _onConfirmCallback();
            }
        });

        $('#alertOverlay').addClass('open');
    }

    function closeAlert() {
        $('#alertOverlay').removeClass('open');
    }

    function toggleAlertConfirm($row) {
        _confirmChecked = !_confirmChecked;
        const $box = $('#alertConfirmBox');
        $box.toggleClass('checked', _confirmChecked).text(_confirmChecked ? '✓' : '');
        $row.css('borderColor', _confirmChecked ? 'rgba(220,38,38,0.4)' : '');
    }

    function shakeAlert() {
        const $p = $('#alertPopup');
        $p.css('animation', 'none');
        $p[0].offsetHeight;
        $p.css('animation', 'aShake 0.4s ease');
    }

    $('#alertOverlay').on('click', function (e) {
        if (e.target === this) closeAlert();
    });

    $('<style>')
        .text('@keyframes aShake{0%,100%{transform:translateX(0) scale(1)}20%{transform:translateX(-8px)}40%{transform:translateX(8px)}60%{transform:translateX(-5px)}80%{transform:translateX(5px)}}')
        .appendTo('head');
</script>
@endpush