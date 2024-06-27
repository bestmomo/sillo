<?php

use Livewire\Volt\Component;

new class extends Component {
    public function setComponent($value)
    {
        $this->emit('setComponent', $value);
    }
}; ?>

<div>
    <x-header class="mb-0 pt-3" title="Série 7 - Offset" shadow separator progress-indicator />

    <p>Offset</p>
</div>
