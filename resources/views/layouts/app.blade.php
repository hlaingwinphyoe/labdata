<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title',"Lab Data")</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

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

    <!-- Stylesheet -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('head')
</head>

<body>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
<div class="container-fluid position-relative d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner"
         class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <span class="loader"></span>
    </div>
    <!-- Spinner End -->


    <!-- Sidebar Start -->
@include('layouts.sidebar')
<!-- Sidebar End -->


    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
    @include('layouts.header')
    <!-- Navbar End -->

        @yield('content')

    </div>
    <!-- Content End -->

</div>

<!-- JavaScript -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
</script>

@yield('foot')

<!-- Success Message Start -->
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

@if(session('success'))
    <script>
        Swal.fire(
            'Success',
            '{{ session('success') }}',
            'success'
        )
    </script>
@endif
<!-- Success Message End -->

<!-- Denied Message Start -->
@if(session('denied'))
    <script>
        Swal.fire({
            icon: 'error',
            text: "{{ session('denied') }}",
        })
    </script>
@endif
<!-- Denied Message End -->

<script>
    function askConfirm(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: 'var(--bs-primary)',
            cancelButtonColor: '#ff0000',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#delForm' + id).submit();
            }
        })
    }

    function makeAdmin(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "Role ပြောင်းလဲလိုက်လျှင် Admin လုပ်ပိုင်ခွင့်များရရှိသွားမှာဖြစ်ပါတယ်။",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6f42c1',
            cancelButtonColor: '#ff0000',
            confirmButtonText: 'Yes, I Agree'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#makeAdminForm' + id).submit();
            }
        })
    }

    function changeConfirm(){
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to change your password?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6f42c1',
            cancelButtonColor: '#ff0000',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#changeForm').submit();
            }
        })
    }
</script>

@stack('script')
</body>

</html>

