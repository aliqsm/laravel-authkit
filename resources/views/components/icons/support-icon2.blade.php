@props([
    'width' => 24,
    'height' => 24,
    'color' => '#fff',
])

<svg id="SupportIcon2" width="{{ $width }}" height="{{ $height }}" stroke="{{ $color }}" {{ $attributes }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
    <path d="M5 10a7 7 0 0 1 14 0" />
    <rect x="4" y="10" width="3" height="6" rx="1.5" />
    <rect x="17" y="10" width="3" height="6" rx="1.5" />
    <path d="M14.5 16.5c0 2-1.8 3.5-4 3.5" />
    <circle cx="10.2" cy="20" r="0.8" fill="{{ $color }}" stroke="none" />
</svg>
