@props([
    'width' => 24,
    'height' => 24,
    'color' => '#fff',
])

<svg id="MicrophoneIcon" width="{{ $width }}" height="{{ $height }}" {{ $attributes }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
    <rect x="8" y="3" width="8" height="12" rx="4" stroke="{{ $color }}" stroke-width="1.6" />
    <path d="M5 11C5 14.866 8.134 18 12 18C15.866 18 19 14.866 19 11" stroke="{{ $color }}" stroke-width="1.6" stroke-linecap="round" />
    <path d="M12 18V21" stroke="{{ $color }}" stroke-width="1.6" stroke-linecap="round" />
</svg>
