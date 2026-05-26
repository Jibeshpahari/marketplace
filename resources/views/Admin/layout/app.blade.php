<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Character encoding & compatibility -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Viewport: strict, no user scaling (from Header 2) -->
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- SEO & indexing (from Header 1) -->
    <meta name="description" content="Admin Login" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="theme-color" content="#ffffff" />

    <!-- Dynamic title (from Header 2) -->
    <title>{{ get_option('site_title') }}{{ empty($title) ? '' : ' | ' . $title }}</title>

    <!-- Favicon set (from Header 1 — more complete) -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/global/images/favicon.ico') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/global/images/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/global/images/favicon-16x16.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/global/images/apple-touch-icon.png') }}" />

    <!-- CSRF Token (Laravel) -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Bootstrap CSS (from Header 1) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons (from Header 1) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />

    <!-- Font Awesome 6 (from Header 2 — newer version) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <!-- WebFont Loader for Google + custom fonts (from Header 2) -->
    <script src="{{ asset('assets/admin/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700", "DM+Sans:300,400,500,600", "Syne:700,800"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('assets/admin/css/fonts.min.css') }}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- App Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}?v={{ time() }}" />
    <link href="{{ asset('assets/global/css/login.css') }}" rel="stylesheet" />

    @stack('cdn')
    @stack('css')
</head>
<body>

    @stack('modal')

    @stack('js')
</body>
</html>