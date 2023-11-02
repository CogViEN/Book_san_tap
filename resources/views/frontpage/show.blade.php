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
    <link rel="stylesheet" href="{{ asset('css/select.min.css') }}">
</head>

<body class="product-page">
    <nav class="navbar navbar-default navbar-fixed-top navbar-color-on-scroll" color-on-scroll="100">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../presentation.html">{{ config('app.name') }}</a>
            </div>

            @include('layout_frontpage.navbar')
        </div>
    </nav>

    <div class="page-header header-filter" data-parallax="true" filter-color="rose"
        style="background-image: url(&quot;../assets/img/bg6.jpg&quot;); transform: translate3d(0px, 500px, 0px);">
        <div class="container">
            <div class="row title-row">

            </div>
        </div>
    </div>

    <div class="section section-gray" id="carouse">
        <div class="container">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-8">

                        <!-- Carousel Card -->
                        <div class="card card-raised card-carousel">
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                <div class="carousel slide" data-ride="carousel">

                                    <!-- Indicators -->
                                    <ol class="carousel-indicators">
                                        @for ($i = 0; $i < count($images); $i++)
                                            <li data-target="#carousel-example-generic"
                                                data-slide-to="{{ $i }}" class="active">
                                            </li>
                                        @endfor
                                    </ol>

                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner">
                                        @for ($i = 0; $i < count($images); $i++)
                                            @if ($i == 0)
                                                <div class="item active" style="height: 400px">
                                                    <img src="http://{{ $images[$i]->path }}" alt="Awesome Image">
                                                    <div class="carousel-caption">
                                                        <h4><i class="material-icons">location_on</i> Yellowstone
                                                            National Park,
                                                            United States</h4>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="item" style="height: 400px">
                                                    <img src="http://{{ $images[$i]->path }}" alt="Awesome Image">
                                                    <div class="carousel-caption">
                                                        <h4><i class="material-icons">location_on</i> Somewhere Beyond,
                                                            United
                                                            States</h4>
                                                    </div>
                                                </div>
                                            @endif
                                        @endfor
                                    </div>

                                    <!-- Controls -->
                                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                        <i class="material-icons">keyboard_arrow_left</i>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-example-generic"
                                        data-slide="next">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End Carousel Card -->

                    </div>
                    <div class="col-md-4">
                        <h2 class="title"> {{ $pitcharea->name }} </h2>
                        <h5 class="title"> {{ $pitcharea->user->name . ' - ' . $pitcharea->user->phone }} </h5>
                        <h5 class="title"> {{ $pitcharea->address }} </h5>
                        <div class="row pick-size">
                            <div class="col-md-6 col-sm-6">
                                <label>Select Type</label>
                                <div class="btn-group bootstrap-select">
                                    <select class="selectpicker" data-style="select-with-transition" data-size="7"
                                        tabindex="-98" name="type" id="select-type">
                                        <option value="-1">Choose a type</option>
                                        @foreach ($types as $type => $value)
                                            <option value="{{ $type }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Select Pitch</label>
                                <select class="form-control" name="pitch" id="select-pitch">
                                    <option value="-1">Select Pitch</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Date</label>
                            <input class="form-control" id="select-date" type="date" name="willdo"
                                min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <div class="multiSelect">
                                <select multiple class="multiSelect_field" data-placeholder="Add Timeslots"
                                    name="timeslots[]" id="select-timeslots">
                                </select>
                            </div>
                        </div>


                        <div class="row text-right">
                            <button class="btn btn-rose btn-round">Add to Cart &nbsp;<i
                                    class="material-icons">shopping_cart</i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="features text-center">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h3 class="title">Rest of the Story:</h3>
                        {{ $pitcharea->description ?? 'None' }}
                    </div>
                </div>
            </div>
        </div>
    </div>


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

    <!--	Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/   -->
    <script src="{{ asset('js/nouislider.min.js') }}" type="text/javascript"></script>

    <!--	Plugin for Product Gallery, full documentation here: https://9bitstudios.github.io/flexisel/ -->
    <script src="{{ asset('js/jquery.flexisel.js') }}"></script>
    <script src="{{ asset('js/select.min.js') }}"></script>



    <script type="text/javascript">
        var pitches;
        var checkLoadPitches = false;

        $(document).ready(function() {
            init();
            loadPitches();

            // catch event
            $('#select-type').change(function(e) {
                appendPitches($(this).val());
            });
            $('#select-date').change(function(e) {
                if ($(this).val() != '' && $('#select-pitch').val() != -1) {
                    getTimeSLots($(this).val(), $('#select-pitch').val(), $('#select-type').val());
                }
            });

        });

        function loadPitches() {
            if (checkLoadPitches) return;

            $.ajax({
                type: "get",
                url: '{{ route('api.getPitch', $pitcharea->id) }}',
                dataType: "json",
                success: function(response) {
                    checkLoadPitches = true;
                    pitches = new Array();

                    for (const element of response.data) {
                        pitches[element.type] = new Array();
                    }

                    for (const element of response.data) {
                        pitches[element.type].push({
                            "id": element.id,
                            "name": element.name
                        });
                    }

                    // pitches.forEach(element => {
                    //     console.log(element);
                    // });
                }
            });
        }

        function appendPitches(type) {
            $("#select-pitch").empty();
            if (type == -1) {
                $("#select-pitch").append(`
                <option value="-1">Select Pitch</option>
            `);
                return;
            }
            for (const element of pitches[type]) {
                $("#select-pitch").append(`
                    <option value="${element.id}">${element.name}</option>
                `);
            }
        }

        function init() {
            $("#flexiselDemo1").flexisel({
                visibleItems: 4,
                itemsToScroll: 1,
                animationSpeed: 400,
                enableResponsiveBreakpoints: true,
                responsiveBreakpoints: {
                    portrait: {
                        changePoint: 480,
                        visibleItems: 3
                    },
                    landscape: {
                        changePoint: 640,
                        visibleItems: 3
                    },
                    tablet: {
                        changePoint: 768,
                        visibleItems: 3
                    }
                }
            });
        }

        function getTimeSLots(date, pitch, type) {
            $.ajax({
                type: "get",
                url: '{{ route('api.timeslots', $pitcharea->id) }}',
                data: {
                    date,
                    pitch,
                    type
                },
                dataType: "json",
                success: function(response) {
                   
                }
            });
        }
    </script>



</body>
