@props([
    'width' => 24,
    'height' => 24,
    'color' => '#fff',
])

<svg id="InfoCircleIcon" width="{{ $width }}" height="{{ $height }}" stroke="{{ $color }}" {{ $attributes }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" />
    <path d="M12 8V13" />
    <path d="M11.9945 16H12.0035" stroke-width="2" />
</svg>
