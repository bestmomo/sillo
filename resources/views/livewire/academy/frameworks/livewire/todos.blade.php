<?php
use Livewire\Attributes\{Layout, Rule, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Layout('components.layouts.academy')] #[Title('Todos')] class extends Component {
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
    <x-header title="Todos" shadow separator progress-indicator>
    </x-header>

    <form wire:submit='add'>
        <div class="flex items-end my-3">
            <x-input type="text" wire:model="todo" placeholder="Type todo here..." focus></x-input>
            <x-button class="btn-primary ml-3 text-lg" type="submit" icon="o-bars-arrow-up" spinner>Add</x-button>
            {{ $todo }}
        </div>
    </form>
    <ul>
        @foreach ($todos as $todo)
            <li wire:key="{{ $loop->index }}">- {{ $todo }}</li>
        @endforeach
    </ul>
</div>
