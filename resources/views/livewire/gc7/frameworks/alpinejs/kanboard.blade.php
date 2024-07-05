<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Title('GA')] #[Layout('components.layouts.gc7.main')] class extends Component {}; ?>

<div>
    <x-header class="mb-0" title="Kanboard" shadow separator progress-indicator />
    <h1>Kanboard</h1>
</div>
