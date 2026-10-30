@props([
    'width' => 24,
    'height' => 24,
    'color' => '#fff',
])

<svg id="SortDescIcon" width="{{ $width }}" height="{{ $height }}" stroke="{{ $color }}" {{ $attributes }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
    <path d="M3 7H21" />
    <path d="M6 12H18" />
    <path d="M10 17H14" />
</svg>
