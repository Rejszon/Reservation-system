<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes.head')
@vite('resources/css/app.css')
<body>
    @include('includes.navbar')
    <div class="content">
        @yield('main')
         
    </div>
    @include('includes.footer')
    @stack('scripts')
</body>

</html>
