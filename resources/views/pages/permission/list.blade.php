@extends('bws@core::layouts.base')

@section('title', 'Permission list')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bws/core/plugins/custom/datatables/datatables.bundle.css') }}">
    <script type="text/javascript" src="{{ asset('vendor/bws/core/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endpush

@section('page_action')
    <a href="" class="btn btn-sm btn-primary">
        <i class="bi bi-plus"></i>
        Load permissions
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            Load permissions
        </div>
    </div>
@endsection

@push('js')
@endpush
