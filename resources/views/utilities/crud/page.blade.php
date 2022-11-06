@extends('bws@core::layouts.base', ['isAuthPage' => false])

@section('title', $pageTitle)

@push('css')
    @if(isset($pageStyles) && $pageStyles)
        @foreach($pageStyles as $style_id => $style)
            <link id="{{ $style_id }}-css" type="text/css" rel="stylesheet" href="{{ $style }}"/>
        @endforeach
    @endif
@endpush

@section('page_action')
    @if(isset($pageActions) && $pageActions)
        @foreach($pageActions as $action)
            <a href="{{ $action['url'] }}" class="{{ $action['className'] }} @if($loop->index > 0) ms-2 @endif">
                @if(isset($action['icon']) && $action['icon'])
                    <i class="{{ $action['icon'] }}"></i>
                @endif
                <span class="fw-normal">{{ $action['label'] }}</span>
            </a>
        @endforeach
    @endif
@endsection

@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="g-5 mb-5">
            <div class="row">
                @foreach($pageContent as $content)
                    <div class="col-12 mb-5">
                        {{ $content }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('js')
    @if(isset($pageScripts) && $pageScripts)
        @foreach($pageScripts as $script_id => $script)
            <script type="text/javascript" src="{{ $script }}"></script>
        @endforeach
    @endif
@endpush
