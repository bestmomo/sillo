<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Title('Alino')] #[Layout('components.layouts.gc7.main')] class extends Component {}; ?>

<div>
    <x-header title="Alino" shadow separator progress-indicator></x-header>

    <div x-data="{ count: 0 }" x-init="console.log('Hello'), console.log('Go !')">
        <p x-text="count"></p>
        <button @click="count++">Increment</button>
    </div>

    <div x-data="{ open: false }">
        <x-button class="btn-primary w-[75px] mt-3" @click="open = !open"><span :class="!open && 'font-bold'"
                x-text="open ? 'Cacher':'Afficher'">Ok</span></x-button>
        <span x-show="open" x-cloak x-transition.duration.700ms>Je suis affiché</span>
    </div>

    <div x-data="{ open: false }">
        <button class="btn btn-primary font-bold mt-5 :style="{ color: 'red' , display: 'flex' }"
            x-on:click="open = ! open">Toggle Dropdown (<span x-text="open"></span>)</button>

        <p class="opacity-30" :class="open && 'text-4xl'">Okiiii</p>

        <p :class="'opacity-50 ' + (open ? 'text-4xl opacity-100' : '')" :style="{ color: 'red', display: 'flex' }">
            Okaaa</p>

        <div :class="open ? '' : 'hidden'" x-cloak>
            Dropdown Contents...
        </div>
    </div>

    <div x-data="dropdown()">
        <button x-bind="trigger">Open Dropdown</button>

        <span x-bind="dialogue">Dropdown Contents</span>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dropdown', () => ({
                open: false,

                trigger: {
                    ['x-ref']: 'trigger',
                    ['@click']() {
                        this.open = true
                    },
                },

                dialogue: {
                    ['x-show']() {
                        return this.open
                    },
                    ['@click.outside']() {
                        this.open = false
                    },
                },
            }))
        })
    </script>

</div>
