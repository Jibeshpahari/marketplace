<div id="topbar">
      <div class="search-wrap">
        <div class="search-box">
          <i class="fa-solid fa-magnifying-glass s-icon"></i>
          <input type="text" placeholder="Search anything…" id="searchInput">
          <div class="search-kbd">
            <span class="kbd">⌘</span>
            <span class="kbd">K</span>
          </div>
        </div>
      </div>
      <div class="d-flex align-items-center gap-2">
        <div class="top-btn"><i class="fa-regular fa-moon"></i></div>
        <div class="top-btn" onclick="showAlert('info')">
          <i class="fa-regular fa-bell"></i>
          <span class="notif-dot"></span>
        </div>
        <div class="top-btn" onclick="showNotice('progress')"><i class="fa-solid fa-rotate"></i></div>
        <div class="avatar-btn">JD</div>
      </div>
    </div>

@push('js')
<script>
$(function () {

    /* ⌘K / Ctrl+K focus search */
    $(document).on('keydown', function (e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            $('#searchInput').focus();
        }
        if (e.key === 'Escape') {
            $('#searchInput').blur();
        }
    });

    /* Dark mode toggle */
    $('#darkModeBtn').on('click', function () {
        $('body').toggleClass('dark-mode');
        const isDark = $('body').hasClass('dark-mode');
        $(this).find('i').toggleClass('fa-moon', !isDark).toggleClass('fa-sun', isDark);
        localStorage.setItem('darkMode', isDark ? '1' : '0');
    });

    /* Restore dark mode preference on load */
    if (localStorage.getItem('darkMode') === '1') {
        $('body').addClass('dark-mode');
        $('#darkModeBtn i').removeClass('fa-moon').addClass('fa-sun');
    }

});
</script>
@endpush