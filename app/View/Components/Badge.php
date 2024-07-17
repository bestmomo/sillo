<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Badge extends Component
{
    public function __construct(
        public string $value,
        public string $type = 'default'
    ) {}

    public function render(): View
    {
        return view('components.badge', [
            'backgroundColor' => $this->getBackgroundColor(),
            'textColor' => $this->getTextColor(),
        ]);
    }

    private function getBackgroundColor(): string
    {
        return match ($this->type) {
            'error' => 'bg-red-500',
            'warning' => 'bg-yellow-500',
            'success' => 'bg-green-500',
            default => 'bg-gray-500',
        };
    }

    private function getTextColor(): string
    {
        return $this->type === 'warning' ? 'text-black' : 'text-white';
    }
}
