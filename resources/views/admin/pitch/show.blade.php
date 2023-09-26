@extends('layout_admin.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <a href="#" class="btn btn-primary">
                Create
            </a>
            <label for="csv" class="btn btn-success mb-0">
                Import CSV
            </label><input type="file" name="csv" id="csv" class="d-none"
                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-dark table-hover mb-0" id="table-index">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Medium Price</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $.ajax({
                type: "get",
                url: '{{ route('admin.pitches.index', $pitchAreaId) }}',
                dataType: "json",
                success: function(response) {
                    for (var i = 0; i < response.data.length; i++) {
                        $('#table-index').append($('<tr>')
                            .append($('<td>').append(response.data[i].name))
                            .append($('<td>').append(response.data[i].type))
                            .append($('<td>').append('<span class="badge badge-success-lighten">' + response.data[i].status + '</span>'))
                            .append($('<td>').append(response.data[i].avg_price))
                            .append($('<td>').append(
                                '<button class="btn btn-primary btn-rounded">Edit</button>'))
                            .append($('<td>').append(
                                '<button class="btn btn-danger btn-rounded">Delete</button>'))
                        )
                    }
                }
            });

            // catch event 
            $("#csv").change(function(event) {
                var formData = new FormData();
                formData.append('file', $(this)[0].files[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.pitchareas.import_csv', $pitchAreaId) }}',
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
        });
    </script>
@endpush
