<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new #[Title('GA')] #[Layout('components.layouts.academy')] class extends Component {
}; ?>

<div>
    <x-header class="mb-0" title="Kanboard" shadow separator progress-indicator />
    <h1>Kanboard</h1>
</div>
