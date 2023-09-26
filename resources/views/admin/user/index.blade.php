@extends('layout_admin.master')
@push('css')
    <link
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/date-1.4.1/fc-4.2.2/fh-3.3.2/r-2.4.1/rg-1.3.1/sc-2.1.1/sb-1.4.2/sl-1.6.2/datatables.min.css"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <a class="btn btn-success mb-2" href="{{ route('admin.users.create') }}">Add</a>
            <div class="form-group">
                <select id="select-name"></select>
            </div>
            <div class="form-group">
                <select id="select-role" class="form-control">
                    <option value="-1">Tất cả</option>
                    @foreach ($arrRole as $key => $value)
                        <option value="{{ $value }}">
                            {{ $key }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="table-responsive">
                <table class="table table-centered table-dark table-hover mb-0" id="table-index">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Avatar</th>
                            {{-- <th>Edit</th> --}}
                            <th>Delete</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/date-1.4.1/fc-4.2.2/fh-3.3.2/r-2.4.1/rg-1.3.1/sc-2.1.1/sb-1.4.2/sl-1.6.2/datatables.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
    <script>
        $(function() {

            $("#select-name").select2({
                ajax: {
                    url: "{{ route('admin.users.api.name') }}",
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: params.term, // search term
                        };
                    },
                    processResults: function(data, params) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    }
                },
                placeholder: 'Search for a name',
                allowClear: true,
            });

            var buttonCommon = {
                exportOptions: {
                    columns: ':visible :not(.not-export)'
                }
            };
            let table = $('#table-index').DataTable({
                dom: 'Blrtip', // dom datatable các button
                select: true,
                buttons: [
                    $.extend(true, {}, buttonCommon, {
                        extend: 'copyHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'excelHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'pdfHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'print'
                    }),
                    'colvis'
                ],
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.users.api') !!}',
                columnDefs: [{
                    className: "not-export",
                    "targets": [5, 6],
                }, ],
                lengthMenu: [5, 10, 20],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'role',
                        name: 'role',
                    },
                    {
                        orderable: false,
                        searchable: false,
                        "data": "avatar",
                        "render": function(data) {
                            return '<img src="http://' + data + '"" height="50px">';
                        }
                    },
                    // {
                    //     data: 'edit',
                    //     targets: 5,
                    //     orderable: false,
                    //     searchable: false,
                    //     render: function(data, type, row, meta) {
                    //         return `<a class="btn btn-info" href="${data}">
                //         Edit
                //     </a>`
                    //     }
                    // },
                    {
                        data: 'destroy',
                        targets: 5,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return `<form action="${data}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn-delete btn btn-danger">Delete</button>
                                        </form>`
                        }
                    },
                ]
            });

            $('#select-name').change(function() {
                table.columns(0).search(this.value).draw();
            });

            $('#select-role').change(function() {
                table.columns(4).search(this.value).draw();
            });

            $(document).on('click', '.btn-delete', function(e) {
                let form = $(this).parents('form');
                $.ajax({
                    type: "POST",
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: "json",
                    success: function(response) {
                        console.log('success');
                        table.draw();
                    },
                    error: function(response) {
                        console.log('fail');
                        table.draw();
                    },

                });
            });

        });
    </script>
@endpush
