<div class="card">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col-md-4">
                <img src="http://{{ $image }}" class="card-img" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{ $pitchArea->name }}</h5>
                    <p class="card-text">
                        Thông tin chủ sân:
                        <a href="#">{{ $owner }}</a>
                    </p>
                    <p class="card-text">
                        <small class="text-muted">
                            Địa chỉ:
                            {{ $pitchArea->address }}
                        </small>
                    </p>
                    <p class="card-text">
                        <small class="text-muted">
                            <a href="{{ $routeEditInfo }}" class="btn btn-info btn-sm">
                                Edit Info
                            </a>
                            <a href="{{ $routeViewDetail }}" class="btn btn-secondary btn-sm">
                                View Detail
                            </a>
                            <a href="" class="btn btn-danger btn-sm float-right">Delete</a>
                        </small>
                    </p>
                </div> <!-- end card-body-->
            </div> <!-- end col -->
        </div> <!-- end row-->
    </div>
</div>
