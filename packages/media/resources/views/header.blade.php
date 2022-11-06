<meta name="csrf-token" content="{{ csrf_token() }}">

@foreach(bws_media()->getConfig('libraries.stylesheets', []) as $css)
    <link href="{{ url($css) }}" rel="stylesheet" type="text/css"/>
@endforeach

@include('bws@media::config')
