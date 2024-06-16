<?php

use Livewire\Volt\Component;

new class extends Component {
    public $todo = '';
    public $count = 0;
    public $todos = ['Take out trash', 'Do dishes'];

    public function increment()
    {
        $this->count = strlen($this->todo);
    }

    public function add()
    {
        $this->todos[] = ucfirst($this->todo);
        $this->reset('todo');
        $this->reset('count');
    }
}; ?>

<div>
    <h2>Todos</h2>

    <form wire:submit='add'>
        <div class="flex items-center">
            <x-textarea type="text" wire:model="todo" wire:keyup="increment" placeholder="New Task here"
                hint='Count: {{ $this->count }}' focus></x-textarea>
            <x-button class="btn-primary ml-3" type="submit">Add</x-button>
        </div>
    </form>

    <ul>
        @foreach ($todos as $todo)
            <li>- {{ $todo }}</li>
        @endforeach
    </ul>
</div>
