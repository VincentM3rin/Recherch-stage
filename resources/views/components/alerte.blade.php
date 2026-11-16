@props(['type' => 'info'])

@php
    $colors = [
        'info' => 'background-color: #e0f7fa; color: #006064; border: 1px solid #b2ebf2;',
        'success' => 'background-color: #e8f5e9; color: #1b5e20; border: 1px solid #c8e6c9;',
        'danger' => 'background-color: #ffebee; color: #b71c1c; border: 1px solid #ffcdd2;',
    ];
    $dynamicStyle = $colors[$type] ?? $colors['info'];
@endphp

<div @style([
    'padding: 15px; margin-bottom: 20px; border-radius: 4px;',
    $dynamicStyle
]) {{ $attributes }}>
    {{ $slot }}
</div>