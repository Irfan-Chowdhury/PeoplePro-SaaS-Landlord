<div class="input-group">
    <input
        class="@if($errors->has($field)) error @endif"
        name="{{ $field }}"
        id="{{ $field }}"
        type="hidden"
        placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
        value="file"
        readonly
        {{ isset($required) ? 'required' : '' }}>
    @if($errors->has($field))
        @foreach($errors->get($field) as $error)
            <p class="error-text">{!! htmlspecialchars_decode($error) !!}</p>
        @endforeach
    @endif
</div>
