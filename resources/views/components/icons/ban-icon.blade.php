@props([
    'width' => 24,
    'height' => 24,
    'color' => '#fff',
])

<svg id="BanIcon" width="{{ $width }}" height="{{ $height }}" stroke="{{ $color }}" {{ $attributes }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" stroke-width="4.5" fill="none">
    <circle cx="32" cy="32" r="25.3" />
    <line x1="49.89" y1="49.89" x2="14.11" y2="14.11" />
</svg>
