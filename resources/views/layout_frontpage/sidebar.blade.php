<div class="col-md-3">
    <div class="card card-refine card-plain">
        <div class="card-content">
            <form action="{{ route('end_user.index') }}" method="get" id="form-request">
                <h4 class="card-title">
                    Refine
                    <a class="btn btn-default btn-fab btn-fab-mini btn-simple pull-right"
                        href="{{ route('end_user.index') }}" title="" data-original-title="Reset Filter">
                        <i class="material-icons">cached</i>
                    </a>
                </h4>
                {{-- <div class="panel panel-default panel-rose">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                            href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <h4 class="panel-title">Time</h4>
                            <i class="material-icons">keyboard_arrow_down</i>
                        </a>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                        aria-labelledby="headingOne">
                        <div class="panel-body panel-refine">
                            <input class="form-control" id="willdo" type="date" name="willdo"
                                min="{{ date('Y-m-d') }}">
                            <select class="form-control" name="timeslot">
                                <option value="-1">Choose timeslot</option>
                                @foreach ($timeslots as $timeslot)
                                    <option value="{{ $timeslot }}">{{ $timeslot }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div> --}}

                <div class="panel panel-default panel-rose">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                            href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <h4 class="panel-title">Location</h4>
                            <i class="material-icons">keyboard_arrow_down</i>
                        </a>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body panel-refine select-location">
                            <select class="form-control select-city" name="province" id="select-province">
                                <option value="All">Select city</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city }}"
                                        @if ($selectProvince == $city) selected @endif>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>
                            <select class="form-control select-district" name="district" id="select-district">
                                @if ($selectDistrict == 'All')
                                    <option value="All">Select district</option>
                                @else
                                    @foreach ($currentDistrict as $district)
                                        <option value="{{ $district }}" @if ($selectDistrict == $district) selected @endif>
                                            {{ $district }}
                                        </option>
                                    @endforeach
                                @endif

                            </select>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default panel-rose">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                            href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <h4 class="panel-title">Type Pitch</h4>
                            <i class="material-icons">keyboard_arrow_down</i>
                        </a>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel"
                        aria-labelledby="headingThree">
                        <div class="panel-body panel-refine">
                            @foreach ($types as $type => $value)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="{{ $value }}" data-toggle="checkbox"
                                            name="types[]" @if (in_array($value, $curTypes)) checked @endif>
                                        <span class="checkbox-material"><span class="check"></span></span>
                                        {{ $type }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="panel panel-default panel-rose">
                    <div class="panel-heading" role="tab" id="headingFour">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                            href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <h4 class="panel-title">Services</h4>
                            <i class="material-icons">keyboard_arrow_down</i>
                        </a>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel"
                        aria-labelledby="headingOne">
                        <div class="panel-body">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="" data-toggle="checkbox"
                                        checked=""><span class="checkbox-material"><span
                                            class="check"></span></span>
                                    All
                                </label>
                            </div>

                        </div>
                    </div>
                </div>

                <button class="btn btn-rose btn-round align-items-center" style="margin-top: 20px">
                    <i class="material-icons">search</i>
                    Search
                </button>
            </form>
        </div>

    </div><!-- end card -->
</div>
