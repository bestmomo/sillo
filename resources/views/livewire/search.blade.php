<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Rule;

new class extends Component {
  
    #[Rule('required|string|max:100')]
    public string $search = '';

    public function save()
    {
        $data = $this->validate();
        return redirect('/search/' . $data['search']);
    }

}; ?>

<div>
    <form wire:submit="save">
        <x-input placeholder="{{ __('Search') }}..." wire:model="search" clearable icon="o-magnifying-glass" /> 
    </form>
</div>
