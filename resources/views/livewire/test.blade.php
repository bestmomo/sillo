<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new 
#[Layout('components.layouts.admin')]
class extends Component {

    public string $text = '';

}; ?>


<div>
    <x-editor wire:model="text" label="Description" />
    <br>
    <textarea wire:model="text" rows="10"></textarea>
</div>
