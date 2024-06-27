<?php

use Livewire\Volt\Component;

new class extends Component {
    public $subtitle = 'Offset';

    public function mount()
    {
        $this->dispatch('update-subtitle', newSubtitle: $this->subtitle);
        logger('Dispatching update-subtitle event');
    }
}; ?>

<div>
    
    {{-- <x-header class="mb-0 pt-3" title="Série 7 - Offset" shadow separator progress-indicator /> --}}
    <x-header class="mb-0 mt-[-12px]" shadow separator progress-indicator />
    
    <div class="px-3 mt-[-12px]">
    <div class="py-1 px-5 bg-white dark:bg-gray-800 text-white rounded">
        <p>Offset</p>
    </div>
</div>
