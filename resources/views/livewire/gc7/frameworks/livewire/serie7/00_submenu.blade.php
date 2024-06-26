<div class='mt-[15px] mb-5' x-data="{
    choice: null,
    btns: {{ $btns }}, // ['Users']
}">
    <template x-for="btn in btns" :key="btn">

        <button class='mr-3 btn btn-sm' :class="choice !== btn ? 'btn-primary' : 'btn-secondary'"
            x-on:click="choice = btn" :id="btn">
            <span x-text="btn"></span>
        </button>

    </template>

    {{-- <span x-text="choice"></span> --}}

    <hr class="mt-2">

    <div x-cloak x-transition.duration.700ms x-show="choice == 'Users'">
        {{-- @include('livewire.gc7.frameworks.livewire.serie7.01_users') --}}
        <livewire:gc7.frameworks.livewire.serie7.01_users />
    </div>
    
    <div x-cloak x-transition.duration.700ms x-show="choice == 'Infinite_Scroll'">
        <livewire:gc7.frameworks.livewire.serie7.02_infinite-scroll />
    </div>
    
    <script>
        // Déclenchement automatique d'un onglet
        window.onload = function() {
            setTimeout(function() {
                // Choix du bouton cliqué par défaut
                let btn = 'Infinite_Scroll'; 
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
