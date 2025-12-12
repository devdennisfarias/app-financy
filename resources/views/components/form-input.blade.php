@props(['label', 'name', 'type' => 'text', 'required' => false, 'value' => ''])

<div class="input-group input-group-static mb-3">
    <label class="ms-0">
        {{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="form-control"
        value="{{ old($name, $value) }}" @if ($required) required @endif>
</div>
