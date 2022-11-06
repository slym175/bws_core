<input type="{{ $type }}"
       @if(isset($name) && $name) name="{{ $name }}" @endif
       @if(isset($id) && $id) id="{{ $id }}" @endif
       @if(isset($className) && $className) class="{{ $className }}" @endif
       @if(!isset($autoComplete) || !$autoComplete) autocomplete="off" @endif
       @if(isset($autoComplete) && $autoComplete && isset($name) && $name)
       autocomplete="{{ $name }}"
       @endif
       @if(isset($focus) && $focus) autofocus @endif
       @if(isset($placeholder) && $placeholder) placeholder="{{ $placeholder }}" @endif
       @if(isset($value) && $value) value="{{ $value }}" @endif
@if(isset($attributes) && $attributes)
    @foreach($attributes as $attribute => $attribute_value)
        {{ $attribute }}="{{ $attribute_value }}"
    @endforeach
@endif
@if(isset($required) && $required) {{ 'required' }} @endif
/>
@include('bws@core::utilities.form.fields.error_field', [
    'name' => $name
])
