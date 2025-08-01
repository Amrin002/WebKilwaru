<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Desa Sejahtera</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('panel/assets/style.css') }}">
    @stack('style')
</head>

<body>
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        @include('layouts.header')

        @yield('content')
    </main>

    <script src="{{ asset('panel/assets/javascript.js') }}"></script>
    @stack('script')
</body>

</html>
