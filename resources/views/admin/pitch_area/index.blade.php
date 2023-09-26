@extends('layout_admin.master')
@section('content')
    <div class="form-group">
        <a class="btn btn-success mb-2" href="{{ route('admin.pitchareas.create') }}">Add</a>
    </div>
    <div class="form-row col-6 select-location">
        <div class="form-group col-4">
            <label>City</label>
            <select class="form-control select-city" name="province" id="select-city"></select>
        </div>
        <div class="form-group col-md-4">
            <label>District</label>
            <select class="form-control select-district" name="district" id="select-district"></select>
        </div>
    </div>
    {{-- select thêm loại sân --}}
    @for ($i = 0; $i < count($arrPitchArea); $i++)
        <x-pitch-area :pitchArea="$arrPitchArea[$i]" :image="$arrImage[$i]" :owner="$arrOwner[$i]"/>
    @endfor
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(async function() {
            $("#select-city").select2();
            loadDataCity();
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


        async function catchEvent() {
            // catch select city event
            $("#select-city").change(function(e) {
                parent = $('#select-city').parents('.select-location');
                const path = parent.find(".select-city option:selected").data('path');
                loadDataDistrict(path);
            });
        }
    </script>
@endpush
