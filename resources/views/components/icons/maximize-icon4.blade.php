@props([
    'width' => 24,
    'height' => 24,
    'color' => '#fff',
])

<svg id="MaximizeIcon4" width="{{ $width }}" height="{{ $height }}" stroke="{{ $color }}" {{ $attributes }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
    <path d="M21 9V3H15" />
    <path d="M3 15V21H9" />
    <path d="M21 3L13.5 10.5" />
    <path d="M10.5 13.5L3 21" />
</svg>
