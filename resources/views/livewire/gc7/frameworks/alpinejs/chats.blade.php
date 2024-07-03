<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

new 
#[Title('Chats')] 
#[Layout('components.layouts.gc7.main')] 
class extends Component {

}; ?>

<div>
    <x-header title="Chats" shadow separator progress-indicator></x-header>
    
    @livewire('gc7.helpers.submenu', ['btns'=>['V1', 'V2']])
        
    {{-- @livewire('gc7.frameworks.alpinejs.chats.chat-v1') --}}
</div>
