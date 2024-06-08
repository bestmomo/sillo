<?php

use Livewire\Volt\Component;
use App\Models\Page;

// Création d'une nouvelle classe anonyme étendant Component
new class extends Component {

    // Propriété publique pour stocker la page
    public Page $page;
  
    // Méthode de montage pour initialiser la page
    public function mount(Page $page): void
    {
        $this->page = $page;
    }

}; ?>

<!-- Vue du composant -->
<div>
    <!-- Entête de la page -->
    <x-header title="{!! $page->title !!}" />
    
    <!-- Contenu de la page -->
    <div class="relative items-center w-full px-5 py-5 mx-auto prose md:px-12 max-w-7xl">
        {!! $page->body !!}
    </div>  
</div>

