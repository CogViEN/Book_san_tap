@extends('layout_owner.master')
@push('css')
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col">
                    <div class="text-lg-right">
                        <a href="{{ route('owner.appointments.create') }}" class="btn btn-danger mb-2 mr-2">
                            <i class="mdi mdi-basket mr-1"></i>
                            Add New
                        </a>
                    </div>
                </div><!-- end col-->
            </div>
            <div class="row mb-2">
                <div class="col-lg-12">
                    <form id="form-appointment" class="form-inline" action="{{ route('owner.appointments.index') }}">
                        <div class="form-group mb-2">
                            <label for="status-select" class="mr-2">Status</label>
                            <select class="custom-select" name="status" id="status-select">
                                <option selected value="All">All</option>
                                @foreach ($arrStatus as $status => $value)
                                    <option value="{{ $value }}"
                                        @if($oldFilterStatus == $value)
                                            selected
                                        @endif
                                    >
                                    {{ $status }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="status-select" class="mr-2">Pitch Area</label>
                            <select class="custom-select" name="pitcharea" id="pitcharea-select">
                                <option selected value="All">All</option>
                                @foreach ($arrPitchArea as $pitchArea)
                                    <option value="{{ $pitchArea->id }}"
                                        @if($oldFilterPitchArea == $pitchArea->id)
                                            selected
                                        @endif
                                    >
                                    {{ $pitchArea->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="status-select" class="mr-2">Date</label>
                            <select class="custom-select" name="date" id="date-select">
                                <option selected value="All">All</option>
                                <option value="0" 
                                    @if ($oldFilterDate == 0)
                                        selected
                                    @endif
                                >Today</option>
                                <option value="1"
                                    @if ($oldFilterDate == 1)
                                    selected
                                    @endif
                                >Yesterday</option>
                                <option value="7"
                                    @if ($oldFilterDate == 7)
                                    selected
                                    @endif
                                >Last week</option>
                                <option value="30"
                                    @if ($oldFilterDate == 30)
                                    selected
                                    @endif
                                >Last month</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-centered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Cost</th>
                            <th>Detail</th>
                            <th>Require</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>
                                    <a href="apps-ecommerce-orders-details.html"
                                        class="text-body font-weight-bold">#{{ $order->id }}</a>
                                </td>
                                <td>
                                    {{ $order->name }} <br>
                                    <small class="text-muted">{{ $order->phone }}</small>
                                </td>
                                <td>
                                    <h5>
                                        {{ $order->price }}
                                    </h5>
                                </td>
                                <td>
                                    {{ $order->pitch->name_pitch }} <br>
                                    <b>{{ $order->pitch->name }}</b><br>
                                    <b>{{ $order->timeslot }}</b>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="tooltip"
                                        data-html="true" title="{{ $order->require }}">
                                        Read
                                    </button>
                                </td>
                                <td>
                                    @if ($order->status == 'Processing')
                                        <h5><span class="badge badge-warning-lighten">{{ $order->status }}</span></h5>
                                    @elseif ($order->status == 'Accept')
                                        <h5><span class="badge badge-success-lighten">{{ $order->status }}</span></h5>
                                    @elseif ($order->status == 'Abort')
                                        <h5><span class="badge badge-danger-lighten">{{ $order->status }}</span></h5>
                                    @endif
                                </td>
                                <td>
                                    {{ $order->created_at }}
                                </td>
                                <td>
                                    @if ($order->status == 'Processing')
                                        <a href="javascript:void(0);"
                                            data="{{ route('owner.appointments.accept', $order->id) }}" class="btn-accept"
                                            style="color: green">
                                            <i class="mdi mdi-square-edit-outline"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            data="{{ route('owner.appointments.abort', $order->id) }}" class="btn-delete"
                                            style="color: red">
                                            <i class="mdi mdi-delete"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <ul class="pagination pagination-info" style="float: right">
                {{ $orders->appends(request()->all())->links() }}
            </ul>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            // catch event when accept or abort
            $('.btn-delete').click(function(e) {
                abortOrder($(this).attr('data'));
                $(this).closest("tr").each(function() {
                    $(this).children("td:eq(5)").html(
                        `<h5><span class="badge badge-danger-lighten">Abort </span></h5>`);
                    $(this).children("td:eq(7)").remove();
                });
            });
            $('.btn-accept').click(function(e) {
                acceptOrder($(this).attr('data'));
                $(this).closest("tr").each(function() {
                    $(this).children("td:eq(5)").html(
                        `<h5><span class="badge badge-success-lighten">Accept </span></h5>`);
                    $(this).children("td:eq(7)").remove();
                });
            });

            // catch event when dropdow and input change
            $('#status-select').change(function(event) {
                submitForm(event);
            });
            $('#pitcharea-select').change(function(e) {
                submitForm(event);
            });
            $('#date-select').change(function(e) {
                submitForm(event);
            });
        });

        function abortOrder(curUrl) {
            $.ajax({
                type: "get",
                url: curUrl,
                success: function(response) {
                    notifySuccess('Aborted successfully')
                }
            });
        }

        function acceptOrder(curUrl) {
            $.ajax({
                type: "get",
                url: curUrl,
                success: function(response) {
                    notifySuccess('Accepted successfully')
                }
            });
        }

        function submitForm(event) {
            var $target = $(event.target);
            $target.closest("form").submit();
        }
    </script>
@endpush
