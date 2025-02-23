<?php
include_once 'soluce1.php'; ?>

@php
    $title = 'Soluce 1';
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

    <div class="mt-4 !px-24 ml-12">
        @if ($users->count())
            <div class="grid gap-4">
                @forelse ($users as $user)
                    <div class="text-lg p-3 px-5 bg-base-100 rounded shadow">{{ $user->firstname }}
                    </div>
                @empty
                    <tr>
                        <td class="px-4 py-3" colspan="4">Aucun résultat !</td>
                    </tr>
                @endforelse
            </div>

            <div class="mt-4">{{ $users->links() }}
            </div>
        @else
            <p>
                @if ($users->needRefresh)
                    {{ __('Please wait... Opening a valid page...') }}
                @else
                    {{ __('No result') }}.
                @endif
            </p>

        @endif
    </div>
    
    <hr class='my-6'>

    <div class='text-lg'>

        <h2 class='text-xl font-bold mb-3'>Une première solution trouvée :</h2>

        <article class='text-justify space-y-3'>
            <p>Re-produisons exactements les mêmes actions !</p>
            
            <i>Pour les 'poissons rouges'... : Go Page 10, puis 'Pi' dans le moteur de recherche interne.</i>
            
            <p class='text-green-400'>→ Cette fois, super ! : On a un (ou +) résultats, et on se retrouve page <i>3 (Vous, là encore, c'est p't'être bien différent...)</i> mais en tout cas, pas page 1 :-) !</p>
            
            <p>Par contre, snifff, on a observé un raffraîchissement de la page :-(...Et perdons du coup, les avantages initiaux de LiveWire.</p>
            
            <p class='font-semibold text-xl text-white'>Alors... : Qui va écrire en premier... <span class='link'><a href="{{  route('academy.case.table-filter.soluce2') }}">La Soluce 2</a></span> 😉 ?</p>
            
            <p>Rappel: Dans l'idéal, on n'utilise que la techno LiveWire, pas de JS pur, et donc, on évite ce satané de dsfgd...sfds de rafraichissement ! ;-)</p>
            
        </article>
        
    </div>
    
    
</div>
