<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public string $variantClass;
    public string $sizeClass;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = 'text',
        public string $name = '',
        public string $placeholder = '',
        public string $label = '',
        public string $value = '',
        public bool $required = false,
        public string $size = 'md',
        public string $variant = 'primary',
    ) {
        $this->variantClass = match ($this->variant) {
            'danger' => 'input-error',
            'success' => 'input-success',
            'warning' => 'input-warning',
            default => 'input-primary',
        };

        $this->sizeClass = match ($this->size) {
            'xs' => 'input-xs',
            'sm' => 'input-sm',
            'md' => 'input-md',
            'lg' => 'input-lg',
            default => 'input-md',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.input');
    }
}
