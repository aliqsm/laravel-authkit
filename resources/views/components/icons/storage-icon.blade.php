@props([
    'width' => 24,
    'height' => 24,
    'color' => '#fff',
])

<svg id="StorageIcon" width="{{ $width }}" height="{{ $height }}" stroke="{{ $color }}" {{ $attributes }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="1.5">
    <path d="M2 5.0769C2 5.0769 3.6667 2 12 2s10 3.0769 10 3.0769v13.8462S20.3333 22 12 22 2 18.9231 2 18.9231V5.0769Z" />
    <path d="M2 13s3.3333 3 10 3 10-3 10-3M2 7s3.3333 3 10 3 10-3 10-3" />
</svg>
