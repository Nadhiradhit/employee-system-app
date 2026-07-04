<button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn ' . $variantClass . ' ' . $sizeClass]) }}>
    @if ($isHaveIcon)
        <span class="material-symbols-outlined">
            {{ $icon }}
        </span>
    @endif
    {{ $slot }}
</button>
