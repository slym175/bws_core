@if (request()->input('media-action') === 'select-files')
    <html>
        <head>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            {!! bws_media()->renderHeader() !!}
        </head>
        <body>
            {!! bws_media()->renderContent() !!}

            {!! bws_media()->renderFooter() !!}
        </body>
    </html>
@else
    {!! bws_media()->renderHeader() !!}
    {!! bws_media()->renderContent() !!}
    {!! bws_media()->renderFooter() !!}
@endif
