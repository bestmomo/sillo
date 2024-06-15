<?php

use Livewire\Volt\Component;

new class extends Component {
    public $todo = '';

    public $todos = ['Take out trash', 'Do dishes'];

    public function add()
    {
        $this->todos[] = $this->todo;
        $this->todo = '';
    }
}; ?>

<div>
    <h2>Todos</h2>

    <div class="flex items-center">
        <x-input type="text" class="my-2" wire:model="todo"></x-input>
        <x-button class="btn-primary ml-3" type="button" wire:click='add'>Add</x-button>

    </div>

    <ul>
        @foreach ($todos as $todo)
            <li>- {{ $todo }}</-li>
        @endforeach
    </ul>
</div>
