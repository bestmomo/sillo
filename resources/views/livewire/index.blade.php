<?php

use Livewire\Volt\Component;
use App\Models\{Category, Serie};
use App\Repositories\PostRepository;
use Illuminate\Pagination\LengthAwarePaginator;

new class extends Component {
    // Propriétés de la classe
    public string $slug = ''; // Slug pour identifier une catégorie ou une série
    public string $param = ''; // Paramètre de recherche optionnel
    public ?Category $category = null; // Catégorie actuelle (ou null si aucune)
    public ?Serie $serie = null; // Série actuelle (ou null si aucune)

    /**
     * Méthode de montage initiale appelée lors de la création du composant.
     *
     * @param string $slug Slug pour identifier une catégorie ou une série
     * @param string $param Paramètre de recherche optionnel
     * @return void
     */
    public function mount(string $slug = '', string $param = ''): void
    {
        $this->slug = $slug;
        $this->param = $param;

        if (!empty($slug)) {
            // Détermine si le slug correspond à une catégorie ou une série
            $this->category = $this->getCategoryBySlug($slug);
            $this->serie = $this->category ? null : $this->getSerieBySlug($slug);
        }
    }

    /**
     * Récupère une catégorie en fonction du slug.
     *
     * @param string $slug Slug pour identifier la catégorie
     * @return Category|null La catégorie correspondante ou null
     */
    protected function getCategoryBySlug(string $slug): ?Category
    {
        // Vérifie si le premier segment de l'URL est 'category'
        return request()->segment(1) === 'category' ? Category::whereSlug($slug)->firstOrFail() : null;
    }

    /**
     * Récupère une série en fonction du slug.
     *
     * @param string $slug Slug pour identifier la série
     * @return Serie|null La série correspondante ou null
     */
    protected function getSerieBySlug(string $slug): ?Serie
    {
        return Serie::whereSlug($slug)->firstOrFail();
    }

    /**
     * Récupère les posts en fonction de la catégorie, de la série ou du paramètre de recherche.
     *
     * @return LengthAwarePaginator Les posts paginés
     */
    public function getPosts(): LengthAwarePaginator
    {
        $postRepository = new PostRepository();

        // Recherche les posts si un paramètre de recherche est présent
        if (!empty($this->param)) {
            return $postRepository->search($this->param);
        }

        // Récupère les posts paginés en fonction de la catégorie ou de la série
        return $postRepository->getPostsPaginate($this->category, $this->serie);
    }

    /**
     * Définit les variables passées à la vue.
     *
     * @return array Les variables de la vue
     */
    public function with(): array
    {
        return [
            'posts' => $this->getPosts(),
        ];
    }
};
?>

<div class="relative grid items-center w-full px-5 py-5 mx-auto md:px-12 max-w-7xl">

    <!-- Affichage du titre en fonction de la catégorie, de la série ou du paramètre de recherche -->
    @if ($category)
        <x-header title="{{ __('Posts for category ') }} {{ $category->title }}" separator />
    @elseif($serie)
        <x-header title="{{ __('Posts for serie ') }} {{ $serie->title }}" separator />
    @elseif($param !== '')
        <x-header title="{{ __('Posts for search ') }} '{{ $param }}'" separator />
    @endif

    <!-- Pagination supérieure -->
    <div class="mb-4">
        {{ $posts->links() }}
    </div>

    <!-- Liste des posts -->
    <div class="grid w-full grid-cols-1 gap-6 mx-auto sm:grid-cols-2 lg:grid-cols-3 gallery">
        @forelse($posts as $post)
            <x-card title="{{ $post->title }}">
                <div>{!! $post->excerpt !!}</div>
                <br>
                <hr>
                <div class="flex justify-between">
                    <p wire:click="" class="text-left cursor-pointer">{{ $post->user->name }}</p>
                    <p class="text-right"><em>{{ $post->created_at->isoFormat('LL') }}</em></p>
                </div>
                <x-slot:figure>
                    <a href="{{ url('/posts/' . $post->slug) }}">
                        <img src="{{ asset('storage/photos/' . $post->image) }}" alt="{{ $post->title }}" />
                    </a>
                </x-slot:figure>
                <x-slot:actions>
                    <x-button label="{{ $post->category->title }}"
                        link="{{ url('/category/' . $post->category->slug) }}" class="btn-outline btn-sm" />
                    @if ($post->serie)
                        <x-button label="{{ $post->serie->title }}" link="{{ url('/serie/' . $post->serie->slug) }}"
                            class="btn-outline btn-sm" />
                    @endif
                    <x-button label="{{ __('Read') }}" link="{{ url('/posts/' . $post->slug) }}"
                        class="btn-outline btn-sm" />
                </x-slot:actions>
            </x-card>
        @empty
            <div class="col-span-3">
                <x-card class="w-full!important" title="{{ __('Nothing to show !') }}">
                    {{ __('No Post found with these criteria') }}
                </x-card>
            </div>
        @endforelse
    </div>

    <!-- Pagination inférieure -->
    <div class="mb-4">
        {{ $posts->links() }}
    </div>
</div>
