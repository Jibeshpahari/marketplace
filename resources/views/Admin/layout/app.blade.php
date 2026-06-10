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

    <!-- Dynamic title -->
    <title>{{ empty($title) ? '' : ' | ' . $title }}</title>

    <!-- Favicon set -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/global/images/favicon.ico') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/global/images/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/global/images/favicon-16x16.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/global/images/apple-touch-icon.png') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- WebFont Loader -->
    <script src="{{ asset('assets/admin/js/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700", "DM+Sans:300,400,500,600", "Syne:700,800"]
            },
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
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
    <link rel="stylesheet" href="{{ asset('assets/global/css/kaiadmin.css') }}" />
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
        @include('admin.layout.components.navbar')

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
                    <!-- @yield('header-actions') -->
                    <button class="sub-action-btn" onclick="showNotice('info')"><i class="fa-solid fa-circle-info"></i>
                        Notice</button>
                    <button class="sub-action-btn" onclick="showAlert('confirm')"><i
                            class="fa-solid fa-triangle-exclamation"></i>
                        Alert</button>
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
    <script src="{{ asset('assets/admin/js/script.js') }}"></script>
    @stack('js')
    @stack('modal')

</body>

</html>
