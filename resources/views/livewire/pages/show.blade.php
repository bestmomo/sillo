<?php

use App\Models\Page;
use Livewire\Volt\Component;

// Création d'une nouvelle classe anonyme étendant Component
new class extends Component {
    // Propriété publique pour stocker la page
    public Page $page;

    // Méthode de montage pour initialiser la page
    public function mount(Page $page): void
    {
        if (!$page->active) {
            abort(404);
        }

        $this->page = $page;
    }
}; ?>

<!-- Vue du composant -->
<div>
    @section('title', $page->seo_title ?? $page->title)
    @section('description', $page->meta_description)
    @section('keywords', $page->meta_keywords)

    <!-- Actions disponibles pour les utilisateurs authentifiés -->
    <div class="flex justify-end gap-4">
        @auth
            <!-- Bouton pour modifier la page -->
            @if (Auth::user()->isAdmin())
                <x-popover>
                    <x-slot:trigger>
                        <x-button icon="c-pencil-square" link="{{ route('pages.edit', $page) }}" spinner
                            class="btn-ghost btn-sm" />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                        @lang('Edit this page')
                    </x-slot:content>
                </x-popover>
            @endif
        @endauth
    </div>

    <!-- Entête de la page -->
    <x-header title="{!! $page->title !!}" />

    <!-- Contenu de la page -->
    <div class="relative items-center w-full px-5 py-5 mx-auto prose md:px-12 max-w-7xl">
        {!! $page->body !!}
    </div>
</div>
