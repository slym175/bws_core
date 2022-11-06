{{--@php dd($attributes) @endphp--}}
@if(isset($action) && $action)
    <a href="{{ $action }}"
       @if(isset($attributes) && $attributes)
           @foreach($attributes as $attribute => $attribute_value)
                {{ $attribute }}="{{ $attribute_value }}"
           @endforeach
       @endif
       class="btn @if(isset($className) && $className) {{ $className }} @endif">
        <span class="spinner-grow spinner-grow-sm me-3 d-none" role="status"></span>
        @if(isset($icon) && $icon)
            <span class="{{ $icon }} me-2"></span>
        @endif
        {{ $label }}
    </a>
@else
    <button type="@if(isset($type) && $type){{ $type === 'ajax' ? 'button' : $type }}@endif"
            @if(isset($attributes) && $attributes)
                @foreach($attributes as $attribute => $attribute_value)
                    {{ $attribute }}="{{ $attribute_value }}"
                @endforeach
            @endif
            class="btn @if(isset($className) && $className) {{ $className }} @endif">
        <span class="spinner-grow spinner-grow-sm me-3 d-none" role="status"></span>
        @if(isset($icon) && $icon)
            <span class="{{ $icon }} me-2"></span>
        @endif
        {{ $label }}
    </button>
@endif
