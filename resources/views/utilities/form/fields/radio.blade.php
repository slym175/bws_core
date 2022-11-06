<div @if(isset($id) && $id) id="{{ $id }}" @endif
@if(isset($attributes) && $attributes)
    @foreach($attributes as $attribute => $attribute_value)
        {{ $attribute }}="{{ $attribute_value }}"
    @endforeach
@endif
class="form-check form-check-custom form-check-solid @if(isset($className) && $className) {{ $className }} @endif">
    @php $fid = \Illuminate\Support\Str::swap(['[' => '', ']' => ''], $name).'_'.$value; @endphp
    <input id="flex_check_{{ $fid }}"
           @if(isset($name) && $name) name="{{ $name }}" @endif
           @if(isset($checked) && $checked) checked @endif
           class="form-check-input" type="radio" value="{{ $value }}"
    />
    <label class="form-check-label" for="flex_check_{{ $fid }}">
        {{ $label }}
    </label>
</div>
