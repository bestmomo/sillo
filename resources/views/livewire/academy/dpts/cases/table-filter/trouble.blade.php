<?php
include_once 'trouble.php'; ?>

@php
    $title = 'Filtres / tableau';
@endphp

@section('title', $title)
<div class="container mx-auto">
    {{-- <livewire:academy.components.page-title title="{{ $title }}" /> --}}
    {{-- <x-header shadow separator progress-indicator /> --}}

    <x-header class="mt-2 pb-0 mb-[-15px] font-new text-green-400" title="{{ $title }}" separator
        progress-indicator>
        <x-slot:actions class='flex justify-evenly'>
            <x-input class='text-white font-arial' placeholder="{{ __('Search...') }}"
                wire:model.live.debounce.300ms="search" clearable icon="o-magnifying-glass" focus />
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    {{-- @include('livewire.admin.tests.tableFilter.submenu') --}}

		<p class='text-center text-xl'>Listing des utilisateurs <small>(Issus de la table <i>academy_users</i>)</small></p>

    <div class="mt-4 !px-24 ml-12">
        <div class="grid gap-4">
            @forelse ($users as $user)
                <div class="text-lg p-3 px-5 bg-base-100 rounded shadow">{{ $user->firstname }}
                </div>
            @empty
                <tr>
                    <td class="px-4 py-3" colspan="4">No users found</td>
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

            <p>Pour un cas d'étude, nous simplifions tout au maximum... En conséquence, ici, nous limitons le nombre de champs, et de composants présents. Nous ne gardons donc que le form de recherche, la liste des noms et la pagination.</p>
            
						<p>Voici donc notre liste d'utilisateurs affichés 3 par 3 (Au passage, notons le 1<sup>er</sup> : <b>'Pier'</b> 😉).</p>


            <p>Comme nous avons au moins 6 items, vous avez en barre de pagination 3 voire plus, comme dernière
                page...<br>
                <b>Et qu'importe : Cliquons tout-de-même sur le 3!</b>
            </p>

            <p>→ Vous voyez maintenant les produits 5 et 6. Normal 😃</p>

            <p>Maintenant... Tiens ? 2 mots avec des 'r'.! Et si nous souhaitions afficher TOUS les objets ayant un 'r'
                dans
                leur nom...?<br>
                <b>Alors, écrivons donc joyeusement 'r' ou 'R' dans le formulaire de recherche !</b>
            </p>

            <p>'Aucun résultat' 😥 !!! Alors qu'on sait qu'il y en a, des résultats ! Grrrr 👺 !!!
            </p>

            <h2 class='text-xl font-bold mt-3'>N.B. :</h2>

            <p>
                - Ce problème est également observable si l'on met à disposition un selecteur du nombre de réponse par
                page...</p>
            <p>
                - La solution courante consiste à faire un resetPage() si (), solution moyenne puisque qu'elle que soit
                la
                page d'où nous 'partons', cela nous ramène page 1 ( C'est vrai que s'il y a au moins un résultat, on le
                verra 😉 ! ), mais fi de nos choix précédents, et de nos tris éventuels 😭 ...
            </p>

            <p class='mt-3'>Voyons maintenant les solutions déjà trouvées :
                <a class='link' href="javascript:history.back()">Revenir au sommaire des tests</a>.
            </p>
        </article>
    </div>

</div>
