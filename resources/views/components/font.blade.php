<style>
    @foreach (config('authkit.font.weights', []) as $weight => $path)
        @font-face {
            font-family: '{{ config('authkit.font.family') }}';
            src: url('{{ asset($path) }}') format('woff2');
            font-weight: {{ $weight }};
            font-display: swap;
        }
    @endforeach

    body {
        font-family: '{{ config('authkit.font.family') }}',
            {{ config('authkit.font.fallback') }} !important;
    }
</style>
