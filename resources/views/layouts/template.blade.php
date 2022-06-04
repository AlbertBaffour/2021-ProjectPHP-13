<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.2">
{{--   Favicon--}}
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/images/favicon/site.webmanifest">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="{{asset('jqueryui/jquery-ui.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
    <title>@yield('title', 'Onkostenvergoeding')</title>

</head>
<body>

@include('shared.navigation')

<main class="mt-3 p-2 mb-5 pb-5 m-auto hulpmenu min-h">

    @yield('main', 'Page under construction...')
</main>
@include('shared.footer')

<script src="https://kit.fontawesome.com/647ad2b9ab.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('jquery-3.3.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('jqueryui/jquery-ui.min.js')}}" type="text/javascript"></script>

@yield('script_after')
</body>
</html>


