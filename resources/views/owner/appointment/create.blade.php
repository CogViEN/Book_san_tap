@extends('layout_owner.master')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <form action="{{ route('owner.appointments.store') }}" method="post" id="form-create">
                    @csrf
                    <div class="form-group col-8">
                        <label>Customer name</label>
                        <input type="text" class="form-control" name="name" id="name" />
                    </div>
                    <div class="form-group col-8">
                        <label>Phone</label>
                        <input type="number" class="form-control" name="phone" id="phone" />
                    </div>
                    <div class="form-group col-8">
                        <label>Require</label>
                        <textarea type="text" class="form-control" name="require" id="require"></textarea>
                    </div>
                    <div class="form-row col-11 select-location">
                        <div class="form-group col-5">
                            <label>Pitch Area</label>
                            <select class="form-control select-pitcharea" name="pitcharea" id="select-pitcharea"></select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Pitch</label>
                            <select class="form-control select-pitch" name="pitch" id="select-pitch"></select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="example-date">Date</label>
                            <input class="form-control" id="willdo" type="date" name="willdo"
                                min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group col-md-7">
                            <label>TimeSlot</label>
                            <select class="form-control select-timeslot" name="timeslots_cost[]" id="select-timeslot"
                                multiple="multiple">
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label>Cost</label>
                            <input type="text" readonly class="form-control" id="cost" />
                        </div>
                    </div>
                    <div class="form-group col-8">
                        <button id="btn-submit" type="button" class="btn btn-outline-success btn-rounded"
                            onclick="submitForm()">
                            <i class="uil-cloud-computing"></i>
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <script>
        $(document).ready(function() {
            $('#select-timeslot').select2();
            loadDefaultValue();
            loadDataPitchArea();
            catchEvent();
        });

        function loadDefaultValue() {
            $("#select-pitcharea").append(`
                <option data-path='null'>
                   Select Pitch Area
                </option>`)
            $("#select-pitch").append(`
                <option data-path='null'>
                   Select Pitch
                </option>`)
            $("#select-timeslot").append(`
                <option data-path='null'>
                   Select Timeslot
                </option>`)
        }

        function loadDataPitchArea() {
            $.ajax({
                type: "get",
                url: '{{ route('owner.pitchareas.api.get') }}',
                dataType: "json",
                success: function(response) {
                    for (const each of response.data) {
                        $("#select-pitcharea").append(`
                        <option value='${each.id}'
                        data-path='${each.id}'>
                        ${each.name}
                        </option>`)
                    }
                }
            });
        }

        function loadDataPitch(id) {
            $("#select-pitch").empty();

            if (id === null) {
                $("#select-pitch").append(`
                <option data-path='null'>
                   Select Pitch
                </option>`);

                $("#select-timeslot").empty();
                $("#select-timeslot").append(`
                <option data-path='null'>
                   Select Timeslot
                </option>`);

                return;
            }

            $("#select-pitch").append(`
                <option data-path='null'>
                   Select Pitch
                </option>`);

            $.ajax({
                type: "get",
                url: "http://book_san_tap.test/owner/pitches/api/get/" + id,
                dataType: "json",
                success: function(response) {
                    for (const each of response.data) {
                        $("#select-pitch").append(`
                        <option value='${each.id}'
                            data-path='${each.id}'>
                        ${each.name + ' - ' + each.type + ' người'} 
                        </option>`)
                    }
                }
            });
        }

        function loadTimeSlot(pitchId, willdo) {
            if (pitchId == null) return;
            $.ajax({
                type: "get",
                url: "http://book_san_tap.test/owner/appointments/api/timeslot/free",
                data: {
                    pitchId: pitchId,
                    willdo: willdo
                },
                dataType: "json",
                success: function(response) {
                    $("#select-timeslot").empty();
                    for (const each of response.data) {
                        $("#select-timeslot").append(`
                        <option value='${each.cost}'>${each.timeslot} </option>`)
                    }
                }
            });
        }

        function fillCost() {
            let array = $("#select-timeslot").val();
            var sum = 0;
            for (const each of array) {
                sum += Number(each);
            }
            // format currency values
            let res = (sum).toLocaleString('it-IT', {
                style: 'currency',
                currency: 'VND',
            }) + '₫';
            // fill data
            $('#cost').val('');   
            $('#cost').val(res);   
        }

        // catch event 
        function catchEvent() {
            $("#select-pitcharea").change(function(e) {
                parent = $('#select-pitcharea').parents('.select-location');
                const path = parent.find(".select-pitcharea option:selected").data('path');
                loadDataPitch(path);
            });
            $("#select-pitch").change(function(e) {
                if ($('#willdo').val() != '') {
                    parent = $('#select-pitch').parents('.select-location');
                    const pitchId = parent.find(".select-pitch option:selected").data('path');
                    if (pitchId != null) {

                        loadTimeSlot(pitchId, $('#willdo').val());
                    }
                }
            });
            $('#willdo').change(function(e) {
                parent = $('#select-pitch').parents('.select-location');
                const pitchId = parent.find(".select-pitch option:selected").data('path');
                loadTimeSlot(pitchId, $(this).val());
            });
            $('#select-timeslot').change(function(e) {
                fillCost();
            });

        }

        function submitForm(type) {
            const obj = $("#form-create");
            var formData = new FormData(obj[0]);
            formData.append('timeslots', $("#select-timeslot option:selected").text());
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
                    notifySuccess('Dạ thằng này cảm ơn');
                },
                error: function(response) {
                    notifyError(response.responseJSON.message);
                },
            });

        }
    </script>
@endpush
