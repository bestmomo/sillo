<div class='mt-[-22px]' x-data="{
    choice: null,
    include: null,
    btns: [
        { choice: 'Spoiler', include: 'livewire.gc7.frameworks.alpinejs.ga.01_bases' },
        { choice: 'Tabs', include: 'livewire.gc7.frameworks.alpinejs.ga.02_bases' },
    ],
    setChoice: function(btn) {
        this.choice = btn.choice;
        this.include = btn.include;
    }
}">
    <template x-for="btn in btns" :key="btn.choice.toLowerCase()">

        <button class='mr-3 btn btn-sm' :class="'btn-secondary'" x-on:click="setChoice(btn)">
            <span x-text="btn.choice"></span>
        </button>

    </template>

    <span x-text="choice"></span>

    <hr class="mt-1">

    <div x-cloak x-transition.duration.700ms x-show="choice == 'Spoiler'">
        @include('livewire.gc7.frameworks.alpinejs.ga.01_bases')
    </div>

    <div x-cloak x-transition.duration.700ms x-show="choice == 'Tabs'">
        @include('livewire.gc7.frameworks.alpinejs.ga.02_bases')
    </div>

</div>
