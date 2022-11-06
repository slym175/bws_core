<textarea
    @if(isset($name) && $name) name="{{ $name }}" @endif
    @if(isset($id) && $id) id="{{ $id }}" @endif
    @if(isset($rows) && $rows) rows="{{ $rows }}" @endif
    @if(isset($className) && $className) class="{{ $className }}" @endif
    @if(isset($placeholder) && $placeholder) placeholder="{{ $placeholder }}" @endif
@if(isset($attributes) && $attributes)
    @foreach($attributes as $attribute => $attribute_value)
        {{ $attribute }}="{{ $attribute_value }}"
    @endforeach
@endif
>{{$value}}</textarea>
@include('bws@core::utilities.form.fields.error_field', [
    'name' => $name
])
