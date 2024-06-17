<?php
use Mary\Traits\Toast;
use Livewire\Volt\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

new
#[Layout('components.layouts.gc7')] 
#[Title('Todos')]
class extends Component {
    use Toast;
    #[Rule('required|min:3')]
    public $todo = '';
    public $todos = [];

    public function mount()
    {
        // dd('ok');
        $this->todos = ['Take out trash', 'Do dishes'];
    }

    public function updatedTodo($value)
    {
        // dd($property, $value);
        $this->todo = ucfirst($value);
    }

    public function add()
    {
        $this->validate();
        $this->todos[] = $this->todo;
        $this->reset('todo');
        $this->success('Task added');
    }
}; ?>

<div>
    <h2>Todos</h2>
    <form wire:submit='add'>
        <div class="flex items-end my-3">
            <x-input type="text" wire:model="todo" placeholder="Type todo..." focus></x-input>
            <x-button class="btn-primary ml-3" type="submit" icon="o-bars-arrow-up" spiner>Add</x-button>
            {{ $todo }}
        </div>
    </form>
    <ul>
        @foreach ($todos as $todo)
            <li>- {{ $todo }}</li>
        @endforeach
    </ul>
</div>
