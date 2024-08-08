<?php

use App\Models\{ Comment, Reaction };
use App\Notifications\{CommentAnswerCreated, CommentCreated};
use Illuminate\Support\Collection;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

new class() extends Component {
	// Propriétés du composant
	public ?Comment $comment;
	public ?Collection $children;
	public bool $showAnswerForm = false;
	public bool $showModifyForm = false;
	public int $depth;
	public bool $alert = false;
    public int $likesUp = 0;
    public int $likesDown = 0;
    public int $children_count = 0;

	// Attribut de validation pour le message des commentaires
	#[Rule('required|max:10000')]
	public string $message = '';

	// Initialise le composant avec les données du commentaire.
	public function mount($comment, $depth): void
	{
		$this->comment = $comment;
		$this->depth   = $depth;
		$this->message = strip_tags($comment->body);
        $this->children_count = $comment->children_count;

        $this->likesUp = $comment->reactions()->where('liked', true)->count();
        $this->likesDown = $comment->reactions()->where('liked', false)->count();
	}

	public function showAnswers(): void
	{
		$this->children = Comment::where('parent_id', $this->comment->id)
			->withCount(['children' => function ($query) {
				$query->whereHas('user', function ($q) {
					$q->where('valid', true);
				});
			}])
			->get();

		$this->children_count = 0;
	}

	// Affiche ou masque le formulaire de réponse.
	public function toggleAnswerForm(bool $state): void
	{
		$this->showAnswerForm = $state;
		$this->message        = '';
	}

	// Affiche ou masque le formulaire de modification.
	public function toggleModifyForm(bool $state): void
	{
		$this->showModifyForm = $state;
	}

	// Crée un nouveau commentaire en réponse à celui actuel.
	public function createAnswer(): void
	{
		$data              = $this->validate();
		$data['parent_id'] = $this->comment->id;
		$data['user_id']   = Auth::id();
		$data['post_id']   = $this->comment->post_id;
		$data['body']      = $this->message;

		$item = Comment::create($data);

		$item->save();

		// Notification de l'auteur de l'article
		$item->post->user->notify(new CommentCreated($item));

		// Notification de l'auteur du commentaire initial
		$item->post->user->notify(new CommentAnswerCreated($item));

		// Masquage du formulaire de réponse
		$this->toggleAnswerForm(false);

		// On montre les réponses
		$this->showAnswers();
	}

	// Met à jour le commentaire actuel.
	public function updateAnswer(): void
	{
		// Validation des données du formulaire
		$data = $this->validate();

		// Mise à jour du corps du commentaire
		$this->comment->body = $data['message'];
		$this->comment->save();

		// Masquage du formulaire de modification
		$this->toggleModifyForm(false);
	}

	// Supprime le commentaire actuel.
	public function deleteComment(): void
	{
		// Suppression du commentaire
		$this->comment->delete();

		// Réinitialisation des enfants et du commentaire actuel
		$this->childs  = null;
		$this->comment = null;
	}

    public function like(bool $type): void
    {
        $ipAddress = request()->ip();

        // Vérifiez si l'adresse IP a déjà réagi au commentaire
        $reaction = Reaction::where('comment_id', $this->comment->id)
                            ->where('ip_address', $ipAddress)
                            ->first();

        if ($reaction) {
            $previousLiked = $reaction->liked;

            if ($previousLiked == $type) {
                // Annuler la réaction si elle est la même que le type actuel
                $reaction->delete();

                // Mettre à jour les compteurs
                $type ? $this->likesUp-- : $this->likesDown--;
            } else {
                // Mettre à jour la réaction si elle est différente
                $reaction->update(['liked' => $type]);

                // Mettre à jour les compteurs
                $this->likesUp += $type ? 1 : -1;
                $this->likesDown += $type ? -1 : 1;
            }
        } else {
            // Créer une nouvelle réaction si elle n'existe pas
            Reaction::create([
                'comment_id' => $this->comment->id,
                'liked' => $type,
                'ip_address' => $ipAddress,
            ]);

            // Mettre à jour les compteurs
            $type ? $this->likesUp++ : $this->likesDown++;
        }

        // Simple précaution pour eviter les valeurs inférieures à 0
        $this->likesUp = max(0, $this->likesUp);
        $this->likesDown = max(0, $this->likesDown);
    }

}; ?>

<div>
    <style>
        @media (max-width: 768px) {
            .ml-0 { margin-left: 0rem; }
            .ml-3 { margin-left: 0.75rem; }
            .ml-6 { margin-left: 1.5rem; }
            .ml-9 { margin-left: 2.25rem; }
        }
        @media (min-width: 769px) {
            .ml-0 { margin-left: 0rem; }
            .ml-3 { margin-left: 3rem; }
            .ml-6 { margin-left: 6rem; }
            .ml-9 { margin-left: 9rem; }
        }
    </style>

    <!-- Vérifie si un commentaire existe -->
    @if ($comment)
        <!-- Conteneur du commentaire avec une marge dépendant de la profondeur -->
        <div class="flex flex-col mt-4 ml-{{ $depth * 3 }} lg:ml-{{ $depth * 3 }} border-2 border-gray-400 rounded-md p-2 selection:transition duration-500 ease-in-out shadow-md shadow-gray-500 hover:shadow-xl hover:shadow-gray-500" >
            

            <!-- Entête du commentaire -->
            <div class="flex flex-col justify-between mb-4 md:flex-row">
                <!-- Avatar de l'utilisateur -->
                <x-avatar :image="Gravatar::get($comment->user->email)" class="!w-24">
                    <!-- Titre de l'avatar -->
                    <x-slot:title class="pl-2 text-xl">
                        {{ $comment->user->name }}
                    </x-slot:title>
                    <!-- Sous-titre de l'avatar avec la date du commentaire et le nombre de commentaires de l'utilisateur -->
                    <x-slot:subtitle class="flex flex-col gap-1 pl-2 mt-2 text-gray-500">
                        <x-icon name="o-calendar" label="{{ $comment->created_at->diffForHumans() }}" />
                        <x-icon name="o-chat-bubble-left" label="{{ $comment->user->comments_count }} {{ __(' comments') }}" />
                    </x-slot:subtitle>
                </x-avatar>

                <!-- Actions disponibles pour l'utilisateur authentifié -->
                <div class="flex flex-col mt-4 space-y-2 lg:mt-0 lg:flex-row lg:items-center lg:space-y-0 lg:space-x-2">
                    @auth
                        @if (Auth::user()->name == $comment->user->name)
                            <!-- Bouton pour modifier le commentaire -->
                            <x-button label="{{ __('Modify') }}" wire:click="toggleModifyForm(true)"
                                class="btn-outline btn-warning btn-sm" spinner />
                            <!-- Bouton pour supprimer le commentaire -->
                            <x-button label="{{ __('Delete') }}" wire:click="deleteComment()"
                                wire:confirm="{{ __('Are you sure to delete this comment?') }}"
                                class="mt-2 btn-outline btn-error btn-sm" spinner />
                        @endif
                        <!-- Bouton pour répondre au commentaire -->
                        @if ($depth < config('app.commentsNestedLevel'))
                            <x-button label="{{ __('Answer') }}" wire:click="toggleAnswerForm(true)"
                                class="mt-2 btn-outline btn-sm" spinner />
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Affichage du formulaire de modification ou du corps du commentaire -->
            @if(!$showModifyForm)
                <div class="mb-4">
                    {!! nl2br($comment->body) !!}
                </div>
            @endif
            @if ($showModifyForm || $showAnswerForm)
                <x-card :title="($showModifyForm ? __('Update your comment') : __('Your answer'))" shadow="hidden" class="!p-0">
                    <x-form :wire:submit="($showModifyForm ? 'updateAnswer' : 'createAnswer')" class="mb-4">
                        <x-textarea wire:model="message" :placeholder="($showAnswerForm ? __('Your answer') . ' ...' : '')" hint="{{ __('Max 10000 chars') }}" rows="5" inline />
                        <x-slot:actions>
                            <!-- Bouton pour annuler -->
                            <x-button label="{{ __('Cancel') }}" :wire:click="($showModifyForm ? 'toggleModifyForm(false)' : 'toggleAnswerForm(false)')"
                                class="btn-ghost" />
                            <!-- Bouton pour sauvegarder -->
                            <x-button label="{{ __('Save') }}" class="btn-primary" type="submit" spinner="save" />
                        </x-slot:actions>
                    </x-form>
                </x-card>
            @endif

            <!-- Affichage de l'alerte si activée -->
            @if ($alert)
                <x-alert title="{!! __('This is your first comment') !!}"
                    description="{{ __('It will be validated by an administrator before it appears here') }}"
                    icon="o-exclamation-triangle" class="alert-warning" />
            @endif

            <!-- Affiche les boutons de réaction -->
            <div class="flex justify-end space-x-2">
                <x-button label="{{ $likesUp == 0 ? '0 ' : $likesUp }}" icon="s-hand-thumb-up" wire:click="like(true)" class="btn-success btn-sm" spinner />
                <x-button label="{{ $likesDown == 0 ? '0 ' : $likesDown }}" icon="s-hand-thumb-down" wire:click="like(false)" class="btn-error btn-sm" spinner />
            </div>

            <!-- Bouton pour afficher les enfants du commentaire -->
            @if($children_count > 0)
                <x-button label="{{ __('Show the answers') }} ({{ $children_count }})" wire:click="showAnswers" class="mt-2 btn-outline btn-sm" spinner />
            @endif

        </div>
    @endif

    <!-- Rendu récursif des enfants du commentaire actuel -->
    @if($children)
        @foreach ($children as $child)
            <livewire:posts.comment :comment="$child" :depth="$depth + 1" :key="$child->id">
        @endforeach
    @endif

</div>
