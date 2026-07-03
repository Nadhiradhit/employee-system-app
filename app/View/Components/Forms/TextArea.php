<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextArea extends Component
{
    public string $variantClass;
    public string $sizeClass;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $placeholder = '',
        public string $size = 'md',
        public string $variant = 'primary',
    ) {
        $this->variantClass = match ($this->variant) {
            'danger'  => 'textarea-error',
            'success' => 'textarea-success',
            'warning' => 'textarea-warning',
            default   => 'textarea-primary',
        };

        $this->sizeClass = match ($this->size) {
            'xs' => 'textarea-xs',
            'sm' => 'textarea-sm',
            'lg' => 'textarea-lg',
            'xl' => 'textarea-xl',
            default => 'textarea-md',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.text-area');
    }
}
