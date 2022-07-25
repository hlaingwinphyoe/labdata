<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title',"550 MCH Lab")</title>

    <meta name="description" content="Laboratory workload data per day."/>
    <meta name="keywords" content="550, lab data, 550 laboratory, laboratory data, tests, clinicallabdata, clinical laboratory"/>
    <meta name="author" content="Hlaing Win Phyoe"/>

    <!-- Facebook and Twitter integration -->
    <meta property="og:title" content="550 Lab Data"/>
    <meta property="og:image" content="{{ asset('site.png') }}"/>
    <meta property="og:url" content="https://clinicallabdata.info/"/>
    <meta property="og:site_name" content="550 MCH Lab Data"/>
    <meta property="og:description" content="Laboratory workload data per day."/>

    <!-- Favicon -->
    <link href="{{ asset('logo.png') }}" rel="icon">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="550Lab">
    <link rel="icon" sizes="192x192" href="{{ asset('image/icons/android-icon-192x192.png') }}">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="550Lab">
    <link rel="apple-touch-icon" href="{{ asset('image/icons/apple-icon-180x180.png') }}">

    <!-- PWA  -->
    <meta name="theme-color" content="#ffffff"/>
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @yield('head')
</head>
<body>
@yield('content')

<script src="{{ asset("js/custom.js") }}"></script>
<script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
</script>
@if(session('status'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            title: '{{ session('status') }}'
        })
    </script>

@endif
@stack('script')
</body>
</html>
