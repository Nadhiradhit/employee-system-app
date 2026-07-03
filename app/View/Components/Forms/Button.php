<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public string $variantClass;
    public string $sizeClass;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = 'button',
        public string $variant = 'primary',
        public string $size = 'md',
    ) {
        $this->variantClass = match ($this->variant) {
            'danger'  => 'btn-error',
            'success' => 'btn-success',
            'warning' => 'btn-warning',
            default   => 'btn-primary',
        };

        $this->sizeClass = match ($this->size) {
            'xs' => 'btn-xs',
            'sm' => 'btn-sm',
            'lg' => 'btn-lg',
            default => 'btn-md',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.button');
    }
}
