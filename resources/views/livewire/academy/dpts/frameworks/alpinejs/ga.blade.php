<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new #[Title('GA')] #[Layout('components.layouts.academy')] class extends Component {}; ?>

<div class='mx-6'>
    @php
        $btns = ['Spoiler', 'TabsOri', 'Tabs'];
    @endphp
    
    <livewire:academy.components.page-title title='G.A.' />
    <x-header shadow separator progress-indicator />

    @include('livewire.academy.dpts.frameworks.alpinejs.ga.00_submenu', ['btns' => json_encode($btns)])

</div>
