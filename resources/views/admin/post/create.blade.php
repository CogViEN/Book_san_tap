<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') . '  ' . ($title ?? '') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- App css -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app-creative.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/summernote-bs4.css') }}">
    <style>
        input {
            color: #292929;
            font-weight: 500;
            min-height: 48px;
        }

        .form-control {
            border: 0;
        }

        .no-border {
            border: 0;
            box-shadow: none;
            /* You may want to include this as bootstrap applies these styles too */
        }

        #preview-image {
            width: 469px;
            height: auto;
            background: #eee;
            border-radius: 0 0 10px 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            columns: 600px 1;
            border: 1px solid black;
        }

        #upload-area {
            width: 40vw;
            height: auto;
            margin: auto;
        }

        a {
            color: black;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-weight: bold;
            background: #eee;
        }

        .img {
            width: 100%;
            height: auto;
            border-radius: 0 0 10px 10px;
        }

        #placeholder {
            display: flex;
            flex-direction: column;
            height: 300px;
            width: 100%;
            background: url("https://avatars.mds.yandex.net/i?id=ac9425f0536b1cc38165d187ca0db7fcfce1f2f6-9181395-images-thumbs&n=13");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            justify-content: center;
            align-items: center;
            border-radius: 0 0 10px 10px;
        }

        #inputImage {
            display: none;
            width: 600px;
            color: black;
            background: none;
            cursor: pointer;
        }

        #inputLabel {
            height: 100px;
            width: 469px;
            background: #0b2447;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border-radius: 10px 10px 0 0;
            font-weight: 600;
            text-transform: uppercase;
            color: white;
            letter-spacing: 2px;
            border: 1px solid black;
        }

        #inputLabel::after {
            content: "";
            border-top: 25px solid white;
            border-right: 25px solid transparent;
            border-left: 25px solid transparent;
            border-bottom: 25px solid transparent;
            height: 0;
            width: 0;
            position: absolute;
            top: 5px;
        }

        #inputLabel::before {
            content: "";
            border-top: 25px solid transparent;
            border-right: 25px solid transparent;
            border-left: 25px solid transparent;
            border-bottom: 25px solid white;
            height: 0;
            width: 0;
            position: absolute;
            top: 45px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="navbar-custom topnav-navbar topnav-navbar">
            {{-- navbar --}}
            <ul class="list-unstyled topbar-right-menu float-right mb-0">
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="account-user-avatar">
                            <img src="https://media.tenor.com/ZVzNZFKDquoAAAAC/anime.gif" alt="user-image"
                                class="rounded-circle">
                        </span>
                        <span>
                            <span class="account-user-name">Dominic Keller</span>
                            <span class="account-position">Founder</span>
                        </span>
                    </a>
                    <div
                        class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                        <!-- item-->
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-circle mr-1"></i>
                            <span>My Account</span>
                        </a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="mdi mdi-logout mr-1"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </li>

            </ul>
            {{-- end navbar --}}
            <button class="btn btn-success btn-rounded topbar-right-menu float-right mt-3 mr-3" id="btn-export"
                disabled>Export</button>

        </div>
        <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data" id="form-create">
            @csrf
            <div class="form-group">
                <input name="heading" type="email" class="form-control no-border" id="heading" placeholder="Heading"
                    style="font-size: 47px;">
            </div>
            <textarea id="summernote" name="description"></textarea>
            {{-- Modal --}}
            <div id="modal-avatar" class="modal fade" tabindex="-1" role="dialog"
                aria-labelledby="fill-dark-modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content modal-filled bg-dark">
                        <div class="modal-header">
                            <label for="inputImage" id="inputLabel">Select Avatar for your post</label>
                        </div>
                        <div class="modal-body">
                            <input type="file" id="inputImage" name="avatar" />
                            <div id="preview-image">
                                <div id="placeholder">
                                    <div id="upload-area" title="select a image">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Save</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <script src="{{ asset('js/vendor.min.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script src="{{ asset('js/summernote-bs4.min.js') }}"></script>
    <script>
        let checkImage = false;
        $(document).ready(function() {
            var t = $('#summernote').summernote({
                placeholder: 'write content here ...',
                height: 500,
                focus: true,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen']],
                ],
            });
            $('#heading').on('input', function() {
                verifyInput()
            });
            $('#summernote').on('summernote.change', function(we, contents, $editable) {
                verifyInput();
            });
            $('#btn-export').click(function(e) {
                if (!checkImage) {
                    $('#modal-avatar').modal('show');
                } else {
                    submitForm();
                }
            });
        });

        function verifyInput() {
            if ($('#heading').val().length > 2 && $('#summernote').val().length > 10) {
                $('#btn-export').attr('disabled', false);
            }
        }

        const inputImage = document.getElementById("inputImage");
        const previewArea = document.getElementById("preview-image");
        const placeholder = document.getElementById("placeholder");
        // detect upload
        inputImage.addEventListener("change", () => {
            const reader = new FileReader();
            reader.readAsDataURL(inputImage.files[0]);

            reader.onload = (e) => {
                checkImage = true;
                const img = document.createElement("img");
                img.src = e.target.result;
                img.classList.add("img");

                placeholder.style.display = "none";
                previewArea.innerHTML = "";
                previewArea.append(img);
            };
        });

        function submitForm() {
            if (!checkImage) return;
            const obj = $("#form-create");
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
                    notifySuccess(response.data);
                },
                error: function(response) {
                    notifyError(response.message);
                },
            });

        }
    </script>
</body>
