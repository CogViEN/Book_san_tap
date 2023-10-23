@extends('layout_admin.master')
@push('css')
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.pitchareas.update.info', $pitchAreaId) }}" method="post" class="form-horizontal"
                id="form-create-pitcharea" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-8">
                    <label for="name">Pitch Area Name</label>
                    <input type="text" id="name-pitch-area" class="form-control" name="name">
                </div>
                <div class="form-group col-8">
                    <label for="address">Address</label>
                    <input type="text" id="address" class="form-control" name="address">
                </div>
                <div class="form-row col-8 select-location">
                    <div class="form-group col-6">
                        <label>City</label>
                        <select class="form-control select-city" name="province" id="select-city"></select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>District</label>
                        <select class="form-control select-district" name="district" id="select-district"></select>
                    </div>
                </div>
                <div class="form-group col-8">
                    <label>Requirement</label>
                    <textarea name="requirement" id="text-requirement"></textarea>
                </div>
                <div class="form-group col-8">
                    <label>Upload your images</label>
                    <input type="file" id="files" name="images[]" multiple />
                </div>
                <div class="form-group col-8">
                    <button id="btn-submit" onclick="checkOwnerExists()" type="button"
                        class="btn btn-outline-success btn-rounded">
                        <i class="uil-cloud-computing"></i>
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
@endpush
