@extends('layout_admin.master')
@push('css')
@endpush
@section('content')
    <div class="row">
        <div class="col-sm-4">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-danger btn-rounded mb-3"><i class="mdi mdi-plus"></i>
                Create Post</a>
        </div>
        <div class="col-sm-8">
            <div class="text-sm-right">
                <form action="{{ route('admin.posts.index') }}">
                    <div class="btn-group mb-3">
                        <input name="status" value="All" id="btn-all" type="submit" class="btn btn-primary"/>
                    </div>
                    <div class="btn-group mb-3 ml-1">
                        <input name="status" value="Pending" readonly id="btn-pending" type="submit"
                            class="btn btn-light" />
                        <input name="status" value="Accepted" readonly id="btn-accepted" type="submit"
                            class="btn btn-light"/>
                    </div>
                </form>

            </div>
        </div><!-- end col-->
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                @foreach ($arr as $obj)
                    <x-post :obj="$obj" />
                @endforeach
            </div>
            <ul class="pagination pagination-info" style="float: right">
                {{ $arr->appends(request()->all())->links() }}
            </ul>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {

            $('.btn-success').click(function(e) {
                acceptPost($(this).attr('data'));
            });
            $('.btn-danger').click(function(e) {
                abortPost($(this).attr('data'));
            });
            $('.btn-danger').click(function(e) {
                abortPost($(this).attr('data'));
            });

        });

        function acceptPost(id) {
            $.ajax({
                type: "get",
                url: '{{ route('admin.posts.accept') }}',
                data: {
                    id
                },
                dataType: "dataType",
                success: function(response) {

                }
            });
        }

        function abortPost(id) {
            $.ajax({
                type: "get",
                url: '{{ route('admin.posts.abort') }}',
                data: {
                    id
                },
                dataType: "dataType",
                success: function(response) {

                }
            });
        }
    </script>
@endpush
