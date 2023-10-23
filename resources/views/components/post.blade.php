<style>
    h4 {
        width: auto;
        overflow: hidden;
        white-space: nowrap;
    }
</style>
<div class="col-md-6 col-xl-3">
    <!-- project card -->
    <div class="card d-block">
        <!-- project-thumbnail -->
        <img class="card-img-top" src="http://{{ $avatar }}" alt="project image cap" style="height: 300px">
        <div class="card-img-overlay">
            @if ($status == 'Pending')
                <div class="badge badge-secondary p-1">{{ $status }}</div>
            @else
                <div class="badge badge-success p-1">{{ $status }}</div>
            @endif
        </div>

        <div class="card-body position-relative">
            <!-- project title-->
            <h4 class="mt-0">
                <a href="{{ route('admin.posts.show', $id) }}" class="text-title">{{ $heading }}</a>
            </h4>
            <p class="text-muted font-13 mb-3">
                {{ $description }}
            </p>
            <!-- project detail-->
            <p class="mb-3">
                <span class="text-nowrap">
                    <i class="mdi mdi-timelapse"></i>
                    <b>{{ $created_at }}</b>
                </span>
            </p>
            <div class="mb-3">
                {{-- will do access to view user profile --}}
                <a href="#" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="{{ $user['name'] }}" class="d-inline-block">
                    <img src="{{ $user['avatar'] }}" class="rounded-circle avatar-xs" >
                </a>
            </div>
            <div class="mb-3">
                <div class="text-sm-right">
                    @if ($status == 'Pending')
                        <button data="{{ $id }}" class="btn btn-success btn-rounded">Accept</button>
                    @endif
                    <button data={{ $id }} class="btn btn-danger btn-rounded">Abort</button>
                </div>
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div> <!-- end col -->
