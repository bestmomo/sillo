<div class='mt-[-22px]' x-data="{
    choice: null,
    include: null,
    btns: {{ $btns }}, // ['Spoiler', 'Tabs']
    setBtnStyle: function(btn) {
        this.choice = btn;
    }
}">
    <template x-for="btn in btns" :key="btn">

        <button class='mr-3 btn btn-sm' :class="choice !== btn ? 'btn-primary':'btn-secondary'" x-on:click="choice = btn"
        x-if="choice==btn"
        >
            <span x-text="btn"></span>
        </button>

    </template>

    {{-- <span x-text="choice"></span> --}}

    <hr class="mt-1">

    <div x-cloak x-transition.duration.700ms x-show="choice == 'Spoiler'">
        @include('livewire.gc7.frameworks.alpinejs.ga.01_bases')
    </div>

    <div x-cloak x-transition.duration.700ms x-show="choice == 'Tabs'">
        @include('livewire.gc7.frameworks.alpinejs.ga.02_bases')
    </div>

</div>
