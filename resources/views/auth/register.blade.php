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

<body class="signup-page">
    <div class="page-header header-filter"
        style="background-image: url('https://images.unsplash.com/photo-1577223632489-93ce08c2ac6d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80'); background-size: cover; background-position: top center;">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">

                    <div class="card card-signup">
                        <h2 class="card-title text-center">Register</h2>
                        <div class="row">
                            <div class="col-md-5 col-md-offset-1">
                                <div class="info info-horizontal">
                                    <div class="icon icon-rose">
                                        <i class="material-icons">timeline</i>
                                    </div>
                                    <div class="description">
                                        <h4 class="info-title">Marketing</h4>
                                        <p class="description">
                                            We've created the marketing campaign of the website. It was a very
                                            interesting collaboration.
                                        </p>
                                    </div>
                                </div>

                                <div class="info info-horizontal">
                                    <div class="icon icon-primary">
                                        <i class="material-icons">code</i>
                                    </div>
                                    <div class="description">
                                        <h4 class="info-title">Fully Coded in HTML5</h4>
                                        <p class="description">
                                            We've developed the website with HTML5 and CSS3. The client has access to
                                            the code using GitHub.
                                        </p>
                                    </div>
                                </div>

                                <div class="info info-horizontal">
                                    <div class="icon icon-info">
                                        <i class="material-icons">group</i>
                                    </div>
                                    <div class="description">
                                        <h4 class="info-title">Built Audience</h4>
                                        <p class="description">
                                            There is also a Fully Customizable CMS Admin Dashboard for this product.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <form class="form" id="form" method="post" action="{{ route('process_register') }}">
                                    @csrf
                                    <div class="card-content">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">face</i>
                                            </span>
                                            <div class="form-group is-empty">
                                                <input type="text" id="name" name="name" class="form-control"
                                                    placeholder="Full Name...">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">phone</i>
                                            </span>
                                            <div class="form-group is-empty">
                                                <input name="phone" id="phone" type="text" class="form-control"
                                                    placeholder="Phone...">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <div class="form-group is-empty">
                                                <input type="text" id="email" name="email" class="form-control"
                                                    placeholder="Email...">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <div class="form-group is-empty">
                                                <input type="password" id="password" name="password"
                                                    placeholder="Password..." class="form-control">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer text-center">
                                        <button type="button" onclick="submitForm()"
                                            class="btn btn-primary btn-round">Get Started</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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

                },
                error: function(response) {
                    $.toast({
                        heading: 'Error',
                        text: response.responseJSON.message,
                        icon: 'error',
                        position: 'top-right',
                    })
                    console.log(response.responseJSON.message);
                },
            });

        }

        function validateForm() {
            let check = true;

            let email = $("#email").val();
            let password = $("#password").val();
            let name = $("#name").val();
            let phone = $("#phone").val();
            if (email == "" || password == "" || name == "" || phone == "") {
                warning('not empty input');
                check = false;
            }
            if (password.length < 8) {
                warning('not invalid password');
                check = false;
            }

            let pattern =
                /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

            if (!$.trim(email).match(pattern)) {
                warning('Email is not invalid');
                check = false;
            }

            pattern = /((^(\+84|84|0|0084){1})(3|5|7|8|9))+([0-9]{8})$/;

            if (!$.trim(phone).match(pattern)) {
                warning('phone is not invalid');
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
            })
        }
    </script>

</body>
