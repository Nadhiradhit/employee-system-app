<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public string $variantClass;
    public string $sizeClass;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name = '',
        public string $label = '',
        public array $options = [],
        public ?string $selected = null,
        public bool $required = false,
        public string $size = 'md',
        public string $variant = 'bordered',
        public string $placeholder = 'Select an option',
        public ?string $icon = null,
        public bool $iconOnly = false,
        public string $tooltipPosition = 'tooltip-bottom',
    ) {
        $this->variantClass = match ($this->variant) {
            'primary' => 'select-primary',
            'secondary' => 'select-secondary',
            'accent' => 'select-accent',
            'info' => 'select-info',
            'success' => 'select-success',
            'warning' => 'select-warning',
            'error' => 'select-error',
            'ghost' => 'select-ghost',
            default => 'select-bordered',
        };

        $this->sizeClass = match ($this->size) {
            'xs' => 'select-xs',
            'sm' => 'select-sm',
            'lg' => 'select-lg',
            default => 'select-md',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.select');
    }
}
