@extends('layout_admin.master')
@push('css')
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-row col-9">
                <div class="form-group col-4 mr-4">
                    <label>Type</label>
                    <select class="form-control" name="select-type" id="type">
                        @foreach ($types as $type)
                            <option value="{{ $type }}">Sân {{ $type }} người</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-3 mr-4">
                    <label><i class="mdi mdi-timer "></i> Begin - End</label>
                    <input type="text" id="range_03" data-plugin="range-slider" data-type="double" data-grid="true"
                        data-min="5" data-max="24" data-from="7" data-to"15" data-prefix="" />
                </div>
                <div class="form-group col-3">
                    <label>Set Money Default </label>
                    <input type="text" class="form-control" data-toggle="input-mask"
                        data-mask-format="000.000.000.000.000" data-reverse="true">
                    <span class="font-13 text-muted">₫ dong"</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <form action="{{ route('admin.pitches.update.timeslot.cost', $pitchAreaId) }}" method="POST" id="form-create">
                    @csrf
                    @method('put')
                    <table class="table table-bordered" id="dynamicAddRemove">
                        <tr>
                            <th>Time</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" id="time0" name="addTimeslots[0][subject]"
                                    placeholder="Enter subject" class="form-control" />
                            </td>
                            <td>
                                <input type="number" id="price0" name="addCosts[0][subject]"
                                    placeholder="Enter subject" class="form-control" />
                            </td>
                            <td>
                                <button type="button" name="add" id="dynamic-ar" class="btn btn-primary">
                                    Add Subject
                                </button>
                            </td>
                        </tr>
                    </table>
                    <button type="button" onclick="submitForm()" class="btn btn-success btn-block">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('js/component.range-slider.js') }}"></script>
    <script>
        var i = 0;
        var previous;
        $("#dynamic-ar").click(function() {
            ++i;
            $("#dynamicAddRemove").append('<tr>' +
                '<td>' +
                '<input type="text" name="addTimeslots[' + i +
                '][subject]" placeholder="Enter timeslot" class="form-control" />' +
                '</td>' +
                '<td><input type="text" name="addCosts[' +
                i +
                '][subject]" placeholder="Enter price" class="form-control" />' +
                '</td>' +
                '<td>' +
                '<button type="button" class="btn btn-danger remove-input-field">Delete</button>' +
                '</td>' +
                '</tr>'
            );
        });
        $(document).on('click', '.remove-input-field', function() {
            $(this).parents('tr').remove();
        });

        $(document).ready(function() {
            $('#type').change(function() {
                let currentType = $('#type option:selected').val();
                $.ajax({
                    type: "get",
                    url: '{{ route('admin.pitches.api.timeslot.cost', $pitchAreaId) }}',
                    data: {
                        currentType
                    },
                    dataType: "json",
                    success: function(response) {
                        var length = response.data.time.length;
                        if (length > 0) {
                            $('#time0').val(response.data.time[0].timeslot);
                            $('#price0').val(response.data.time[0].cost);

                            $('#dynamicAddRemove').find("tr:gt(1)").remove();

                            for (let i = 1; i < response.data.time.length; i++) {

                                $("#dynamicAddRemove").append('<tr>' +
                                    '<td>' +
                                    '<input type="text" name="addTimeslots[' + i +
                                    '][subject]" value="' + response.data.time[i].timeslot +
                                    '" placeholder="Enter subject" class="form-control" />' +
                                    '</td>' +
                                    '<td><input type="text" name="addCosts[' +
                                    i +
                                    '][subject]" value="' + response.data.time[i].cost +
                                    '" placeholder="Enter subject" class="form-control" />' +
                                    '</td>' +
                                    '<td>' +
                                    '<button type="button" class="btn btn-danger remove-input-field">Delete</button>' +
                                    '</td>' +
                                    '</tr>'
                                );
                            }
                        }

                    }
                });
            });
        });

        function submitForm(type) {
            const obj = $("#form-create");
            var formData = new FormData(obj[0]);
            let currentType = $('#type option:selected').val();
            formData.append('currentType', currentType);
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
