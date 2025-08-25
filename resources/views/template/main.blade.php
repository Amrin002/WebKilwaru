<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Kilwaru - Website Resmi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Di bagian <head> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/styles.css') }}">
    <!-- RSS Feed -->
    <link rel="alternate" type="application/rss+xml" title="{{ config('app.village_name') }} - Berita RSS"
        href="{{ route('berita.rss') }}">

    <!-- Sitemap untuk search engines -->
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ route('berita.sitemap') }}">
    <!-- RSS Feed Auto-discovery -->
    <link rel="alternate" type="application/rss+xml" title="{{ config('app.village_name') }} - RSS Feed"
        href="{{ route('berita.rss') }}">
    {{-- Tambahan style --}}
    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    @include('template.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('template.footer')

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('asset/js.js') }}"></script>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>

</html>
