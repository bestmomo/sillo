<?php

use Livewire\Volt\Component;

new class() extends Component {
	public $name = '';

	public function mount()
	{
		$this->name = 'GC7';
	}
}; ?>

<div>
    <h2>Hello Wold, <b>{{ $name }}</b>!</h2>
    <hr>
    The current time is {{ time() }} seconds since 1/1/1970.<br>
    The complete current date is <b>{{ date('Y-m-d H:i:s', time()) }}</b>.
    <hr>
    <div class="text-right mt-3">
        <x-button wire:click='$refresh' class='btn-primary'>Refresh</x-button>
    </div>
</div>
