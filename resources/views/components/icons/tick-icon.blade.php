@props([
    'width' => 24,
    'height' => 24,
    'color' => '#fff',
])

<svg id="TickIcon" width="{{ $width }}" height="{{ $height }}" {{ $attributes }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 14" fill="none">
    <path d="M1.5 7.5L5.5 11.5L14.5 2.5" stroke="{{ $color }}" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
</svg>
