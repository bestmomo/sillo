<?php

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Support\Collection;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

// Création d'une nouvelle classe anonyme étendant Component
new class() extends Component {
	// Propriétés publiques du composant
	public Post $post;
	public ?Post $next;
	public ?Post $previous;
	public Collection $comments;
	public bool $listComments = false;
	public int $commentsCount;

	// Attribut de validation pour le message des commentaires
	#[Rule('required|max:1000')]
	public string $message = '';

	// Initialise le composant avec le post spécifié.
	public function mount($slug): void
	{
		// Instanciation d'un nouveau repository de post
		$postRepository = new PostRepository();

		// Récupération du post par le slug
		$this->post = $postRepository->getPostBySlug($slug);

		// Remplissage des propriétés next et previous du post
		$this->fill($this->post->only('next', 'previous'));

		// Comptage des commentaires valides du post
		$this->commentsCount = $this->post->valid_comments_count;

		// Initialisation d'une collection de commentaires
		$this->comments = new Collection();
	}

	// Méthode pour cloner un article
	public function clonePost(int $postId): void
	{
		// Récupération du post original à cloner
		$originalPost = Post::findOrFail($postId);

		// Clonage du post
		$clonedPost = $originalPost->replicate();

		// Instanciation d'un nouveau repository de post
		$postRepository = new PostRepository();

		// Génération d'un slug unique pour le post cloné
		$clonedPost->slug = $postRepository->generateUniqueSlug($originalPost->slug);

		// Désactivation du post cloné
		$clonedPost->active = false;

		// Enregistrement du post cloné
		$clonedPost->save();

		// Redirection vers la page d'édition du post cloné
		redirect()->route('posts.edit', $clonedPost->slug);
	}

	// Méthode pour afficher les commentaires du post
	public function showComments(): void
	{
		// Activation de l'affichage des commentaires
		$this->listComments = true;

		// Récupération des commentaires valides du post avec les informations utilisateur
		$this->comments = $this->post
			->validComments()
			->where('parent_id', null)
			->withCount(['children' => function ($query) {
				$query->whereHas('user', function ($q) {
					$q->where('valid', true);
				});
			}])
			->with([
				'user' => function ($query) {
					$query->select('id', 'name', 'firstname', 'email', 'role')->withCount('comments');
				},
			])
			->latest()
			->get();
	}

	// Méthode pour mettre l'article en favoris
	public function favoritePost(): void
	{
		$user = auth()->user();

		if ($user) {
			$user->favoritePosts()->attach($this->post->id);
			$this->post->is_favorited = true;
		}
	}

	// Méthode pour retirer l'article des favoris
	public function unfavoritePost(): void
	{
		$user = auth()->user();

		if ($user) {
			$user->favoritePosts()->detach($this->post->id);
			$this->post->is_favorited = false;
		}
	}
}; ?>

<div>

    @section('title', $post->seo_title ?? $post->title)
    @section('description', $post->meta_description)
    @section('keywords', $post->meta_keywords)

    <!-- Actions disponibles pour les utilisateurs authentifiés -->
    <div class="flex justify-end gap-4">
        @auth
            <x-popover>
                <x-slot:trigger>
                    @if ($post->is_favorited)
                        <x-button icon="s-star" wire:click="unfavoritePost" spinner
                            class="text-yellow-500 btn-ghost btn-sm" />
                    @else
                        <x-button icon="s-star" wire:click="favoritePost" spinner class="btn-ghost btn-sm" />
                    @endif
                </x-slot:trigger>
                <x-slot:content class="pop-small">
                    @if ($post->is_favorited)
                        @lang('Remove from favorites')
                    @else
                        @lang('Bookmark this post')
                    @endif
                </x-slot:content>
            </x-popover>
            <!-- Bouton pour modifier le post -->
            @if (Auth::user()->isAdmin() || Auth::user()->id == $post->user_id)
                <x-popover>
                    <x-slot:trigger>
                        <x-button icon="c-pencil-square" link="{{ route('posts.edit', $post) }}" spinner
                            class="btn-ghost btn-sm" />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                        @lang('Edit this post')
                    </x-slot:content>
                </x-popover>
                <x-popover>
                    <x-slot:trigger>
                        <x-button icon="o-finger-print" wire:click="clonePost({{ $post->id }})" spinner
                            class="btn-ghost btn-sm" />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                        @lang('Clone this post')
                    </x-slot:content>
                </x-popover>
            @endif
        @endauth
        <!-- Bouton pour afficher la catégorie du post -->
        <x-popover>
            <x-slot:trigger>
                <x-button class="btn-sm"><a
                        href="{{ url('/category/' . $post->category->slug) }}">{{ $post->category->title }}</a></x-button>
            </x-slot:trigger>
            <x-slot:content class="pop-small">
                @lang('Show this category')
            </x-slot:content>
        </x-popover>

        <!-- Bouton pour afficher la série du post (s'il existe) -->
        @if ($post->serie)
            <x-popover>
                <x-slot:trigger>
                    <x-button class="btn-sm"><a
                            href="{{ url('/serie/' . $post->serie->slug) }}">{{ $post->serie->title }}</a></x-button>
                </x-slot:trigger>
                <x-slot:content class="pop-small">
                    @lang('Show this serie')
                </x-slot:content>
            </x-popover>
        @endif
    </div>

    <!-- Titre et date du post -->
    <x-header title="{!! $post->title !!}" subtitle="{{ ucfirst($post->created_at->isoFormat('LLLL')) }} " size="text-2xl sm:text-3xl md:text-4xl" />

    <!-- Contenu du post -->
    <div class="relative items-center w-full py-5 mx-auto prose md:px-12 max-w-7xl">
        <div class="flex flex-col items-center mb-4">
            <img src="{{ asset('storage/photos/' . $post->image) }}" />
        </div>
        <br>
        <div class="text-justify">
            {!! $post->body !!}
        </div>
    </div>
    <br>
    <hr>

    <!-- Informations sur l'auteur et le nombre de commentaires -->
    <div class="flex justify-between">
        <p>@lang('By ') {{ $post->user->name }}</p>
        <em>
            @if ($commentsCount != 0)
                @lang('Number of comments: ') {{ $commentsCount }}
            @else
                @lang('No comments')
            @endif
        </em>
    </div>

    <!-- Navigation entre les posts de la série -->
    @if ($post->serie)
        <br>
        <div class="{{ $previous ? 'flex justify-between' : 'flex justify-end' }}">
            @if ($previous)
                <x-popover>
                    <x-slot:trigger>
                        <x-button label="{{ __('Previous') }}" icon="s-arrow-left"
                            link="{{ url('/posts/' . $previous->slug) }}" class="btn-sm" />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                        @lang('Previous post: ') {{ $previous->title }}
                    </x-slot:content>
                </x-popover>
            @endif
            @if ($next)
                <x-popover>
                    <x-slot:trigger>
                        <x-button label="{{ __('Next') }}" icon-right="s-arrow-right"
                            link="{{ url('/posts/' . $next->slug) }}" class="btn-sm" />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                        @lang('Next post: ') {{ $next->title }}
                    </x-slot:content>
                </x-popover>
            @endif
        </div>
    @endif

    <!-- Section des commentaires -->
    <div class="relative items-center w-full py-5 mx-auto md:px-12 max-w-7xl">
        @if ($listComments)
            <!-- Afficher les commentaires -->
            <x-card title="{{ __('Comments') }}" shadow separator>
                @foreach ($comments as $comment)
                    @if (!$comment->parent_id)
                        <livewire:posts.comment :$comment :depth="0" :key="$comment->id" />
                    @endif
                @endforeach
                <!-- Formulaire pour ajouter un nouveau commentaire -->
                @auth
                    <livewire:posts.commentBase :postId="$post->id" />
                @endauth
            </x-card>
        @else
            <!-- Afficher le bouton pour afficher les commentaires -->
            @if ($commentsCount > 0)
                <div class="flex justify-center">
                    <x-button label="{{ $commentsCount > 1 ? __('View comments') : __('View comment') }}"
                        wire:click="showComments" class="btn-outline" spinner />
                </div>
                <!-- Afficher le formulaire pour ajouter un commentaire si aucun commentaire n'est disponible -->
            @else
                @auth
                    <livewire:posts.commentBase :postId="$post->id" />
                @endauth
            @endif
        @endif
    </div>

    <!-- Section des quizzes -->
    <div class="relative items-center w-full px-5 py-5 mx-auto md:px-12 max-w-7xl">
        @if ($post->quiz)
            <div class="flex justify-center">
                @if (Auth::check())
                    @if ($post->quiz->participants->isNotEmpty())
                        <x-alert
                            title="{{ __('You made the quiz of this post with a score of ') }} {{ $post->quiz->participants->first()->pivot->correct_answers }}/{{ $post->quiz->participants->first()->pivot->total_answers }}."
                            class="alert-info" />
                    @else
                        <x-button label="{{ __('Take the quiz!') }}" link="/quizzes/{{ $post->quiz->id }}"
                            class="btn-outline" />
                    @endif
                @else
                    <x-alert title="{{ __('This post has a quiz. You must been logged to access.') }}"
                        class="alert-info" />
                @endif
            </div>
        @endif
    </div>

</div>
