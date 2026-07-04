<label class="{{ $iconOnly ? 'relative inline-block tooltip ' . $tooltipPosition : 'w-full relative' }}"
    @if ($label || $iconOnly) data-tip="{{ $label ?: $placeholder }}" aria-label="{{ $label ?: $placeholder }}" @endif>
    @if ($label && !$iconOnly)
        <span class="label w-24">{{ $label }}</span>
    @endif

    @if ($icon && !$iconOnly)
        <span
            class="material-symbols-outlined absolute flex items-center justify-center pointer-events-none text-base-content/70 left-3 top-1/2 -translate-y-1/2">
            {{ $icon }}
        </span>
    @endif

    <select name="{{ $name }}" {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' =>
                'select ' .
                $variantClass .
                ' ' .
                $sizeClass .
                ' ' .
                ($iconOnly ? 'w-12 opacity-0 cursor-pointer absolute inset-0 z-10' : 'w-full ' . ($icon ? 'pl-2' : '')),
        ]) }}>
        <option disabled {{ $selected === null ? 'selected' : '' }}>{{ $placeholder }}</option>
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" {{ (string) $selected === (string) $value ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>

    @if ($iconOnly)
        <div
            class="btn {{ $variant === 'bordered' ? 'btn-outline border-base-content/20' : $variantClass }} {{ $sizeClass }} w-12 p-0 flex items-center justify-center pointer-events-none">
            @if ($icon)
                <span class="material-symbols-outlined text-base-content/70">
                    {{ $icon }}
                </span>
            @endif
        </div>
    @endif
</label>
