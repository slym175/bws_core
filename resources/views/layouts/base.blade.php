<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <base href="/">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <link href="{{ asset('vendor/bws/core/plugins/global/plugins.bundle.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('vendor/bws/core/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('vendor/bws/core/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('vendor/bws/core/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('vendor/bws/core/css/core.css') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/bws/core/js/core.js') }}"></script>
    @stack('css')
</head>
<body data-kt-name="metronic" id="kt_body" class="header-extended header-fixed header-tablet-and-mobile-fixed">
<script>
    if (document.documentElement) {
        const defaultThemeMode = "system";
        const name = document.body.getAttribute("data-kt-name");
        let themeMode = localStorage.getItem("kt_" + (name !== null ? name + "_" : "") + "theme_mode_value");
        if (themeMode === null) {
            if (defaultThemeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            } else {
                themeMode = defaultThemeMode;
            }
        }
        document.documentElement.setAttribute("data-theme", themeMode);
    }
</script>
@php
    $isAuthPage = isset($isAuthPage) && $isAuthPage;
@endphp
<div class="d-flex flex-column flex-root">
    @if($isAuthPage)
        @yield('content')
    @endif
    @if(!$isAuthPage)
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                @include('bws@core::layouts.header')
                @include('bws@core::layouts.toolbar')
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    <div class="content flex-row-fluid" id="kt_content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <span class="svg-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)"
                  fill="currentColor"/>
            <path
                d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                fill="currentColor"/>
        </svg>
    </span>
</div>
@stack('js')
@include('bws@media::partials.media')
@include('bws@shortcode::partials.shortcode')
@include('bws@core::utilities.toast')
</body>
</html>
