<div
    @if(isset($id) && $id) id="{{ $id }}" @endif
    @if(isset($attributes) && $attributes)
        @foreach($attributes as $attribute => $attribute_value)
            {{ $attribute }}="{{ $attribute_value }}"
        @endforeach
    @endif
    @if(isset($className) && $className) class="{{ $className }}" @endif
>
    @if(isset($options) && $options)
        @foreach($options as $option => $optionLabel)
            {{
                \Bws\Core\Facades\Fields\Radio::make($name)
                    ->label($optionLabel)
                    ->setValue($option)
                    ->checked(function () use ($value, $option) {
                        return (is_array($value) ? false : ((string)$value == (string)$option));
                    })
                    ->render()
            }}
        @endforeach
    @endif
</div>
@include('bws@core::utilities.form.fields.error_field', [
    'name' => $name
])
