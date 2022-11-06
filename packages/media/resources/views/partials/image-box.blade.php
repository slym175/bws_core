@php
    $name = isset($name)&&$name?$name:'image';
    $default_img = config('bws/media::bws-media.default_image', '/vendor/bws/media/images/placeholder.png');
    $values = isset($values)&&$values?$values:$default_img;
@endphp
<div class="image-box">
    <input type="hidden" name="{{ $name }}" value="{{ $values === $default_img ? '' : $values }}" class="image-data">
    <div class="preview-image-wrapper ">
        <img src="{{ $values === $default_img ? $default_img : bws_media()->getImageUrl($values, 'thumb') }}"
             data-default="{{ $default_img }}"
             alt="Preview image" class="preview_image" width="150">
        <a class="btn_remove_image" title="Remove image">
            <i class="fa fa-times"></i>
        </a>
    </div>
    <div class="image-box-actions">
        <a href="#" class="btn_gallery" data-result="{{ $name }}" data-action="select-image" data-allow-thumb="1">
            Choose image
        </a>
    </div>
</div>
