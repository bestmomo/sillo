<?php

use Livewire\Volt\Component;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Support\Collection;
use Livewire\Attributes\Rule;

// Création d'une nouvelle classe anonyme étendant Component
new class extends Component {
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
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'name', 'email', 'role')->withCount('comments');
                },
            ])
            ->latest()
            ->get();
    }
}; ?>

<div>
    <!-- Actions disponibles pour les utilisateurs authentifiés -->
    <div class="flex justify-end gap-4">
        @auth
            <!-- Bouton pour modifier le post -->
            @if (Auth::user()->isAdmin() || Auth::user()->id == $post->user_id)
                <x-button icon="c-pencil-square" link="{{ route('posts.edit', $post) }}" tooltip-left="{{ __('Edit') }}"
                    spinner class="btn-ghost btn-sm" />
                <x-button icon="o-finger-print" wire:click="clonePost({{ $post->id }})" tooltip-left="{{ __('Clone') }}"
                    spinner class="btn-ghost btn-sm" />
            @endif
        @endauth
        <!-- Bouton pour afficher la catégorie du post -->
        <x-button class="btn-sm"><a
                href="{{ url('/category/' . $post->category->slug) }}">{{ $post->category->title }}</a></x-button>
        <!-- Bouton pour afficher la série du post (s'il existe) -->
        @if ($post->serie)
            <x-button class="btn-sm"><a
                    href="{{ url('/serie/' . $post->serie->slug) }}">{{ $post->serie->title }}</a></x-button>
        @endif
    </div>

    <!-- Titre et date du post -->
    <x-header title="{!! $post->title !!}" subtitle="{{ ucfirst($post->created_at->isoFormat('LLLL')) }} " />

    <!-- Contenu du post -->
    <div class="relative items-center w-full px-5 py-5 mx-auto prose md:px-12 max-w-7xl">
        <div class="flex flex-col items-center mb-4">
            <img src="{{ asset('storage/photos/' . $post->image) }}" />
        </div>
        <br>
        {!! $post->body !!}
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
                <x-button label="{{ __('Previous') }}" icon="s-arrow-left"
                    link="{{ url('/posts/' . $previous->slug) }}" class="btn-sm" />
            @endif
            @if ($next)
                <x-button label="{{ __('Next') }}" icon-right="s-arrow-right"
                    link="{{ url('/posts/' . $next->slug) }}" class="btn-sm" />
            @endif
        </div>
    @endif

    <!-- Section des commentaires -->
    <div class="relative items-center w-full px-5 py-5 mx-auto md:px-12 max-w-7xl">
        @if ($listComments)
            <!-- Afficher les commentaires -->
            <x-card title="{{ __('Comments') }}" shadow separator>
                @foreach ($comments as $comment)
                    @if (!$comment->parent_id)
                        <livewire:posts.comment :$comment :$comments :depth="0" :key="$comment->id" />
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
                        wire:click="showComments" class="btn-outline" />
                </div>
                <!-- Afficher le formulaire pour ajouter un commentaire si aucun commentaire n'est disponible -->
            @else
                @auth
                    <livewire:posts.commentBase :postId="$post->id" />
                @endauth
            @endif
        @endif
    </div>

</div>
