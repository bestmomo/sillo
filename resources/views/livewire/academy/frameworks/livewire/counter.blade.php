<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new #[Layout('components.layouts.academy')] #[Title('Counter')] class extends Component {
	public $count = 100;
	public $by;

	public function mount($by = 1)
	{
		$this->by = (int) $by;
	}

	public function increment($by = 1)
	{
		$this->count += $by ?? $this->by;
	}

	public function decrement()
	{
		$this->count -= $this->by;
	}
}; ?>

<div class="mt-1">
    <x-header title="Counter" shadow separator progress-indicator>
    </x-header>

    <div>

        <p>Counter: {{ $count }}<br>
            {{-- <x-button class="btn-primary mt-1" wire:click="increment">+</x-button> --}}
            {{-- <x-button class="btn-primary mt-1" wire:mouseenter="increment">+</x-button> --}}
            {{-- <x-button class="btn-primary mt-1" wire:click.window="increment">+</x-button> --}}
            {{-- <x-button class="btn-primary mt-1" wire:click.throttle.3000ms="increment">+</x-button> --}}
            {{-- <x-button class="btn-primary mt-1" wire:click.debounce.0ms="increment(5)">+</x-button> --}}
            <x-button class="btn-primary mt-1 text-2xl" wire:click.debounce.0ms="increment(2)"><b>+ 2</b></x-button>
            <x-button class="btn-primary mt-1 text-2xl px-5" wire:click.debounce.0ms="decrement"><b>- 1</b></x-button>
        </p>
    </div>

    <div class="border-t mt-5 pt-3">
        <h2 class="mb-3">Counter with AlpineJS (Src <a href="http://www.penguinui.com/components/counter"
                class="text-blue-500 hover:text-orange-400 transition duration-700" target="_blank">Perguini</a>)</h2>

        <div x-data="{ currentVal: 1, minVal: 0, maxVal: 7, decimalPoints: 0, incrementAmount: 1 }" class="flex flex-col gap-1">
            <label for="counterInput" class="pl-1 text-sm text-slate-700 dark:text-slate-300">Items(s)</label>

            <div @dblclick.prevent class="flex items-center">

                <button @click="currentVal = Math.max(minVal, currentVal - incrementAmount)"
                    class="flex h-10 items-center justify-center rounded-l-xl border border-slate-300 bg-slate-100 px-4 py-2 text-slate-700 hover:opacity-75 focus-visible:z-10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 active:opacity-100 active:outline-offset-0 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:focus-visible:outline-blue-600"
                    aria-label="subtract">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor"
                        fill="none" stroke-width="2" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                    </svg>
                </button>

                <input x-model="currentVal.toFixed(decimalPoints)" id="counterInput" type="text"
                    class="border-x-none h-10 w-20 rounded-none border-y border-slate-300 bg-slate-100/50 text-center text-black focus-visible:z-10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-700 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus-visible:outline-blue-600"
                    readonly />

                <button @click="currentVal = Math.min(maxVal, currentVal + incrementAmount)"
                    class="flex h-10 items-center justify-center rounded-r-xl border border-slate-300 bg-slate-100 px-4 py-2 text-slate-700 hover:opacity-75 focus-visible:z-10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 active:opacity-100 active:outline-offset-0 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:focus-visible:outline-blue-600"
                    aria-label="add">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor"
                        fill="none" stroke-width="2" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>

            </div>

        </div>


    </div>

    <div class="border-t mt-5 pt-3">
        <h2 class="mb-3">Counter with AlpineJS - Kbd possible</h2>

        <div x-data="{
            currentVal: 1,
            minVal: 0,
            maxVal: 7,
            decimalPoints: 0,
            incrementAmount: 1,
            get formattedValue() {
                return this.currentVal.toFixed(this.decimalPoints);
            },
            updateValue(value) {
                let newVal = parseFloat(value);
                if (isNaN(newVal)) return;
                newVal = Math.max(this.minVal, Math.min(this.maxVal, newVal));
                this.currentVal = parseFloat(newVal.toFixed(this.decimalPoints));
            }
        }" class="flex flex-col gap-1">
            <label for="counterInput" class="pl-1 text-sm text-slate-700 dark:text-slate-300">Item(s)</label>

            <div @dblclick.prevent class="flex items-center">
                <button @click="updateValue(currentVal - incrementAmount)"
                    class="flex h-10 items-center justify-center rounded-l-xl border border-slate-300 bg-slate-100 px-4 py-2 text-slate-700 hover:opacity-75 focus-visible:z-10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 active:opacity-100 active:outline-offset-0 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:focus-visible:outline-blue-600"
                    aria-label="subtract">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor"
                        fill="none" stroke-width="2" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                    </svg>
                </button>

                <input x-model="formattedValue" @input="updateValue($event.target.value)"
                    @blur="$event.target.value = formattedValue" id="counterInput" type="text"
                    class="border-x-none h-10 w-20 rounded-none border-y border-slate-300 bg-slate-100/50 text-center text-black focus-visible:z-10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-700 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus-visible:outline-blue-600" />

                <button @click="updateValue(currentVal + incrementAmount)"
                    class="flex h-10 items-center justify-center rounded-r-xl border border-slate-300 bg-slate-100 px-4 py-2 text-slate-700 hover:opacity-75 focus-visible:z-10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 active:opacity-100 active:outline-offset-0 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:focus-visible:outline-blue-600"
                    aria-label="add">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor"
                        fill="none" stroke-width="2" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>
            </div>
        </div>




    </div>
</div>
