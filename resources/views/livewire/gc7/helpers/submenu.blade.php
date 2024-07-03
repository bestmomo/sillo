<?php
use Livewire\Volt\Component;

new class extends Component {
    public $btns;
};
?>

<div x-data="{
    choice: null,
    btns: {{ json_encode($btns) }},
}">
    <div class="w-full flex justify-evenly items-center mb-0 mt-[-27px] p-0">

        <template x-for="btn in btns" :key="btn">

            <button class='mr-3 btn btn-sm mb-0 pb-0' :class="choice !== btn ? 'btn-primary' : 'btn-secondary'"
                x-on:click="choice = btn" :id="btn">
                <span x-text="btn"></span>
            </button>

        </template>

        <p class="w-1/4 flex justify-between items-center">N.B.:
            <x-icon-student color="#f22" />
            <x-icon-smiley />
        </p>
    </div>

    {{-- <span x-text="choice"></span> --}}

    <hr class="mb-1">

    <div class="absolute" x-cloak x-transition.opacity.duration.777ms x-show="choice != 'V1' && choice !='V2'">
        <p>Choose v1 or v2, please !</p>
    </div>

    <div class="absolute" x-cloak x-transition.opacity.duration.700ms x-show="choice == 'V1'">
        @livewire('gc7.frameworks.alpinejs.chats.chat-v1')
    </div>

    <div class="absolute" x-cloak x-transition.opacity.duration.700ms x-show="choice == 'V2'">
        @livewire('gc7.frameworks.alpinejs.chats.chat-v2')
    </div>

    <script>
        // Déclenchement automatique d'un onglet
        window.onload = function() {
            setTimeout(function() {
                // Choix du bouton cliqué par défaut
                let btn = 'Tabsuuu';
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
