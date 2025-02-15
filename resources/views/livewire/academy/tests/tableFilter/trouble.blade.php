<?php
include_once 'trouble.php'; ?>

@php
    $title = 'Problème filtres / tableau';
@endphp

@section('title', $title)
<div class="container mx-auto">

	<x-header title="{{ $title }}" separator progress-indicator>
		<x-slot:actions>
			<x-input placeholder="{{ __('Search...') }}" wire:model.live.debounce.300ms="search" clearable icon="o-magnifying-glass"/>
			<x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden" link="{{ route('admin') }}"/>
		</x-slot:actions>
	</x-header>

	@include('livewire.admin.tests.tableFilter.submenu')


	<div
		class="mt-4 !px-24 ml-12">
		@if ($items->count())
            <div
                class="grid gap-4">
                @foreach ($items as $item)
                    <div
                        class="text-lg p-4 bg-base-100 rounded shadow">{{ $item->name }}
                    </div>
                @endforeach
            </div>

            <div
                class="mt-4">{{ $items->links() }}
            </div>
        @else
            <p>
                {{ __('No result') }}
                .
            </p>

        @endif
	</div>

	<hr class='my-6'>

	<div class='text-lg'>

		<h2 class='text-xl font-bold mb-3'>Mise en évidence du problème :</h2>

		<p>Voici une liste d'objets affichés 2 par 2 (Au passage, notons le 1<sup>er</sup>
			:
			<b>'Montre'</b>
			😉).</p>


		<p>Comme nous avons au moins 6 items, vous avez en barre de pagination 3 voire plus, comme dernière page...<br>
			<b>Et qu'importe : Cliquons tout-de-même sur le 3!</b>
		</p>

		<p>→ Vous voyez maintenant les produits 5 et 6. Normal 😃</p>

		<p>Maintenant... Tiens ? 2 mots avec des 'r'.! Et si nous souhaitions afficher TOUS les objets ayant un 'r' dans leur nom...?<br>
			<b>Alors, écrivons donc joyeusement 'r' ou 'R' dans le formulaire de recherche !</b>
		</p>

		<p>'Aucun résultat' 😥 !!! Alors qu'on sait qu'il y en a, des résultats ! Grrrr 👺 !!!
		</p>

		<h2 class='text-xl font-bold mt-3'>N.B. :</h2>

		<p>
			- Ce problème est également observable si l'on met à disposition un selecteur du nombre de réponse par page...</p>
		<p>
			- La solution courante consiste à faire un resetPage() si (), solution moyenne puisque qu'elle que soit la page d'où nous 'partons', cela nous ramène page 1 ( C'est vrai que s'il y a au moins un résultat, on le verra 😉 ! ), mais fi de nos choix précédents, et de nos tris éventuels 😭 ...
		</p>

		<p class='mt-3'>Voyons maintenant les solutions déjà trouvées :
			<a class='link' href="javascript:history.back()">Revenir au sommaire des tests</a>.
		</p>

	</div>

</div>

