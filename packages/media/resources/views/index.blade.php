@extends('bws@core::layouts.base', ['isAuthPage' => false])

@section('title', 'Media management')
@push('css')
    {!! bws_media()->renderHeader() !!}
@endpush

@section('page_action')
@endsection

@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            {!! bws_media()->renderContent() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {!! bws_media()->renderFooter() !!}
@endpush
