@props([
    'width' => 24,
    'height' => 24,
    'color' => '#fff',
])

<svg id="RulerIcon" width="{{ $width }}" height="{{ $height }}" stroke="{{ $color }}" {{ $attributes }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
    <path d="M5 17H19C21 17 22 16 22 14V10C22 8 21 7 19 7H5C3 7 2 8 2 10V14C2 16 3 17 5 17Z" />
    <path d="M18 7V12" />
    <path d="M6 7V11" />
    <path d="M10.05 7L10 12" />
    <path d="M14 7V10" />
</svg>
