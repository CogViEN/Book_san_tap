@extends('layout_admin.master')
@push('css')
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-row col-8">
                <div class="form-group col-4 mr-4">
                    <label>Type</label>
                    <select class="form-control" name="select-type" id="type"></select>
                </div>
                <div class="form-group col-4">
                    <label><i class="mdi mdi-timer "></i> Begin - End</label>
                    <input type="text" id="range_03" data-plugin="range-slider" data-type="double" data-grid="true"
                        data-min="5" data-max="24" data-from="7" data-to"15" data-prefix="" />
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <form action="{{ url('store-input-fields') }}" method="POST">
                    @csrf

                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
                    <table class="table table-bordered" id="dynamicAddRemove">
                        <tr>
                            <th>Time</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="addTimeslots[0][subject]" placeholder="Enter subject"
                                    class="form-control" />
                            </td>
                            <td>
                                <input type="number" name="addPrices[0][subject]" placeholder="Enter subject"
                                    class="form-control" />
                            </td>
                            <td><button type="button" name="add" id="dynamic-ar" class="btn btn-primary">Add
                                    Subject</button></td>
                        </tr>
                    </table>
                    <button type="submit" class="btn btn-success btn-block">Save</button>
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
        $("#dynamic-ar").click(function() {
            ++i;
            $("#dynamicAddRemove").append('<tr><td><input type="text" name="addTimeslots[' + i +
                '][subject]" placeholder="Enter subject" class="form-control" /></td><td><input type="text" name="addPrices[' +
                i +
                '][subject]" placeholder="Enter subject" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-input-field">Delete</button></td></tr>'
            );
        });
        $(document).on('click', '.remove-input-field', function() {
            $(this).parents('tr').remove();
        });
    </script>
@endpush
