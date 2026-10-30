@props([
    'width' => 24,
    'height' => 24,
    'color' => '#fff',
])

<svg id="CopyIcon2" width="{{ $width }}" height="{{ $height }}" {{ $attributes }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
    <rect x="8" y="8" width="13" height="13" rx="2" stroke="{{ $color }}" stroke-width="1.8" />
    <path d="M16 8V5C16 3.895 15.105 3 14 3H5C3.895 3 3 3.895 3 5V14C3 15.105 3.895 16 5 16H8" stroke="{{ $color }}" stroke-width="1.8" stroke-linecap="round" />
</svg>
