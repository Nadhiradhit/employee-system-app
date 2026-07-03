<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'btn ' . $variantClass . ' ' . $sizeClass]) }}
>
    {{ $slot }}
</button>