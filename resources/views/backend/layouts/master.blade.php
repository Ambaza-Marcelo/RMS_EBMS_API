<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'MSSMS Role Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('backend.layouts.partials.styles')
    @yield('styles')
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">

       @include('backend.layouts.partials.sidebar')

        <!-- main content area start -->
        <div class="main-content">
            @include('backend.layouts.partials.header')
            @yield('admin-content')
        </div>
        <!-- main content area end -->
        @include('backend.layouts.partials.footer')
    </div>
    <!-- page container area end -->

    @include('backend.layouts.partials.offsets')
    @include('backend.layouts.partials.scripts')
    @yield('scripts')
    <script type="text/javascript">
            var url = "{{ route('changeLang')}}";
            $(".changeLang").change(function(){
                window.location.href = url + "?lang=" + $(this).val();
            });
            /*

            Echo.private('events')
    .listen('RealTimeMessage', (e) => console.log('Private RealTimeMessage: ' + e.message)); */
    </script>
</body>

</html>