<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @include('layouts.styles')
</head>
<body>
<div id="app">
    @include('layouts.header')
    <main class="py-4">
        <div class="container">
            @section('breadcrumbs', Breadcrumbs::render())
            @yield('breadcrumbs')
            @yield('content')
        </div>
    </main>
</div>
@include('layouts.footer')
@include('layouts.scripts')
@stack('scripts')
</body>
</html>
