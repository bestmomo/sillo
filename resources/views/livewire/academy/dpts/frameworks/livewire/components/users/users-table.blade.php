<?php
include_once 'users-table.php';
?>

<div class="w-full" x-data="{selected: @entangle('selection').defer}">

    <style>
        .t3>thead>tr>th {
            background-color: #000;
            color: greenyellow;
        }
    </style>

    <x-header title="Academy Users - MaryUI" shadow separator progress-indicator />
    
    @dump($selected)
    
    {{-- <span x-html="JSON.stringify($wire.selected)"></span> --}}
    <span x-html="$wire.selected"></span>
    
    {{-- @dump($queryStringOutput)

    <div class="mb-3 font-bold" id="queryString">
        <p>Valeur de la querystring : 
            @ if($queryStringOutput)
            {{ json_encode($queryStringOutput) }}</p>
        <pre>{{ print_r($queryStringOutput, true) }}</pre>
        @else
        Vide</p>
        @endif
        <hr>
    </div> --}}

    <div class="flex items-center w-full gap-4 mt-4 justify-evenly">
        <div class="relative flex-grow">
            @include('components.partials.academy.helpers.input')
        </div>
        <div class="flex-shrink-0 whitespace-nowrap">
            Page {{ $users->currentPage() }} / {{ $users->lastPage() }}
        </div>
    </div>

    @if (count($users))
    
    <x-button x-cloak class="mb-3 btn btn-sm btn-error" x-show="$wire.selected.length > 0" wire:click="deleteSelectedUsers" spinner>Supprimer <span x-html="$wire.selected"></span></x-button>
    
        {{-- You can use any `$wire.METHOD` on `@row-click` --}}
        <x-table 
            :headers="$headers" 
            :rows="$users" 
            :sort-by="$sortBy" 
            striped link="#"
            wire:model="selected"
            selectable
            @row-selection="console.log($event.detail.row.id, ($event.detail.selected ? 'selected': 'unselected'))"
            {{-- @row-selection="console.log($event.detail)" --}}
            with-pagination
        >

            @scope('cell_id', $user)
                <div class="!text-right">
                    {{ $user->id }}
                </div>
            @endscope

            @scope('cell_name', $user)
                <span class="font-bold">
                    {{ $user->name }} {{ $user->firstname }}
                </span><br>
                {{ $user->email }}
            @endscope

            @scope('cell_role', $user, $roles)
                <x-badge value="{{ __($roles[$user->role][0]) }}" class="badge-{{ $roles[$user->role][1] ?? null }}" />
            @endscope

            @scope('cell_academyAccess', $user, $roles)
                @if ($user->academyAccess)
                    <span
                        title="{{ trans_choice(':n is registered with the Academy', 'n', ['n' => $user->name]) }}
@if (!$user->valid) {{ __('But invalid status') }} @endif">

                        <x-icon name="o-academic-cap" :class="$user->valid ? 'text-cyan-500' : 'text-red-500'" style="width: 28px; height: 28px;" />
                    </span>
                @else
                    <span
                        title="{{ trans_choice(':n is a :r not student', ['n', 'm'], ['n' => $user->name, 'r' => strtolower(__($roles[$user->role][0]))]) }}
{{ __('Not registered with the Academy') }}">
                        <x-icon name="o-user" class="text-gray-400 w-7 h-7" />
                    </span>
                @endif
            @endscope

            @scope('cell_valid', $user)
                @if ($user->valid)
                    <x-icon-check />
                @else
                    <x-icon-novalid />
                @endif
            @endscope

        </x-table>
    @else
        <p>No users with these criteria</p>
    @endif
    <br>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('console-log', (data) => {
                console.log('From dispatch() < PHP : ', data[0].message);
            });
        });
    </script>

    <script>
        // Fonction pour parser la chaîne de requête
        function parseQueryString() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const params = {};
            for (const [key, value] of urlParams) {
                params[key] = value;
            }
            return params;
        }

        // Fonction pour afficher les paramètres actuels
        function afficherParams(params) {
            console.log("Paramètres actuels :", params);
        }

        // Initialisation
        let paramsActuels = parseQueryString();
        afficherParams(paramsActuels);

        // Écouter les changements d'URL
        window.addEventListener('popstate', function() {
            const nouveauxParams = parseQueryString();

            // Vérifier s'il y a eu des changements
            if (JSON.stringify(nouveauxParams) !== JSON.stringify(paramsActuels)) {
                console.log("La chaîne de requête a changé !");
                afficherParams(nouveauxParams);
                paramsActuels = nouveauxParams;
            }
        });

        // Pour détecter les changements manuels de l'URL sans rechargement de page
        setInterval(function() {
            const nouveauxParams = parseQueryString();

            if (JSON.stringify(nouveauxParams) !== JSON.stringify(paramsActuels)) {
                console.log("La chaîne de requête a été modifiée manuellement !");
                afficherParams(nouveauxParams);
                paramsActuels = nouveauxParams;
            }
        }, 500); // Vérifier toutes les 500ms
    </script>

</div>
