<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Title('Divers')] #[Layout('components.layouts.gc7.main')] class extends Component {}; ?>

<div>
    <x-header title="Divers" shadow separator progress-indicator></x-header>

    <p id="p1" @click="console.log($event)">Ready.</p>

</div>
