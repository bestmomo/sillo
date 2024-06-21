<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

new #[Title('Blog')] #[Layout('components.layouts.gc7.main')] class extends Component {
    // https://alpinejs.dev/start-here
}; ?>

<div>
    <script src="/assets/js/helpers.js"></script>

    <div x-data="{
        search: 'bar',
        searchDone: false,
    
        items: ['foo', 'bar', 'baz'],
    
        list: [],
        listLength: 0,
    
        logSearch: function() {
            console.log('RECHERCHE de ' + this.search);
        },
    
        get filteredItems() {
            if (this.searchDone) {
                return this.list
            }
            this.logSearch();
            this.list = this.items.filter(i => i.startsWith(this.search));
            this.listLength = this.list.length;
            this.searchDone = true;
            return this.list;
    
        },
    
        get searchMessage() {
            if (this.search.length > 0) {
                console.log(this.search + this.filteredItems.length)
                return this.search + ' → ' + this.listLength + ' answer' +(this.listLength > 1 ? 's' : '');
            } else {
                console.log('Nothing yet');
                return 'Nothing yet (All ' + this.listLength + ' answers are possible).';
            }
        }
    
    }" x-init="$watch('search', value => searchDone = false)">

        <div x-text="search"></div>
        <div x-text="listLength"></div>
        <x-input x-model="search" placeholder="Search..." />

        <ul>
            <template x-for="item in filteredItems" :key="item">
                <li x-transition.duration.7000ms x-text="item"></li>
            </template>
        </ul>
        <p>Actual search: <span x-text='searchMessage'></span></p>
    </div>

    <hr>

    <div x-data="{
        open: false,
        ucfirst: window.ucFirst,
        openString: function() { return this.ucfirst(this.open.toString()); },
    }" class='my-3'>

        <p x-text="ucfirst('okiii')"></p>

        <button class="bg-blue-500 hover:bg-blue-700 text-white py-2 rounded w-[110px]" :class="!open && 'font-bold'"
            @click="open = ! open">
            <span x-text="open ? 'Hide ( ' + openString() + ' )':'Show ( ' + openString() + ' )'"></span>

        </button>

        <span x-transition.duration.700ms x-cloak x-show="open" @click.outside="open = false"
            class="p-2">Contents...</span>
    </div>
    <hr>
    <div x-data="{ count: 0 }" class='my-3'>
        <x-button class="btn-primary" @click.window="count++">Increment
            <strong x-text="count"></strong></x-button>
    </div>
    <hr>
    <h1 x-data="{ message: 'I ❤️ Alpine' }" x-text="message"></h1>
</div>
