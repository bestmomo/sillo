<?php

use Livewire\Volt\Component;
use App\Models\{Category, Serie, Comment};
use App\Repositories\PostRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

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
            'posts'     => $this->getPosts(),
            'comments'  => Comment::with('user', 'post:id,title,slug')
                                    ->latest()
                                    ->take(5)
                                    ->get(),
        ];
    }
};
?>

<div class="relative grid items-center w-full px-5 py-5 mx-auto md:px-12 max-w-7xl">

    @if (config('app.flash') !== '')
        <x-alert title="{!! config('app.flash') !!}" icon="o-exclamation-triangle" class="mb-2 alert-warning" dismissible  />
    @endif
    
 
    <!-- Affichage du titre en fonction de la catégorie, de la série ou du paramètre de recherche -->
    @if ($category)
        <x-header title="{{ __('Posts for category ') }} {{ $category->title }}" separator />
    @elseif($serie)
        <x-header title="{{ __('Posts for serie ') }} {{ $serie->title }}" separator />
    @elseif($param !== '')
        <x-header title="{{ __('Posts for search ') }} '{{ $param }}'" separator />
    @endif

    <!-- Pagination supérieure -->
    <div class="mb-4 mary-table-pagination">
        <div class="mb-5 border border-t-0 border-x-0 border-b-1 border-b-base-300"></div>
        {{ $posts->links() }}
    </div>

    <!-- Liste des posts -->
    <div class="grid grid-cols-1 gap-6 mx-auto sm:grid-cols-2 lg:grid-cols-3">
        @forelse($posts as $post)
            <x-card
                class="transition duration-500 ease-in-out shadow-md shadow-gray-500 hover:shadow-xl hover:shadow-gray-500"
                title="{{ $post->title }}">
                <div class="text-justify">{!! str($post->excerpt)->words(config('app.excerptSize')) !!}</div>
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

                <x-slot:actions class="flex items-center">
                    <x-popover>


                        <x-slot:trigger>
                            <x-button label="{{ $post->category->title }}"
                                link="{{ url('/category/' . $post->category->slug) }}" class="btn-outline btn-sm" />
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Show this category')
                        </x-slot:content>
                    </x-popover>

                    @if ($post->serie)
                        <x-popover>
                            <x-slot:trigger>
                                <x-button label="{{ $post->serie->title }}"
                                    link="{{ url('/serie/' . $post->serie->slug) }}" class="btn-outline btn-sm" />
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Show this serie')
                            </x-slot:content>
                        </x-popover>
                    @endif
                    <x-popover>
                        <x-slot:trigger>
                            <x-button label="{{ __('Read') }}" link="{{ url('/posts/' . $post->slug) }}"
                                class="btn-outline btn-sm" />
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Read this post')
                        </x-slot:content>
                    </x-popover>
                </x-slot:actions>
            </x-card>
        @empty
            <div class="col-span-3">
                <x-card title="{{ __('Nothing to show !') }}">
                    {{ __('No Post found with these criteria') }}
                </x-card>
            </div>
        @endforelse
    </div>

    <!-- Pagination inférieure -->
    <div class="mb-4 mary-table-pagination">
        <div class="mb-5 border border-t-0 border-x-0 border-b-1 border-b-base-300"></div>
        {{ $posts->links() }}
    </div>

    @if(!$this->category && !$this->serie)
        <x-card title="{{ __('Recent Comments') }}" shadow separator class="mt-2">
            @foreach ($comments as $comment)
                <x-list-item :item="$comment" no-separator no-hover>
                    <x-slot:avatar>
                        <x-avatar :image="Gravatar::get($comment->user->email)">
                            <x-slot:title>
                                {{ $comment->user->name }}
                            </x-slot:title>
                        </x-avatar>
                    </x-slot:avatar>
                    <x-slot:value>
                        @lang ('in post:') {{ $comment->post->title }}
                    </x-slot:value>
                    <x-slot:actions>
                        <x-popover position="top-start" >
                            <x-slot:trigger>
                                <x-button icon="s-document-text" link="{{ route('posts.show', $comment->post->slug) }}"
                                     spinner class="btn-ghost btn-sm" />
                            </x-slot:trigger>
                            <x-slot:content>
                                @lang('Show post')
                            </x-slot:content>
                        </x-popover>
                    </x-slot:actions>
                </x-list-item>
                <p class="ml-16">{{ Str::words($comment->body, 20, ' ...') }}</p>
                <br>
            @endforeach
        </x-card>
    @endif
</div>
