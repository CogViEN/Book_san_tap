@extends('layout_owner.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <a class="btn btn-success mb-2" href="{{ route('owner.pitchareas.create') }}">Add</a>
            </div>
            @for ($i = 0; $i < count($arrPitchArea); $i++)
                <x-pitch-area :pitchArea="$arrPitchArea[$i]" :image="$arrImage[$i]" :owner="$arrOwner[$i]" />
            @endfor
            <ul class="pagination pagination-info" style="float: right">
                {{ $arrPitchArea->appends(request()->all())->links() }}
            </ul>
        </div>
    </div>
@endsection
@push('js')
@endpush
