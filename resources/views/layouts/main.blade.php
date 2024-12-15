<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes.head')
@vite('resources/css/app.css')
<body>
    @include('includes.navbar')

    @yield('main')

    @include('includes.footer')
</body>

</html>