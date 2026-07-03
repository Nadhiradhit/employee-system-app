<textarea
    placeholder="{{ $placeholder }}"
    {{ $attributes->merge(['class' => 'textarea ' . $variantClass . ' ' . $sizeClass]) }}
>{{ $slot }}</textarea>