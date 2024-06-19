<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

new 
#[Title('Blog')] 
#[Layout('components.layouts.gc7.main')] 
class extends Component {
  // https://alpinejs.dev/start-here
}; ?>

  <div>
    <div x-data="{
        search: '',
    
        items: ['foo', 'bar', 'baz'],
    
        get filteredItems() {
            return this.items.filter(
                i => i.startsWith(this.search)
            )
        },
    
        get searchMessage() {
            if (this.search.length > 0) {
                console.log(this.search)
                return this.search;
            } else {
                console.log('Nothing yet');
                return 'Nothing yet';
            }
        }
    
    }">
      <x-input x-model="search" placeholder="Search..." />

        <ul>
          <template x-for="item in filteredItems" :key="item">
          <li x-transition.duration.7000ms x-text="item"></li>
        </template>
      </ul>
      <p>Actual search: <span x-text='searchMessage'></span></p>
    </div>
    <hr>
      <div x-data="{ open: false }" class='my-3'>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            @click="open = ! open">Toggle</button>

      <div x-transition.duration.700ms x-cloak x-show="open" @click.outside="open = false">Contents...</div>
    </div >
    <hr>
    <div x-data="{ count: 0 }" class='my-3'>
        <x-button class="btn-primary" @click.window="count++">Increment
            <strong x-text="count"></strong></x-button>
    </div>
    <hr>
    <h1 x-data="{ message: 'I ❤️ Alpine' }" x-text="message"></h1>
</div>
