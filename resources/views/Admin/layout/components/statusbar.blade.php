<div id="notice-bar" class="hidden">

    <i class="notice-icon fa-solid fa-circle-info"></i>

    <div class="notice-msg">
        <strong id="noticeTitle">Heads up!</strong>
        <span id="noticeText">Your trial ends in 3 days. Upgrade to keep access.</span>
    </div>

    <span class="notice-action" id="noticeAction">Upgrade now</span>
    <span class="notice-sep"></span>

    <span class="notice-dismiss" id="noticeDismiss">
        <i class="fa-solid fa-xmark"></i>
    </span>

    <div class="notice-progress-track">
        <div class="notice-progress-fill"></div>
    </div>

</div>

@push('js')
<script>
    /* ════════════════════════════════════════════════════════
       Notice bar API
       Call showNotice(type) from any child view
       Types: 'info' | 'success' | 'warning' | 'error' | 'progress'
       ════════════════════════════════════════════════════════ */
    const NOTICE_CONFIG = {
        info: {
            icon    : 'fa-solid fa-circle-info',
            title   : 'Heads up!',
            msg     : 'Your trial ends in 3 days. Upgrade to keep access.',
            action  : 'Upgrade now',
        },
        success: {
            icon    : 'fa-solid fa-circle-check',
            title   : 'Backup complete.',
            msg     : 'New backup successfully created at 14:32.',
            action  : 'View details',
        },
        warning: {
            icon    : 'fa-solid fa-triangle-exclamation',
            title   : 'Storage at 85%.',
            msg     : 'You are approaching your storage limit.',
            action  : 'Manage storage',
        },
        error: {
            icon    : 'fa-solid fa-circle-xmark',
            title   : 'Sync failed.',
            msg     : 'Could not connect to the data source.',
            action  : 'Retry now',
        },
        progress: {
            icon    : 'fa-solid fa-rotate',
            title   : 'Importing data…',
            msg     : 'Processing records. Please wait.',
            action  : 'View progress',
            pulse   : true,
        },
    };

    function showNotice(type, options = {}) {
        const cfg  = { ...NOTICE_CONFIG[type], ...options };
        const $bar = $('#notice-bar');

        $bar.removeClass('hidden info success warning error progress');
        $bar.find('.notice-icon').attr('class', 'notice-icon ' + cfg.icon);
        $bar.find('#noticeTitle').text(cfg.title);
        $bar.find('#noticeText').text(cfg.msg);
        $bar.find('#noticeAction').text(cfg.action);
        $bar.find('.notice-pulse').remove();

        if (cfg.pulse) {
            $bar.find('.notice-icon').after('<span class="notice-pulse"></span>');
        }

        if (cfg.actionUrl) {
            $bar.find('#noticeAction').attr('onclick', `window.location='${cfg.actionUrl}'`).css('cursor', 'pointer');
        }

        $bar.addClass(type);
    }

    function hideNotice() {
        $('#notice-bar').addClass('hidden');
    }

    /* Dismiss on click */
    $(function () {
        $('#noticeDismiss').on('click', function () {
            hideNotice();
        });
    });
</script>
@endpush