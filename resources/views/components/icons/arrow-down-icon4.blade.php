@props([
    'width' => 24,
    'height' => 24,
    'color' => '#fff',
])

<svg id="ArrowDownIcon4" width="{{ $width }}" height="{{ $height }}" {{ $attributes }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
    <path d="M11.5 5.5V15.5" stroke="{{ $color }}" stroke-width="2" stroke-linecap="round" />
    <path d="M7 12L11.5 16.5L16 12" stroke="{{ $color }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
</svg>
