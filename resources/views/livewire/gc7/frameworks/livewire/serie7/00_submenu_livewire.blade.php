<?php
// Sub MENU Livewire
include_once '00_submenu.php';
?>

<div x-data="{ choice: @entangle('choice') }">
    {{-- <x-header class="mb-0 pt-3" title="Série 7 - Btns" shadow separator progress-indicator /> --}}

    <div class="mb-3">
        <h2 class="text-center text-2xl mb-3 font-bold">Sub MENU Livewire</h2>



        <div class='flex justify-between'>
            @foreach ($btns as $btn)
                {{-- <span x-text="choice"></span> --}}
                <button wire:click="setChoice('{{ $btn }}')" class="mr-3 btn btn-sm mb-0 pb-0"
                    :class="choice !== '{{ $btn }}' ? 'btn-primary' : 'btn-secondary'"
                    x-transition.duration.2000ms id={{ $btn }}>
                    {{ $btn }}
                </button>
            @endforeach
        </div>
        <x-header class="mb-0 pt-0" shadow separator progress-indicator />
    </div>

    <div class='flex justify-evenly'>
        <span>CHOICE PHP: {{ $choice }}</span>
        <span> - </span>
        <span>CHOICE JS: <span x-text="choice"></span></span>
    </div>

    <hr class="mt-20">ooo

    <p>Sub: {{ $subtitle }} - ok</p>
    @livewire('gc7.frameworks.livewire.serie7.01_users')
    
    {{-- <livewire:gc7.frameworks.livewire.serie7.01_users :subtitle="$subtitle" /> --}}

    <!-- Display the active component -->
    {{-- @foreach ($this->getComponents() as $component)
        @ if ($activeComponent === $component['name'])
            <div>
                <livewire:gc7.frameworks.livewire.serie7.' . strtolower($component['name']) />
            </div>
        @endif
    @endforeach --}}

    <script>
        // Déclenchement automatique d'un onglet
        window.onload = function() {
            setTimeout(function() {
                // Choix du bouton cliqué par défaut
                let btn = 'Offset';
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
            }, 7); // Attend .007 seconde avant d'exécuter le script
        };
    </script>
</div>
