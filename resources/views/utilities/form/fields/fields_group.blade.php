<div
    @if(isset($id) && $id) id="{{ $id }}" @endif
    class="form-group @if(isset($className) && $className) {{ $className }} @endif"
    @if(isset($attributes) && $attributes)
        @foreach($attributes as $attribute => $attribute_value)
            {{ $attribute }}="{{ $attribute_value }}"
        @endforeach
    @endif
>
    @if(isset($fields) && $fields)
        @foreach($fields as $field)
            {{ $field->render() }}
        @endforeach
    @endif
</div>
