@extends('layout_admin.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/summernote-bs4.css') }}">
    <style>
        input[type="file"] {
            display: block;
        }

        .imageThumb {
            max-height: 75px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }

        .pip {
            display: inline-block;
            margin: 10px 10px 0 0;
        }

        .remove {
            display: block;
            background: #444;
            border: 1px solid black;
            color: white;
            text-align: center;
            cursor: pointer;
        }

        .remove:hover {
            background: white;
            color: black;
        }
    </style>
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.pitchareas.store') }}" method="post" class="form-horizontal"
                id="form-create-pitcharea" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="form-group col-8">
                        <label>Owner</label>
                        <select class="form-control" name="owner" id="select-owner"></select>
                    </div>

                </div>
                <div class="form-group col-8">
                    <label for="name">Pitch Area Name</label>
                    <input type="text" id="name-pitch-area" class="form-control" name="name">
                </div>
                <div class="form-group col-8">
                    <label for="address">Address</label>
                    <input type="text" id="address" class="form-control" name="address">
                </div>
                <div class="form-row col-8 select-location">
                    <div class="form-group col-6">
                        <label>City</label>
                        <select class="form-control select-city" name="province" id="select-city"></select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>District</label>
                        <select class="form-control select-district" name="district" id="select-district"></select>
                    </div>
                </div>
                <div class="form-group col-8">
                    <label>Requirement</label>
                    <textarea name="requirement" id="text-requirement"></textarea>
                </div>
                <div class="form-group col-8">
                    <label>Upload your images</label>
                    <input type="file" id="files" name="images[]" multiple />
                </div>
                <div class="form-group col-8">
                    <button id="btn-submit" onclick="checkOwnerExists()" type="button"
                        class="btn btn-outline-success btn-rounded">
                        <i class="uil-cloud-computing"></i>
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- Create Owner --}}
    <div id="modal-owner" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Create Owner</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.users.store.owner') }}" method="post" id="form-create-owner">
                        @csrf
                        <div class="form-group position-relative mb-3">
                            <label for="validationTooltip01">Name</label>
                            <input type="text" name="name" class="form-control" id="name-owner" placeholder="Name"
                                required>
                        </div>
                        <div class="form-group position-relative mb-3">
                            <label for="validationTooltip02">Phone</label>
                            <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone"
                                required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button onclick="submitForm('owner')" class="btn btn-primary" type="button">Submit</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <script src="{{ asset('js/summernote-bs4.min.js') }}"></script>
    <script>
        let arrImgRemove = [];
        $(document).ready(async function() {
            // inital 
            initalUploadImage();
            $("#text-requirement").summernote();
            $("#select-city").select2();
            loadDataCity();
            loadDataOwner();
            catchEvent();
        });

        async function loadDataCity() {
            // rest data from local storage
            const response = await fetch('{{ asset('locations/index.json') }}');
            const cities = await response.json();

            // set up first time city and district
            $("#select-city").append(`
                <option data-path='null'>
                   Select City
                </option>`)
            $("#select-district").append(`
                <option data-path='null'>
                   Select District
                </option>`)

            // fill data to city
            $.each(cities, function(index, each) {
                $("#select-city").append(`
                <option data-path='${each.file_path}'>
                    ${index}
                </option>`)

            })
        }

        async function loadDataDistrict(path) {
            $("#select-district").empty();
            if (path === null) {
                $("#select-district").append(`
                <option data-path='null'>
                   Select District
                </option>`);
                return;
            }
            const response = await fetch('{{ asset('locations/') }}' + path);
            const districts = await response.json();
            let string = '';

            $.each(districts.district, function(index, each) {
                let nameDistrict = (each.pre ? each.pre + ' ' : '') + each.name;
                string += `<option`;
                string += `>${nameDistrict}</option>`;
            })
            $("#select-district").append(string);
        }

        async function loadDataOwner() {
            $("#select-owner").select2({
                ajax: {
                    delay: 250,
                    url: '{{ route('admin.users.api.owners') }}',
                    // Search query parameters
                    data: function(params) {
                        var queryParameters = {
                            q: params.term
                        }

                        return queryParameters;
                    },
                    // crawl data from api
                    processResults: function(data) {
                        return {
                            results: $.map(data.data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.name,
                                }
                            })
                        };
                    },
                },
                tags: true,
            });
        }

        async function catchEvent() {
            // catch select city event
            $("#select-city").change(function(e) {
                parent = $('#select-city').parents('.select-location');
                const path = parent.find(".select-city option:selected").data('path');
                loadDataDistrict(path);
            });

            // catch file
            $('#files').on('click', function(e) {
                $(this).val('');
                $('.pip').remove();
            });

            $(document).on('click', '.remove', function() {
                arrImgRemove.push($(this).attr('id'))
                $(this).parent(".pip").remove();
            });

        }


        function submitForm(type) {
            const obj = $("#form-create-" + type);
            var formData = new FormData(obj[0]);
            if (type == "pitcharea") {
                formData.append('imageRemove', arrImgRemove);
            }
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
                    if (response.success) {
                        $("#modal-owner").modal("hide");
                        if (type == 'owner') {
                            notifySuccess('create owner successfully');
                        } else {
                            notifySuccess('');
                        }
                    } else {
                        showError(response.message);
                    }

                },
                error: function(response) {
                    let errors;
                    if (response.responseJSON.errors) {
                        errors = Object.values(response.responseJSON.errors);
                        showError(errors);
                    } else {
                        errors = response.responseJSON.message;
                        showError(errors);
                    }

                },
            });

        }

        function initalUploadImage() {
            if (window.File && window.FileList && window.FileReader) {
                $("#files").on("change", function(e) {
                    var files = e.target.files,
                        filesLength = files.length;
                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i];
                        let nameFile = f.name;
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $("<span class=\"pip\" id=\"" + nameFile + "\"" + "\>" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" +
                                nameFile + "\"/>" +
                                "<br/><span class=\"remove\" id=\"" + nameFile + "\"" +
                                "\>Remove image</span>" +
                                "</span>").insertAfter("#files");
                            // $(".remove").click(function() {
                            //     console.log($(this));
                            //     $(this).parent(".pip").remove();
                            // });

                            // Old code here
                            /*$("<img></img>", {
                              class: "imageThumb",
                              src: e.target.result,
                              title: file.name + " | Click to remove"
                            }).insertAfter("#files").click(function(){$(this).remove();});*/

                        });
                        fileReader.readAsDataURL(f);
                    }
                });
            } else {
                alert("Your browser doesn't support to File API")
            }
        }

        function checkOwnerExists() {
            if (validateForm() == false) {
                return;
            }
            $.ajax({
                type: "get",
                url: ' {{ route('admin.users.check') }}/' + $("#select-owner").val(),
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        submitForm('pitcharea');
                    } else {
                        $("#modal-owner").modal("show");
                        $("#name-owner").val($("#select-owner").val());
                    }
                }
            });
        }

        function showError(errors) {
            let string = '<ul>'
            if (Array.isArray(errors)) {
                errors.forEach(function(each) {
                    each.forEach(function(error) {
                        string += `<li>${error}</li>`;
                    });
                });
            } else {
                string += `<li>${errors}</li>`;
            }
            string += '</ul>';
            $("#div_errors").html(string);
            $("#div_errors").removeClass("d-none").show();
            notifyError(string);
        }

        function validateForm() {
            if ($('#select-owner').find(":selected").val() === undefined ||
                !$('#name-pitch-area').val() || $('#select-city').find(":selected").val() == 'Select City') {

                showError('Please fill owner, pitch area name and city');
                return false;
            }
            return true;
        }
    </script>
@endpush
