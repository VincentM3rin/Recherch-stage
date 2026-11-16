@props(['name', 'label', 'type' => 'text'])

<div style="margin-bottom: 15px;">
    <label for="{{ $name }}" style="display: block; font-weight: bold; margin-bottom: 5px;">
        {{ $label }}
    </label>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"
        {{ $attributes }}
    >
    @error($name)
        <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
    @enderror
</div>