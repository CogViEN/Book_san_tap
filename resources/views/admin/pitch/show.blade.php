@extends('layout_admin.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <button type="button" onclick="addPitch()" class="btn btn-outline-primary">
                Add Pitch
            </button>
            <label for="csv" class="btn btn-success mb-0">
                Import Pitch CSV
            </label>
            <input type="file" name="csv" id="csv" class="d-none"
                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
            <label for="csvTime" class="btn btn-outline-success mb-0">
                Import Time CSV
            </label>
            <input type="file" name="csvTime" id="csvTime" class="d-none"
                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
            <a href="{{ route('admin.pitches.edit.price', $pitchAreaId) }}" class="btn btn-warning"
                style="float: right">Edit Price</a>
        </div>
        {{-- Modal Pitch --}}
        <div id="modal-pitch" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="info-header-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-info">
                        <h4 class="modal-title" id="info-header-modalLabel">Create </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.pitches.store', $pitchAreaId) }}" method="post"
                            id="form-create-pitch">
                            @csrf
                            <div class="form-group">
                                <label for="pitch-name">Number Pitch</label>
                                <input class="form-control" id="name-pitch" type="text" name="pitch-name" readonly>
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control select-type" name="type" id="select-type-pitch">
                                    @foreach ($arrType as $key => $type)
                                        <option value="{{ $type }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button onclick="submitForm('pitch')" class="btn btn-info">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Modal --}}
        {{-- Modal Type --}}
        
        {{-- ENd Modal --}}
        <div class="card-body">
            <div class="row mb-2">
                <div class="col">
                    <label>Type</label>
                    <select class="form-control select-type" name="type" id="select-type">
                        <option value="-1">Select All</option>
                        @foreach ($arrType as $key => $type)
                            <option value="{{ $type }}">{{ $key }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label>Status</label>
                    <select class="form-control select-status" name="status" id="select-status">
                        <option value="-1">Select All</option>
                        @foreach ($arrStatus as $key => $status)
                            <option value="{{ $status }}">{{ $key }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-centered table-dark table-hover mb-0" id="table-index">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Medium Price</th>
                            <th>Edit Type/Status</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            sendRequestAndRest();

            // catch event 
            $("#csv").change(function(event) {
                var formData = new FormData();
                formData.append('file', $(this)[0].files[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.pitchareas.import_csv.pitches', $pitchAreaId) }}',
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $.toast({
                            heading: 'Import Success',
                            text: 'Your data have been imported sucessfully.',
                            showHideTransition: 'slide',
                            position: 'top-right',
                            icon: 'success'
                        });
                    },
                    error: function(response) {
                        if (response.status == 500) {
                            $.toast({
                                heading: 'Import Failed',
                                text: 'Your file is invalid .',
                                showHideTransition: 'slide',
                                position: 'top-right',
                                icon: 'error'
                            });
                        }
                    }

                });
            })

            $("#csvTime").change(function(event) {
                var formData = new FormData();
                formData.append('file', $(this)[0].files[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.pitchareas.import_csv.times', $pitchAreaId) }}',
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $.toast({
                            heading: 'Import Success',
                            text: 'Your data have been imported sucessfully.',
                            showHideTransition: 'slide',
                            position: 'top-right',
                            icon: 'success'
                        });
                    },
                    error: function(response) {
                        if (response.status == 500) {
                            $.toast({
                                heading: 'Import Failed',
                                text: 'Your file is invalid .',
                                showHideTransition: 'slide',
                                position: 'top-right',
                                icon: 'error'
                            });
                        }
                    }

                });
            })

            $("#select-type").on("change", function() {
                let type = $("#select-type option:selected").val();
                let status = $("#select-status option:selected").val();
                $("#table-index > tbody > tr").remove();
                sendRequestAndRest(type, status);
            });
            $("#select-status").on("change", function() {
                let type = $("#select-type option:selected").val();
                let status = $("#select-status option:selected").val();
                $("#table-index > tbody > tr").remove();
                sendRequestAndRest(type, status);
            });
            $(document).on('click', '.btn-delete', function() {
                deletePitch($(this).attr('data'));
                notifySuccess("Deleted Pitch successfully!");
                $(this).closest("tr").remove();
            });
            $(document).on('click', '.btn-edit', function() {
                console.log(1);
            });
        });

        function sendRequestAndRest(type, status) {
            $.ajax({
                type: "get",
                url: '{{ route('admin.pitches.index', $pitchAreaId) }}',
                data: {
                    type,
                    status
                },
                dataType: "json",
                success: function(response) {
                    for (var i = 0; i < response.data.length; i++) {
                        $('#table-index').append($('<tr>')
                            .append($('<td>').append(response.data[i].name))
                            .append($('<td>').append(response.data[i].type))
                            .append($('<td>').append('<span class="badge badge-success-lighten">' +
                                response.data[i].status + '</span>'))
                            .append($('<td>').append(response.data[i].avg_price))
                            .append($('<td>').append(
                                '<button class="btn-edit btn btn-primary">Edit</button>'))
                            .append($('<td>').append(
                                '<button type="button" data="' + response.data[i].name +
                                '" class="btn-delete btn btn-danger">Delete</button>'))
                        )
                    }
                }
            });
        }

        function submitForm(type) {
            const obj = $("#form-create-" + type);
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
                    if (response.success) {
                        $("#modal-pitch").modal("hide");
                        notifySuccess("Add Pitch successfully")
                        $("#table-index > tbody > tr").remove();
                        sendRequestAndRest();
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

        function addPitch() {
            var table = document.getElementById("table-index");
            var count = table.tBodies[0].rows.length;
            $("#name-pitch").val("sân " + (count + 1));
            $("#modal-pitch").modal("show");
        }

        function deletePitch(name) {
            $.ajax({
                type: "get",
                url: '{{ route('admin.pitches.destroy', $pitchAreaId) }}',
                data: {
                    name
                },
                dataType: "dataType",
                success: function(response) {

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
    </script>
@endpush
