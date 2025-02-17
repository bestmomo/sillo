<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new #[Title('GA')] #[Layout('components.layouts.academy')] class extends Component
{
}; ?>

<div>
    <livewire:academy.components.page-title title='Kanboard'/>
    
    <h2>À venir...</h2>
</div>
