<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>@yield('title')</title>
    @yield('style')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('layouts.components.public.header')
    <div class="container mt-4 flex-grow-1">
        @yield('content')
    </div>
    @include('layouts.components.public.footer')

    <script src="https://code.jquery.com/jquery-3.7.1.slim.js"
        integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    @yield('script')
</body>

</html>
