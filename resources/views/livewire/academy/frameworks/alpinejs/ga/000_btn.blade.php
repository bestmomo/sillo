<div>
    <div x-data="{ choice: null, btnstyle: 'primary' }">
        <x-button x-on:click="choice='spoiler'; btnstyle = 'secondary'" class="btn-sm btn-primary">Spoiler <span
                x-text="btnstyle"></span></x-button>
        <hr class="mt-1">
        <div x-cloak x-transition.duration.700ms x-show="choice == 'spoiler'">
            @include('livewire.academy.frameworks.alpinejs.ga.01_bases')
        </div>
    </div>
</div>
