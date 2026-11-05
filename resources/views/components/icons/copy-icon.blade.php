@props([
    'width' => 24,
    'height' => 24,
    'color' => '#fff',
])

<svg id="CopyIcon" width="{{ $width }}" height="{{ $height }}" stroke="{{ $color }}" {{ $attributes }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
    <rect x="8" y="8" width="13" height="13" rx="2" />
    <path d="M16 8V5C16 3.9 15.1 3 14 3H5C3.9 3 3 3.9 3 5V14C3 15.1 3.9 16 5 16H8" />
</svg>