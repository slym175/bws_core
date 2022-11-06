@if(isset($label) && $label)
    <label
        @if(isset($name) && $name) for="{{ $name }}" @endif
        @if(isset($className) && $className) class="@if(isset($required) && $required) {{ 'required' }} @endif {{ $className }}" @endif
        @if(isset($attributes) && $attributes)
            @foreach($attributes as $attribute => $attribute_value)
                {{ $attribute }}="{{ $attribute_value }}"
            @endforeach
        @endif
    >
        {{ $label }}
    </label>
@endif
