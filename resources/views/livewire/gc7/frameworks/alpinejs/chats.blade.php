<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

new 
#[Title('Chats')] 
#[Layout('components.layouts.gc7.main')] 
class extends Component {
        
    public $subtitle = 'V1 ou V2 ?';
    protected $listeners = ['update-subtitle' => 'updateSubtitle'];
    
    public function updateSubtitle($newSubtitle)
    {
        $this->subtitle = $newSubtitle;
    }
}; ?>

<div>
    <x-header title="Chat {{ $subtitle ?? '' }}" shadow separator progress-indicator></x-header>
    
    @livewire('gc7.helpers.submenu', ['btns'=>['V1', 'V2']])
</div>
