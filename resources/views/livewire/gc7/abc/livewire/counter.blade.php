<?php

use Livewire\Volt\Component;

new class extends Component {
    public $count = 10;
    public $by;
    public function mount($by = 1)
    {
        $this->by = (int) $by;
    }
    public function increment($by = 1)
    {
        $this->count += $by;
    }
    public function decrement()
    {
        $this->count -= $this->by;
    }
}; ?>

<div class="mt-1">
    <p>
        Counter: {{ $count }}<br>
        {{-- <x-button class="btn-primary mt-1" wire:click="increment">+</x-button> --}}
        {{-- <x-button class="btn-primary mt-1" wire:mouseenter="increment">+</x-button> --}}
        {{-- <x-button class="btn-primary mt-1" wire:click.window="increment">+</x-button> --}}
        {{-- <x-button class="btn-primary mt-1" wire:click.throttle.3000ms="increment">+</x-button> --}}
        <x-button class="btn-primary mt-1" wire:click.debounce.0ms="increment(5)">+</x-button>
        <x-button class="btn-primary mt-1" wire:click.debounce.0ms="decrement()">-</x-button>
    </p>
</div>
