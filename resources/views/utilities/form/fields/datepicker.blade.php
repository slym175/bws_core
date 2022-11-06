<input
    @if(isset($name) && $name) name="{{ $name }}" @endif
    @if(isset($id) && $id) id="{{ $id }}" @endif
    @if(isset($className) && $className) class="{{ $className }}" @endif
    @if(isset($placeholder) && $placeholder) placeholder="{{ $placeholder }}" @endif
    @if(isset($attributes) && $attributes)
        @foreach($attributes as $attribute => $attribute_value)
            {{ $attribute }}="{{ $attribute_value }}"
        @endforeach
    @endif
/>
@include('bws@core::utilities.form.fields.error_field', [
    'name' => $name
])
<script>
    $('[name="{{ $name }}"]').flatpickr({
        enableTime: !!"{{ $enableTime }}",
        dateFormat: "{{ $dateFormat }}",
        mode: "{{ $mode }}",
    });
</script>
