<?php
include_once 'trouble.php'; ?>

@php
    $title = 'Filtres / tableau';
    
    @endphp

@section('title', $title)
<div class="container mx-auto">
    {{-- <livewire:academy.components.page-title title="{{ $title }}" /> --}}
    {{-- <x-header shadow separator progress-indicator /> --}}
    
    <x-header class="pb-0 mb-[-15px] font-new text-green-400" title="{{ $title }}" separator progress-indicator>
        <x-slot:actions class='pt-5'>
            <x-input class='text-white font-arial' placeholder="{{ __('Search...') }}"
            wire:model.live.debounce.300ms="search" clearable icon="o-magnifying-glass" x-init="$el.focus()" />
        </x-slot:actions>
    </x-header>
    
    <p class='text-center text-xl'>Listing des utilisateurs <small>(Issus de la table <i>academy_users</i>)</small></p>
    
    <div class="mt-4 !px-24 ml-12">
        <div class="grid gap-4">
            @forelse ($users as $user)
                {{-- <div class="text-lg p-3 px-5 bg-base-100 rounded shadow">{{ $user->id }} - {{ $user->firstname }}</div> --}}
                <div class="text-lg p-3 px-5 bg-base-100 rounded shadow">{{ $user->firstname }}</div>
            @empty
                <tr>
                    <td class="px-4 py-3" colspan="4">Aucun résultat !</td>
                </tr>
            @endforelse
        </div>

        <div class="mt-4">{{ $users->links() }}
        </div>
    </div>

    <hr class='my-6'>

    <div class='text-lg'>

        <h2 class='text-xl font-bold mb-3'>Mise en évidence du problème :</h2>

        <article class='text-justify space-y-3'>

            <p>Pour un cas d'étude, nous simplifions tout au maximum... En conséquence, ici, nous limitons le nombre de
                champs, et de composants présents. Nous ne gardons donc que le form de recherche, la liste des prénoms
                et
                la pagination.</p>

            <p>Voici donc notre liste d'utilisateurs affichés 3 par 3 (Au passage, notons le 1<sup>er</sup> :
                <b>'Pier'</b> 😉).
            </p>


            <p>Comme nous avons beaucoup d'items, vous avez une barre de pagination, et comme dernière
                page...<br>
                <b>Et qu'importe : Cliquons sur le 10!</b>
            </p>

            <p>→ Vous voyez maintenant 3 autres users... Normal ! 😃</p>

            <p>Maintenant... Tiens ? Pas de 'Pier'...! Admettons ! Et si nous souhaitions afficher TOUS les users ayant
                'Pier' dans leur nom...?<br>
                <b>Alors, écrivons dès lors joyeusement 'Pi' ou 'PI' ou 'pI'</b> <i>(Ce sont des 'i' majuscules)</i>
                dans le formulaire de recherche ! <i>(Oui, on est aussi économe de nos actions, alors, on réduit
                    là-aussi le problème...)</i>
            </p>

            <p class='text-red-500 !-mb-4'>'Aucun résultat' 😥 !!! Alors qu'on sait qu'il y en a, des résultats... Au
                moins 1 ! Grrrr 👺 !!!
            </p>

            <p>... Sans parler de : 'Montrant à de <i>8</i> résultats', incompréhensible 😞! <i>(N.B.: Pour vous c'est
                    possible autre nombre que 8, les users étants générés par faker()...)</i></p>

            <h2 class='text-xl font-bold mt-3'>N.B. :</h2>

            <p>
                - Ce problème est également observable et autant génant si l'on avait mis à disposition un selecteur du
                nombre de réponses par
                page...</p>
            <p>
                - La solution courante consiste à faire un resetPage(), solution moyenne puisque qu'elle que soit
                la page d'où nous 'partons', cela nous ramène page 1 ( Et c'est vrai qu'il y a là, au moins un résultat,
                on le
                sait déjà 😉 ! ), mais fi de nos choix précédents, et de nos tris éventuels 😭 ...
            </p>

            <p class='text-green-300'>Alors... Ne serait-ce pas judicieux dans un tel cas, de rester à la dernière page
                des résultats possibles... Conséquence + naturelle et intuitive ?</p>

            <p class='mt-3'>Voyons maintenant les solutions allant dans ce sens et déjà trouvées :
                {{-- <a class='link' href="javascript:history.back()">Revenir au sommaire des tests</a>. --}}
                <a class='link' href="/academy/cases">Revenir au sommaire des tests</a>.
            </p>
        </article>
    </div>

</div>
