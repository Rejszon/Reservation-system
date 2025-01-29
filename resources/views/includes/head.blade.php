<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <script src="//unpkg.com/alpinejs" defer></script>
    @vite('resources/js/app.js')
</head>