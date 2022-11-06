
{{--@if(isset($attributes) && $attributes) @php dd($attributes) @endphp @endif--}}
<select @if(isset($id) && $id) id="{{ $id }}" @endif
        class="form-select @if(isset($className) && $className) {{ $className }} @endif"
        data-control="select2"
        @if(isset($attributes) && $attributes)
            @foreach($attributes as $attribute => $attribute_value)
                {{ $attribute }}="{{ $attribute_value }}"
            @endforeach
        @endif
        @if(isset($multiple) && $multiple) multiple="multiple" @endif
>
    <option></option>
    @if(isset($options) && $options)
        @foreach($options as $option => $optionLabel)
            @php
                $selected = false;
                if(is_array($value) && in_array($option, $value)) {
                    $selected = true;
                }
                if(!is_array($value) && ((string)$value == (string)$option)) {
                    $selected = true;
                }
            @endphp
            <option @if($selected) selected @endif value="{{ $option }}">{{ $optionLabel }}</option>
        @endforeach
    @endif
</select>
@include('bws@core::utilities.form.fields.error_field', [
    'name' => $name
])
