<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session()->has('dark-theme') ? 'tw-dark' : '' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia> {{ config('app.name', 'E-Store') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logos/logo.png') }}">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    
    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body>
    @inertia

    <script src="{{ asset('assets/limitless_theme/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/limitless_theme/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/limitless_theme/plugins/loaders/blockui.min.js') }}"></script>
    <script src="{{ asset('assets/limitless_theme/plugins/notifications/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('assets/limitless_theme/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/limitless_theme/js/theme.js') }}"></script>
</body>

</html>
