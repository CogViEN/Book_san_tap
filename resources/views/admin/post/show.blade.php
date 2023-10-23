@extends('layout_admin.master')
@push('css')
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ $post->heading }}</h1>
        </div>
        <div class="card-body">
            {{ $post->description }}
        </div>
    </div>
@endsection
@push('js')
@endpush
