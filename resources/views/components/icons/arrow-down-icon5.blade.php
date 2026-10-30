@props([
    'width' => 24,
    'height' => 24,
    'color' => '#fff',
])

<svg id="ArrowDownIcon5" width="{{ $width }}" height="{{ $height }}" {{ $attributes }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
    <path d="M12 3V15" stroke="{{ $color }}" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
    <path d="M7 10L12 15L17 10" stroke="{{ $color }}" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
    <path d="M5 21H19" stroke="{{ $color }}" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
</svg>
