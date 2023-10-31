<head>
    <meta charset="utf-8" />
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>{{ config('app.name') . '  ' . ($title ?? '') }}</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/material-kit.css_v=1.2.1.css') }}" rel="stylesheet" />

    @stack('css')
</head>

<body class="ecommerce-page">
    @include('layout_frontpage.navbar')

    <div class="page-header header-filter header-small" data-parallax="true"
        style="background-image: url('https://images.unsplash.com/photo-1510698454686-1e2552e058e0?auto=format&fit=crop&q=80&w=2071&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); transform: translate3d(0px, 0px, 0px);">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="brand">
                        <h1 class="title">Find Your Statdium</h1>
                        <h4>Free global delivery for all products. Use coupon <b>25summer</b> for an extra 25% Off</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main main-raised" style="margin-bottom: 50px">
        @include('layout_frontpage.recommemd')

        <div class="section">
            <div class="container">
                <h2 class="section-title">Find what you need</h2>
                <div class="row">
                    @include('layout_frontpage.sidebar')

                    <div class="col-md-9">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div><!-- section -->

    </div> <!-- end-main-raised -->

    <!-- section -->



    @include('layout_frontpage.footer')



    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/material.min.js') }}"></script>


    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select   -->
    <script src="{{ asset('js/bootstrap-selectpicker.js') }}" type="text/javascript"></script>

    <!--	Plugin for Tags, full documentation here: http://xoxco.com/projects/code/tagsinput/   -->
    <script src="{{ asset('js/bootstrap-tagsinput.js') }}"></script>

    <!--    Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc    -->
    <script src="{{ asset('js/material-kit.js_v=1.2.1') }}" type="text/javascript"></script>

    @stack('js')

</body>
