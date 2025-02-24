<?php
include_once 'soluce2.php'; ?>

@php
    $title = 'Soluce 2';
@endphp

@section('title', $title)
<div class="container mx-auto">
    <x-header class="pb-0 mb-[-15px] font-new text-green-400" title="{{ $title }}" separator progress-indicator>
        <x-slot:actions class='pt-5'>
            <x-input class='text-white font-arial' placeholder="{{ __('Search...') }}"
                wire:model.live.debounce.300ms="search" clearable icon="o-magnifying-glass" x-init="$el.focus()" />
        </x-slot:actions>
    </x-header>

    <div class="mt-4 !px-24 ml-12">
        @if ($users ?? null)
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
        @endif
    </div>

    <hr class='my-6'>

    <div class='text-lg'>

        <h2 class='text-xl font-bold mb-3'>À vous d'jouer !</h2>

        <article class='text-justify space-y-3'>
            <p>Codez 🖥️, trouvez une soluce 💪, expliquez ici 🎙️... Puis ⏩ Commit, push, et P.R. 😃 !</p>
        </article>

    </div>

</div>
