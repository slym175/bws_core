@if(isset($errors) && $errors->any())
    @error($name)
    <small class="text-danger fs-6 mt-2 d-block">{{ $message }}</small>
    @enderror
@endif
