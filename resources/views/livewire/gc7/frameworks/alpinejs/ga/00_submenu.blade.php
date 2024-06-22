<div class='mt-[-20px]' x-data="{
    choice: null,
    btns: [
        { choice: 'spoiler', style: 'secondary', text: 'Spoiler' },
        { choice: 'tabs', style: 'secondary', text: 'Tabs' }
    ]
}">
    <template x-for="btn in btns" :key="btn.text">

        <button class='mr-3 btn btn-sm' :class="'btn-primary'" x-on:click="choice = btn.choice">
            <span x-text="btn.text"></span>
        </button>

    </template>

    <span x-text="choice"></span>

    <hr class="mt-1">

    <div x-cloak x-transition.duration.700ms x-show="choice == 'spoiler'">
        @include('livewire.gc7.frameworks.alpinejs.ga.01_bases')
    </div>

    <div x-cloak x-transition.duration.700ms x-show="choice == 'tabs'">
        @include('livewire.gc7.frameworks.alpinejs.ga.02_bases')
    </div>

</div>


{{-- <div x-data="{ choice: null, btnstyle: 'primary' }">
    @include('livewire.gc7.frameworks.alpinejs.ga.000uuu_btn', ['choice' => 'xxx', 'buttonStyle' => 'secondary', 'buttonText' => 'Spoiler'])
    @include('livewire.gc7.frameworks.alpinejs.ga.000uuu_btn', ['choice' => 'xxx', 'buttonStyle' => 'secondary', 'buttonText' => 'Tabs'])
</div> --}}


{{-- <p x-text="btnstyle"></p> --}}


{{-- @livewire('gc7.frameworks.alpinejs.ga.000uuu_btn', ['color'=>'red']) --}}


{{-- <x-button class='btn-secondary btn-sm' @click="choice='tabs'; btnstyle = 'secondary'">Onglets</x-button> --}}

{{-- <hr class="mt-1"> --}}





{{-- @include('livewire.gc7.frameworks.alpinejs.ga.77_bases') --}}
{{-- </div> --}}
