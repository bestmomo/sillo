<?php
use Livewire\Volt\Component;

new class extends Component {
    public $title;
    public $dpt;
    public $font;
    public function mount()
    {
        $this->font=($this->dpt) ? 'shadow':'new';
        // Debugbar::info($this->font);
    }
}; ?>

<x-header class="pb-0 mb-[-14px] font-{{ $font }} text-green-400" title="{!! $title !!}">
    @section('title', $title)
</x-header>
