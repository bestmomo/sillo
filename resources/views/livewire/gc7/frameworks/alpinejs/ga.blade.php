<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Title('GA')] #[Layout('components.layouts.gc7.main')] class extends Component {}; ?>

<div>
    @php
        $btns = ['Spoiler', 'TabsOri', 'Tabs'];
    @endphp
    <x-header class="mb-0" title="GA" shadow separator progress-indicator></x-header>

    @include('livewire.gc7.frameworks.alpinejs.ga.00_submenu', ['btns' => json_encode($btns)])
</div>
