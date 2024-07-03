<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

new 
#[Title('Chat')] 
#[Layout('components.layouts.gc7.main')] 
class extends Component {

}; ?>

<div>
    <x-header title="Chat" shadow separator progress-indicator></x-header>
    @livewire('gc7.frameworks.alpinejs.chats.chat-v1')
</div>
