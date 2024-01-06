<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>


        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
              type="text/css">

        <link href="{{ asset('assets/limitless_theme/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/limitless_theme/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/limitless_theme/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/limitless_theme/css/layout.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/limitless_theme/css/components.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/limitless_theme/css/colors.min.css') }}" rel="stylesheet" type="text/css">

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia

        <script src="{{ asset('assets/limitless_theme/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/limitless_theme/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/limitless_theme/plugins/loaders/blockui.min.js') }}"></script>
        <script src="{{ asset('assets/limitless_theme/plugins/forms/styling/uniform.min.js') }}"></script>
        <script src="{{ asset('assets/limitless_theme/plugins/forms/selects/select2.min.js') }}"></script>
        <script src="{{ asset('assets/limitless_theme/js/theme.js') }}"></script>
    </body>
</html>
