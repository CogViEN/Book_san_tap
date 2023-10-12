<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>{{ config('app.name') . ' - ' . $title }}</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/material-kit.css_v=1.2.1.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/jquery.toast.min.css') }}">
</head>

<body class="login-page">


    <div class="page-header header-filter"
        style="background-image: url('https://images.unsplash.com/photo-1522778526097-ce0a22ceb253?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80'); background-size: cover; background-position: top center;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                    <div class="card card-signup">
                        <form id="form" class="form" method="post" action="{{ route('process_login') }}">
                            @csrf
                            <div class="header header-info text-center">
                                <h4 class="card-title">Log in</h4>
                                <div class="social-line">
                                    <a href="{{ route('auth.facebook') }}" class="btn btn-just-icon btn-simple">
                                        <i class="fa fa-facebook-square"></i>
                                    </a>
                                    <a href="{{ route('auth.google') }}" class="btn btn-just-icon btn-simple">
                                        <i class="fa fa-google-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <p class="description text-center">Or Be Classical</p>
                            <div class="card-content">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">email</i>
                                    </span>
                                    <div class="form-group is-empty">
                                        <input type="text" class="form-control" placeholder="Email..." name="email"
                                            id="email">
                                        <span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                                    <div class="form-group is-empty">
                                        <input type="password" placeholder="Password..." class="form-control"
                                            name="password" id="password">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="footer text-center">
                                <button type="button" onclick="submitForm()"
                                    class="btn btn-primary btn-simple btn-wd btn-lg">Get Started</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/material.min.js') }}"></script>
    <script src="{{ asset('js/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('js/helper.js') }}"></script>

    <!--    Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc    -->
    <script src="{{ asset('js/material-kit.js') }}" type="text/javascript"></script>
    <script>
        function submitForm() {
            if (!validateForm()) return;
            const obj = $("#form");
            var formData = new FormData(obj[0]);
            $.ajax({
                url: obj.attr('action'),
                type: 'POST',
                dataType: "json",
                data: formData,
                processData: false,
                async: false,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                success: function(response) {
                    window.location.href = 'http://book_san_tap.test/' + response.data;
                    // console.log(response.data);
                },
                error: function(response) {
                    $.toast({
                        heading: 'Error',
                        text: response.responseJSON.message,
                        icon: 'error',
                        position: 'top-right',
                    })
                },
            });

        }

        function validateForm() {
            let check = true;

            let email = $("#email").val();
            let password = $("#password").val();
            if (email == "" || password == "") {
                warning('not empty input');
                check = false;
            }
            if (password.length < 8 || email.length < 8) {
                warning('not invalid input');
                 check = false;
            }

            var pattern =
                /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

            if (!$.trim(email).match(pattern)) {
                warning('Email is not invalid');
                 check = false;
            }

            return check;
        }

        function warning(string) {
            $.toast({
                heading: 'Warning',
                text: string,
                icon: 'warning',
                position: 'top-right',
                stack: false,
            })
        }
    </script>
</body>
