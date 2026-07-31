<div id="sidebar">

    <div class="sidebar-logo">
        <div class="logo-mark">N</div>
        <span class="logo-text">Nova<span>Hub</span></span>
    </div>

    <nav class="nav-section">

        <p class="nav-label">Main</p>

        <ul class="nav-list">

            <li class="nav-item" data-tip="Dashboard">
                <a href="#">
                    <span class="nav-icon"><i class="fa-solid fa-gauge-high"></i></span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item has-sub" data-tip="Analytics">
                <a href="#">
                    <span class="nav-icon"><i class="fa-solid fa-chart-line"></i></span>
                    <span class="nav-text">Analytics</span>
                    <i class="fa-solid fa-chevron-right nav-arrow"></i>
                </a>
                <ul class="sub-menu">
                    <li class="sub-item"><span class="sub-dot"></span>Overview</li>
                    <li class="sub-item"><span class="sub-dot"></span>Reports</li>
                    <li class="sub-item"><span class="sub-dot"></span>Real-time</li>
                </ul>
            </li>

            <li class="nav-item has-sub {{ isActive('admin.products.*') ? 'active open' : '' }}" data-tip="Products">
                <a href="javascript:void(0)">
                    <span class="nav-icon"><i class="fa-solid fa-box-open"></i></span>
                    <span class="nav-text">Products</span>
                    <span class="nav-badge">12</span>
                    <i class="fa-solid fa-chevron-right nav-arrow"></i>
                </a>
                <ul class="sub-menu {{ isActive('admin.products.*') ? 'open' : '' }}">
                    <li class="sub-item {{ isActive('admin.products.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.products.index') }}"></span>Listing</a>
                    </li>
                    <li class="sub-item">
                        <a href="{{ route('admin.products.index') }}"></span>Inventory</a>
                    </li>
                    <li class="sub-item">
                        <a href="{{ route('admin.products.index') }}"></span>Pricing</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ isActive('admin.categories.*') ? 'active' : '' }}" data-tip="Orders">
                <a href="{{ route('admin.categories.index') }}">
                    <span class="nav-icon"><i class="fa-solid fa-chart-diagram"></i></span>
                    <span class="nav-text">Categories</span>
                    <span class="nav-badge">5</span>
                </a>
            </li>

            <li class="nav-item" data-tip="Orders">
                <a href="#">
                    <span class="nav-icon"><i class="fa-solid fa-bag-shopping"></i></span>
                    <span class="nav-text">Orders</span>
                    <span class="nav-badge">5</span>
                </a>
            </li>

            <li class="nav-item" data-tip="Customers">
                <a href="#">
                    <span class="nav-icon"><i class="fa-solid fa-users"></i></span>
                    <span class="nav-text">Customers</span>
                </a>
            </li>

        </ul>
        <p class="nav-label" style="margin-top:12px;">Management</p>

        <ul class="nav-list">
            <li class="nav-item has-sub {{ isActive('admin.settings.*') ? 'active open' : '' }}" data-tip="Settings">
                <a href="javascript:void(0)">
                    <span class="nav-icon"><i class="fa-solid fa-sliders"></i></span>
                    <span class="nav-text">Settings</span>
                    <i class="fa-solid fa-chevron-right nav-arrow"></i>
                </a>
                <ul class="sub-menu {{ isActive('admin.settings.*') ? 'open' : '' }}">
                    <li class="sub-item {{ isActive('admin.settings.site-settings') ? 'active' : '' }}">
                        <a href="{{ route('admin.settings.site-settings') }}">General</a>
                    </li>
                    <li class="sub-item {{ isActive('admin.settings.security') ? 'active' : '' }}">
                        <a
                            href="{{ Route::has('admin.settings.security') ? route('admin.settings.security') : 'javascript:void(0)' }}">Security</a>
                    </li>
                    <li class="sub-item {{ isActive('admin.settings.integrations') ? 'active' : '' }}">
                        <a
                            href="{{ Route::has('admin.setting.integrations') ? route('admin.settings.integrations') : 'javascript:void(0)' }}"><span
                                class="sub-dot"></span>Integrations</a>
                    </li>
                    <li class="sub-item {{ isActive('admin.settings.billing') ? 'active' : '' }}">
                        <a
                            href="{{ Route::has('admin.settings.billing') ? route('admin.settings.billing') : 'javascript:void(0)' }}"><span
                                class="sub-dot"></span>Billing</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item" data-tip="Team">
                <a href="#">
                    <span class="nav-icon"><i class="fa-solid fa-user-group"></i></span>
                    <span class="nav-text">Team</span>
                </a>
            </li>

            <li class="nav-item" data-tip="Support">
                <a href="#">
                    <span class="nav-icon"><i class="fa-regular fa-circle-question"></i></span>
                    <span class="nav-text">Help &amp; Support</span>
                </a>
            </li>

        </ul>

    </nav>
    <div class="sidebar-profile d-none">
        <div class="profile-avatar">JD</div>
        <div class="profile-info">
            <div class="profile-name">John Doe</div>
            <div class="profile-role">Administrator</div>
        </div>
        <i class="fa-solid fa-ellipsis profile-more"></i>
    </div>

    <div class="sidebar-toggle" id="sidebarToggle">
        <i class="fa-solid fa-chevron-left"></i>
    </div>

</div>

@push('js')
    <script>
        $(function() {

            $('#sidebarToggle').on('click', function() {
                $('#sidebar').toggleClass('collapsed');
                $('body').toggleClass('collapsed');
            });

            $('.has-sub').on('click', function(e) {
                if ($(e.target).closest('.sub-menu').length) return;

                var $item = $(this);
                var $sub = $item.find('.sub-menu');
                var isOpen = $item.hasClass('open');

                $('.has-sub.open').not($item).removeClass('open')
                    .find('.sub-menu').removeClass('open');

                $item.toggleClass('open', !isOpen);
                $sub.toggleClass('open', !isOpen);
            });

            $('.sub-menu').each(function() {
                if ($(this).find('.sub-item.active').length) {
                    $(this).addClass('open')
                        .closest('.has-sub').addClass('open');
                }
            });

        });
    </script>
@endpush
