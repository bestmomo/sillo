<?php
use Livewire\Volt\Component;

new class extends Component {
    public $btns;
    public $nochoice;
};
?>

<div x-data="{
    choice: null, // Default: null 
    btns: {{ json_encode($btns) }}
}">
    <div class="w-full flex justify-evenly items-center mb-0 mt-[-27px] p-0">

        <template x-for="btn in btns" :key="btn">

            <button class='mr-3 btn btn-sm mb-0 pb-0' :class="choice !== btn ? 'btn-primary' : 'btn-secondary'"
                x-on:click="choice = btn; console.log('choice = ' + choice); $dispatch('update-subtitle', { newSubtitle: btn })"
                :id="btn">
                <span x-text="btn"></span>
            </button>

        </template>

        <p class="w-1/4 flex justify-between items-center">N.B.:
            <x-icon-student color="#f22" />
            <x-icon-smiley />
        </p>
    </div>

    <hr class="mb-1">

    {{-- Choice: <span x-text="choice"></span> --}}

    {!! $nochoice !!}

    <ul>
        @foreach ($btns as $btn)
            <li>
                <div class="absolute" x-cloak x-transition.opacity.duration.700ms
                    x-show="choice === '{{ $btn }}'">
                    <div wire:key="chat-component-{{ $btn }}">
                        @livewire('gc7.frameworks.alpinejs.chats.chat-' . strtolower($btn), key('chat-' . $btn))
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

</div>

<script>
    // Déclenchement automatique d'un onglet
    window.onload = function() {
        setTimeout(function() {
            // Choix du bouton cliqué par défaut
            let btn = 'V2'; // Default: null
            if (!btn) {
                console.log('Pas de bouton cliqué par défaut')
            } else {

                console.log('Je clique sur ' + btn);
                const btnTabs = document.querySelector('button[id=' + btn + ']');
                if (btnTabs) {
                    btnTabs.click();
                } else {
                    console.log("Le bouton '" + btn + "' n'a pas été trouvé.");
                }
            }
        }, 100); // Attend .1 seconde avant d'exécuter le script
    };
</script>

</div>
