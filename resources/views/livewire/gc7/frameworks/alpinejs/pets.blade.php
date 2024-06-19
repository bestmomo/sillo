<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new 
#[Title('Pets')] 
#[Layout('components.layouts.gc7.main')]
class extends Component {
}; ?>

<div>
        <x-header title="Pets" shadow separator progress-indicator></x-header>
</div>
