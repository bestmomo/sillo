<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new #[Title('GA')] #[Layout('components.layouts.academy')] class extends Component {
}; ?>

<div>
    @php
        $btns = ['Spoiler', 'TabsOri', 'Tabs'];
    @endphp
    <x-header class="mb-0" title="GA" shadow separator progress-indicator></x-header>

    @include('livewire.academy.frameworks.alpinejs.ga.00_submenu', ['btns' => json_encode($btns)])

</div>
