<?php

use App\Models\{Category, Comment, Event, Serie, Survey};
use App\Repositories\PostRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class() extends Component {
	use WithPagination;

	// Propriétés de la classe
	public string $param       = ''; // Paramètre de recherche optionnel
	public ?Category $category = null; // Catégorie actuelle (ou null si aucune)
	public ?Serie $serie       = null; // Série actuelle (ou null si aucune)
	public bool $favorites     = false;
	public Collection $surveys;

	/**
	 * Méthode de montage initiale appelée lors de la création du composant.
	 *
	 * @param string $slug  Slug pour identifier une catégorie ou une série
	 * @param string $param Paramètre de recherche optionnel
	 */
	public function mount(string $slug = '', string $param = ''): void
	{
		$this->param = $param;

		if (request()->is('category/*')) {
			$this->category = $this->getCategoryBySlug($slug);
		} elseif (request()->is('serie/*')) {
			$this->serie = $this->getSerieBySlug($slug);
		} elseif (request()->is('favorites')) {
			$this->favorites = true;
		}

		if (auth()->check()) {
			$this->surveys = Survey::where('active', true)->get();
		}
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
		if ($this->favorites) {
			return $postRepository->getFavoritePosts(auth()->user());
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
		$items = ['posts' => $this->getPosts()];

		if (request()->is('/')) {
			$items['comments'] = Comment::with('user', 'post:id,title,slug')->latest()->take(5)->get();

			// Récupérer les événements à venir
			$upcomingEvents = Event::getUpcomingEvents();

			// Vérifier s'il y a des événements à venir et les formater en tableau
			if ($upcomingEvents->isNotEmpty()) {
				$items['upcoming_events'] = $upcomingEvents->map(function ($event) {
					return $event->formatForFrontend();
				})->toArray(); // Convert the collection to an array
			} else {
				$items['upcoming_events'] = [];
			}
		}

		return $items;
	}

	/**
	 * Récupère une catégorie en fonction du slug.
	 *
	 * @param string $slug Slug pour identifier la catégorie
	 *
	 * @return null|Category La catégorie correspondante ou null
	 */
	protected function getCategoryBySlug(string $slug): ?Category
	{
		// Vérifie si le premier segment de l'URL est 'category'
		return 'category' === request()->segment(1) ? Category::whereSlug($slug)->firstOrFail() : null;
	}

	/**
	 * Récupère une série en fonction du slug.
	 *
	 * @param string $slug Slug pour identifier la série
	 *
	 * @return null|Serie La série correspondante ou null
	 */
	protected function getSerieBySlug(string $slug): ?Serie
	{
		return Serie::whereSlug($slug)->firstOrFail();
	}
};
?>

<div class="relative grid items-center w-full py-5 mx-auto md:px-12 max-w-7xl">

    @if (config('app.flash') !== '')
        <x-alert class="mb-2 alert-warning" dismissible>
            {!! config('app.flash') !!}
        </x-alert>
    @endif

    @auth
        @foreach ($surveys as $survey)
            <x-alert title="{{ __('There is a survey!') }}" description="{!! $survey->title !!}" icon="s-chart-bar" class="mb-2 alert-info" >
                <x-slot:actions>
                    @if(auth()->user()->participatedSurveys()->where('survey_id', $survey->id)->exists())
                        <x-button label="{{ __('See results') }}" link="{{ route('surveys.show', $survey->id) }}" />
                    @else
                        <x-button label="{{ __('Participate') }}" link="{{ route('surveys.doing', $survey->id) }}" />
                    @endif
                </x-slot:actions>
            </x-alert>       
        @endforeach
    @endauth

    <!-- Affichage du titre en fonction de la catégorie, de la série ou du paramètre de recherche -->
    @if ($category)
        <x-header title="{{ __('Posts for category ') }} {{ $category->title }}" size="text-2xl sm:text-3xl md:text-4xl" />
    @elseif($serie)
        <x-header title="{{ __('Posts for serie ') }} {{ $serie->title }}" size="text-2xl sm:text-3xl md:text-4xl" />
    @elseif($param !== '')
        <x-header title="{{ __('Posts for search ') }} '{{ $param }}'" size="text-2xl sm:text-3xl md:text-4xl" />
    @elseif($favorites)
        <x-header title="{{ __('Your favorites posts') }}" size="text-2xl sm:text-3xl md:text-4xl" />
    @endif


    <!-- Pagination supérieure -->
    <div class="mb-4 mary-table-pagination">
        <div class="mb-5 border border-t-0 border-x-0 border-b-1 border-b-base-300"></div>
        {{ $posts->links() }}
    </div>

    <!-- Liste des posts -->
    <div class="container mx-auto">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($posts as $post)
                <x-card
                    class="w-full transition duration-500 ease-in-out shadow-md shadow-gray-500 hover:shadow-xl hover:shadow-gray-500"
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
    
                    <x-slot:menu>
                        @if ($post->pinned)
                            <x-badge value="{{ __('Pinned') }}" class="p-3 badge-warning" />
                        @elseif($post->created_at->gt(now()->subWeeks(config('app.newPost'))))
                            <x-badge value="{{ __('New') }}" class="p-3 badge-success" />
                        @endif
                        @auth
                            @if ($post->is_favorited)
                                <x-icon name="s-star" class="w-6 h-6 text-yellow-500 cursor-pointer" />
                            @endif
                        @endauth
                    </x-slot:menu>
    
                    <x-slot:actions>
                        <div class="flex flex-col items-end space-y-2 sm:items-start sm:flex-row sm:space-y-0 sm:space-x-2">
                            <x-popover>
                                <x-slot:trigger>
                                    <x-button label="{{ $post->category->title }}"
                                        link="{{ url('/category/' . $post->category->slug) }}" class="mt-1 btn-outline btn-sm" />
                                </x-slot:trigger>
                                <x-slot:content class="pop-small">
                                    @lang('Show this category')
                                </x-slot:content>
                            </x-popover>
        
                            @if ($post->serie)
                                <x-popover>
                                    <x-slot:trigger>
                                        <x-button label="{{ $post->serie->title }}"
                                            link="{{ url('/serie/' . $post->serie->slug) }}" class="mt-1 btn-outline btn-sm" />
                                    </x-slot:trigger>
                                    <x-slot:content class="pop-small">
                                        @lang('Show this serie')
                                    </x-slot:content>
                                </x-popover>
                            @endif
                            <x-popover>
                                <x-slot:trigger>
                                    <x-button label="{{ __('Read') }}" link="{{ url('/posts/' . $post->slug) }}"
                                        class="mt-1 btn-outline btn-sm" />
                                </x-slot:trigger>
                                <x-slot:content class="pop-small">
                                    @lang('Read this post')
                                </x-slot:content>
                            </x-popover>
                        </div>
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
    </div>
    

    <!-- Pagination inférieure -->
    <div class="mb-4 mary-table-pagination">
        <div class="mb-5 border border-t-0 border-x-0 border-b-1 border-b-base-300"></div>
        {{ $posts->links() }}
    </div>

    @if (request()->is('/'))
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
                        <x-popover position="top-start">
                            <x-slot:trigger>
                                <x-button icon="s-document-text" link="{{ route('posts.show', $comment->post->slug) }}"
                                    spinner class="btn-ghost btn-sm" />
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
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

    @isset($upcoming_events)
        <x-card title="{{ __('Upcoming events') }}" shadow separator class="flex items-center justify-center mt-4">
            <x-calendar :events="$upcoming_events" months="3" locale="{{ env('APP_CALENDAR_LOCALE') }}" />
        </x-card>
    @endisset
</div>
