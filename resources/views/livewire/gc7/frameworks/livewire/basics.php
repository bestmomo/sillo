<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};

new #[Title('Basics')] #[Layout('components.layouts.gc7.main')] class extends Component {
	public $name = '';

	public function mount()
	{
		$this->name = auth()->user()->name ?? 'Friend !';
	}
}; ?>

<div>
  <x-header class="pb-0 mb-[-14px]" title="Basics" shadow separator progress-indicator />
  <h2>Hello Wold, <b>{{ $name }}</b>!</h2>
  <hr>
  The current time is {{ time() }} seconds since 1/1/1970.<br>
  The complete current date is <b>{{ date('Y-m-d H:i:s', time()) }}</b>.
  <hr>
  <div class="text-right mt-3">
    <x-button wire:click='$refresh' class='btn-primary'>Refresh</x-button>
  </div>
</div>
