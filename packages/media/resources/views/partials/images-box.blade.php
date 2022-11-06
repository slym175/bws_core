<div class="gallery-images-wrapper list-images">
    @php
        $values = $values == '[]' ? '[]' : $values;
        $attributes = isset($attributes) ? $attributes : [];
        $default_img = config('bws/media::bws-media.default_image', '/vendor/bws/media/images/placeholder.png');
    @endphp
    @php $images = old($name, !is_array($values) ? json_decode($values) : $values); @endphp
    <div class="images-wrapper">
        <div data-name="{{ $name }}"
             class="text-center cursor-pointer js-btn-trigger-add-image default-placeholder-gallery-image @if (is_array($images) && !empty($images) && $images !== [null]) hidden @endif">
            <img src="{{ $default_img }}" alt="{{ trans('bws/media::media.image') }}" width="120">
            <br>
            <p style="color:#c3cfd8">{{ trans('bws/media::media.using_button') }}
                <strong>{{ trans('bws/media::media.select_image') }}</strong> {{ trans('bws/media::media.to_add_more_image') }}.</p>
        </div>
        <input type="hidden" name="{{ $name }}[]">

        <ul class="list-unstyled list-gallery-media-images m-0 @if (!is_array($images) || empty($images)) hidden @endif">
            @if (is_array($images) && !empty($images))
                @foreach($images as $image)
                    @if (!empty($image))
                        <li class="gallery-image-item-handler">
                            <div class="list-photo-hover-overlay position-absolute" style="left: 50%; top: 50%; transform: translate(-50%, -50%)">
                                <ul class="list-unstyled photo-overlay-actions d-inline-flex gap-2 btn-group">
                                    <li>
                                        <a class="mr10 btn-trigger-edit-gallery-image btn btn-success p-3" data-toggle="tooltip" data-placement="bottom"
                                           data-original-title="{{ trans('bws/media::media.change_image') }}">
                                            <i class="fa fa-edit ms-1 mb-1"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="mr10 btn-trigger-remove-gallery-image btn btn-danger p-3" data-toggle="tooltip" data-placement="bottom"
                                           data-original-title="{{ trans('bws/media::media.delete_image') }}">
                                            <i class="fa fa-trash ms-1 mb-1"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="custom-image-box image-box">
                                <input type="hidden" name="{{ $name }}[]" value="{{ $image }}" class="image-data">
                                <img src="{{ bws_media()->getImageUrl($image, Arr::get($attributes, 'allow_thumb', true) == true ? 'thumb' : null) }}" alt="{{ trans('bws/media::media.preview_image') }}" class="preview_image">
                            </div>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
    <a href="#" class="add-new-gallery-image js-btn-trigger-add-image btn btn-primary"
       data-name="{{ $name }}">{{ trans('bws/media::media.add_image') }}
    </a>
</div>

@once
@push('css')
    <style>
        .gallery-image-item-handler {
            display: inline-block;
            position: relative;
        }

        .gallery-image-item-handler .list-photo-hover-overlay {
            opacity: 0;
            z-index: -5;
            transition: opacity .2s ease-in;
        }

        .gallery-image-item-handler:hover .list-photo-hover-overlay {
            opacity: 1;
            z-index: 1;
        }
    </style>
@endpush
@push('js')
    <script id="gallery_select_image_template" type="text/x-custom-template">
        <div class="list-photo-hover-overlay position-absolute" style="left: 50%; top: 50%; transform: translate(-50%, -50%)">
            <ul class="list-unstyled photo-overlay-actions d-inline-flex gap-2 btn-group">
                <li>
                    <a class="mr10 btn-trigger-edit-gallery-image btn btn-success p-3" data-toggle="tooltip" data-placement="bottom"
                       data-original-title="{{ trans('bws/media::media.change_image') }}">
                        <i class="fa fa-edit ms-1 mb-1"></i>
                    </a>
                </li>
                <li>
                    <a class="mr10 btn-trigger-remove-gallery-image btn btn-danger p-3" data-toggle="tooltip" data-placement="bottom"
                       data-original-title="{{ trans('bws/media::media.delete_image') }}">
                        <i class="fa fa-trash ms-1 mb-1"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="custom-image-box image-box">
            <input type="hidden" name="__name__[]" class="image-data">
            <img src="{{ bws_media()->getDefaultImage(false) }}" alt="{{ trans('bws/media::media.preview_image') }}" class="preview_image">
        </div>
    </script>
@endpush
@endonce
