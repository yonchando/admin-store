<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session()->has('dark-theme') ? 'dark' : '' }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia> {{ config('app.name', 'E-Store') }}</title>

        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
              type="text/css">

        <link rel="shortcut icon" href="{{asset('assets/images/logos/logo.png')}}">

        <link rel="stylesheet" href="{{asset('assets/icons/icomoon/styles.min.css')}}">
        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>

    <body>
        @inertia
    </body>

</html>
