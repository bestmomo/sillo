<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;
new class extends Component {
    use Toast;
    #[Rule('required')]
    public $todo = '';
    public $count = 0, $todos = ['Take out trash', 'Do dishes'];
    public function increment() {
        $this->count = strlen($this->todo);
    }
    public function add() {
        $this->validate();
        $this->todos[] = ucfirst($this->todo);
        $this->reset('todo');
        $this->reset('count');
        $this->success('Done task added');
    }
}; ?>
<div>
    <h2>Todos</h2>
    <form wire:submit='add'>
        <div class="flex items-end my-3">
            <x-input type="text" wire:model="todo" wire:keyup="increment" focus></x-input>
            <x-button class="btn-primary ml-3" type="submit" icon="o-bars-arrow-up" spiner>Add</x-button>
            <span class='ml-3'>Count: {{ $this->count }}</span>
        </div>
    </form>
    <ul>
        @foreach ($todos as $todo)
            <li>- {{ $todo }}</li>
        @endforeach
    </ul>
</div>
