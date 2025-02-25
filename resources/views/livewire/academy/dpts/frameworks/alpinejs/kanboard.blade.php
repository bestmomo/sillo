<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new
#[Layout('components.layouts.academy')] 
class extends Component {}; ?>

<div class='mx-6'>
    <livewire:academy.components.page-title title='Kanboard' />
    <x-header shadow separator progress-indicator />

    <h2>À venir...</h2>
</div>
