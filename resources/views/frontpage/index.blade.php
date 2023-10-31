@extends('layout_frontpage.master')
@push('css')
@endpush
@section('content')
    <div class="row" id="pitcharea-content">
        @foreach ($pitchareas as $pitcharea)
            <x-pitch-area-end-user :obj="$pitcharea" />
            @break
        @endforeach
    </div>
    @if (count($pitchareas) > 1)
        <div class="col-md-3 col-md-offset-5">
            <button onclick="loadMore('true')" id="load_more" class="btn btn-rose btn-round">Load more...</button>
        </div>
    @endif
    
@endsection
@push('js')
    <script>
        var checkLoadCityAndDistrcit = false;
        var cityAndDistrict;

        $(document).ready(function() {
            // load data to sidebar
            loadCityAndDistricts();

            // catch event
            $('#select-province').change(function(e) {
                loadDistrictByProvince($(this).val());
            });
        });

        function loadMore(check) {
            // count the number pitcharea
            let curElement = $('#pitcharea-content .col-md-10').length;
            // cut the request form url
            let curRequest = (window.location.href).split('?')[1];
            $.ajax({
                type: "get",
                url: 'http://book_san_tap.test/api/apiPitchArea?' + curRequest,
                dataType: "json",
                success: function(response) {
                    if (curElement < response.data.length) {
                        let nextElement = `
                        <div class="col-md-10">
                            <div class="card card-raised card-background"
                                style="background-image: url('http://${response.data[curElement].avatar}'); margin-left: 77px">
                                <div class="card-content">
                                    <h6 class="category text-info">${response.data[curElement].address}</h6>
                                    <h3 class="card-title">${response.data[curElement].name}</h3>
                                    <p class="card-description">
                                    <b>Include:</b> ${response.data[curElement].type}
                                    </p>
                                    <h4 class="card-title">${response.data[curElement].cost}</h4>
                                    <a href="end_user/detail/${response.data[curElement].id}" class="btn btn-primary btn-round">
                                        <i class="material-icons">subject</i> Book Appointment
                                    </a>
                                </div>
                            </div>
                        </div>
                        `
                        $("#pitcharea-content").last().append(nextElement);
                        if (curElement + 1 == response.data.length) $('#load_more').remove();
                    }
                }
            });
        }

        function loadCityAndDistricts() {
            if (loadCityAndDistricts == true) return;

            $.ajax({
                type: "get",
                url: '{{ route('api.cityAndDistrict') }}',
                dataType: "json",
                success: function(response) {
                    cityAndDistrict = new Array();

                    for (const element of response.data) {
                        cityAndDistrict[element.province] = new Array();
                    }

                    for (const element of response.data) {
                        cityAndDistrict[element.province].push(element.district);
                    }

                    cityAndDistrict.forEach(element => {
                        console.log(element);
                    });
                }
            });
        }

        function loadDistrictByProvince(province) {
            $("#select-district").empty();
            if(province == "All") {
                $("#select-district").append(`
                    <option value="All">Select district</option>
                `);
                return;
            }
            for (const element of cityAndDistrict[province]){
                $("#select-district").append(`
                    <option value="${element}">${element}</option>
                `);
            }
        }
    </script>
@endpush
