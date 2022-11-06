<script>
    "use strict";
    var RV_MEDIA_URL = {!! \Illuminate\Support\Js::from(bws_media()->getUrls()) !!};
    var RV_MEDIA_CONFIG = {!! \Illuminate\Support\Js::from([
        'permissions'  => bws_media()->getConfig('permissions'),
        'translations' => trans('bws/media::media.javascript'),
        'pagination'   => [
            'paged'                => 1,
            'posts_per_page'       => 15,
            'in_process_get_media' => false,
            'has_more'             => true,
        ],
        'chunk'        => [],
        'random_hash'  => 'bizdev_random_hash',
    ]) !!}
</script>
