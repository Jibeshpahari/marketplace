<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Character encoding & compatibility -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Viewport -->
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- SEO & indexing -->
    <meta name="description" content="Admin Login" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="theme-color" content="#ffffff" />

    <!-- Dynamic Admin title -->
    <title>{{ empty($title) ? '' : $title . ' | ' }}{{ setting('site_title') }}</title>

    <!-- Favicon set -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/global/images/favicon.ico') }}" />
    {{-- <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/global/images/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/global/images/favicon-16x16.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/global/images/apple-touch-icon.png') }}" /> --}}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
    <!-- Font Awesome 7 -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/fontawesome-7.3.1.min.css') }}">
    <!-- Date Time Picker -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/date-time-picker.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">

    <!-- jQuery -->
    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <!-- WebFont Loader -->
    <script src="{{ asset('assets/admin/js/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: [
                    "Public Sans:300,400,500,600,700",
                    "DM Sans:300,400,500,600",
                    "Syne:700,800",
                    "Poppins:300,400,500,600,700,800",
                    "Inter:300,400,500,600,700"
                ]
            },
            custom: {
                // Font Awesome is loaded separately above (fontawesome-7.3.1.min.css),
                // so only Simple Line Icons is preloaded here to avoid duplicate icon fonts.
                families: [
                    "simple-line-icons",
                ],
                urls: ["{{ asset('assets/admin/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- App Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}?v={{ time() }}" />

    @stack('cdn')
    @stack('css')
</head>

<body>

    <!-- ═══════════════ SIDEBAR ═══════════════ -->
    @include('admin.layout.components.sidebar')

    <!-- ═══════════════ MAIN AREA ═══════════════ -->
    <div id="main">

        <!-- TOP SEARCH BAR -->
        @include('admin.layout.components.searchbar')

        <!-- SUB NAVBAR -->
        {{-- @include('admin.layout.components.navbar') --}}

        <!-- BOTTOM PROGRESS/STATUS BAR -->
        @include('admin.layout.components.statusbar')

        <!-- ALERTS OVERLAY -->
        @include('admin.layout.components.alerts')

        <!-- PAGE CONTENT -->
        <div id="content">
            <!-- PAGE CONTENT HEADER -->
            <div class="page-header">
                <div>

                    @isset($nav)
                        <nav class="breadcrumb-nav">
                            @foreach ($nav as $item)
                                @if (!$loop->last)
                                    <a class="bc-item" href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                                    <span class="bc-sep">/</span>
                                @else
                                    <span class="bc-current">{{ $item['name'] }}</span>
                                @endif
                            @endforeach
                        </nav>
                    @endisset

                    <h1 class="page-title">
                        {{ $title ?? '' }}
                    </h1>
                    <p class="page-sub">
                        {{ $sub_title ?? '' }}
                    </p>
                </div>
                <div class="d-flex gap-2">
                    {{-- //TODO - Action BUtton --}}
                </div>
            </div>

            <main id="page-content">
                @yield('content')
            </main>
        </div>

    </div>

    <!-- TOAST STRIP (global, outside main) -->
    <div class="toast-strip" id="toastStrip"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/script.js') }}"></script>
    <script src="{{ asset('assets/global/js/date-time-picker.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/summernote-lite.min.js') }}"></script>

    @stack('js')
    @stack('modal')

    <script>
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });

        document.querySelectorAll('[data-bs-custom-class="tooltip-pinned"]').forEach(el => {
            bootstrap.Tooltip.getInstance(el)?.dispose();
            const pinnedTip = new bootstrap.Tooltip(el, {
                trigger: 'manual',
                customClass: 'tooltip-pinned'
            });
            requestAnimationFrame(() => pinnedTip.show());
        });
    </script>

</body>

</html>
