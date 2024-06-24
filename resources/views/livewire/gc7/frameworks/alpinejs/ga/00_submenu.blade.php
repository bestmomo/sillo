<div class='mt-[-22px]' x-data="{
    choice: null,
    btns: {{ $btns }}, // ['Spoiler', 'Tabs']
}">
    <template x-for="btn in btns" :key="btn">

        <button class='mr-3 btn btn-sm' :class="choice !== btn ? 'btn-primary' : 'btn-secondary'"
            x-on:click="choice = btn" :id="btn">
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
    
    <div x-cloak x-transition.duration.700ms x-show="choice == 'TabsOri'">
        @include('livewire.gc7.frameworks.alpinejs.ga.02_tabs_ori')
    </div>
    
    
    <script>
        // Déclenchement automatique d'un onglet
        window.onload = function() {
            setTimeout(function() {
                // Choix du bouton cliqué par défaut
                let btn = 'Tabs'; 
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
