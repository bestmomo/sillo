<?php

use App\Models\Comment;
use App\Notifications\CommentCreated;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

// Création d'une nouvelle classe anonyme étendant Component
new class() extends Component {
	// Propriétés du composant
	public int $postId;
	public ?Comment $comment    = null;
	public bool $showCreateForm = true;
	public bool $showModifyForm = false;
	public bool $alert          = false;

	// Attribut de validation pour le message des commentaires
	#[Rule('required|max:1000')]
	public string $message = '';

	// Méthode de montage pour initialiser le postId
	public function mount($postId): void
	{
		$this->postId = $postId;
	}

	// Méthode pour créer un nouveau commentaire
	public function createComment(): void
	{
		// Validation des données du formulaire
		$data = $this->validate();

		// Vérification de la validité de l'utilisateur
		if (!Auth::user()->valid) {
			$this->alert = true;
		}

		// Création du commentaire
		$this->comment = Comment::create([
			'user_id' => Auth::id(),
			'post_id' => $this->postId,
			'body'    => $data['message'],
		]);

		// Chargement des relations pour le commentaire créé
		$this->comment->load([
			'post' => function (Builder $query) {$query->with('user')->select('id', 'title', 'user_id'); },
			'user',
		]);

		// Notification de l'auteur de l'article
		$this->comment->post->user->notify(new CommentCreated($this->comment));

		// Réinitialisation du message du formulaire
		$this->message = $data['message'];
	}

	// Méthode pour mettre à jour un commentaire
	public function updateComment(): void
	{
		// Validation des données du formulaire
		$data = $this->validate();

		// Mise à jour du corps du commentaire
		$this->comment->body = $data['message'];
		$this->comment->save();

		// Masquage du formulaire de modification
		$this->toggleModifyForm(false);
	}

	// Méthode pour afficher ou masquer le formulaire de modification
	public function toggleModifyForm(bool $state): void
	{
		$this->showModifyForm = $state;
	}

	// Méthode pour supprimer un commentaire
	public function deleteComment(): void
	{
		// Suppression du commentaire
		$this->comment->delete();

		// Réinitialisation des propriétés du commentaire et du message du formulaire
		$this->comment = null;
		$this->message = '';
	}
}; ?>

<div class="flex flex-col mt-4">
    <!-- Vérifie si un commentaire existe -->
    @if($this->comment)

        <!-- Affiche une alerte si nécessaire -->
        @if($alert)
            <x-alert title="{!!__('This is your first comment')!!}" description="{!!__('It will be validated by an administrator before it appears here')!!}" icon="o-exclamation-triangle" class="alert-warning" />
        @else
            <!-- Affiche les détails du commentaire -->
            <div class="flex justify-between mb-4">            
                <x-avatar :image="Gravatar::get(Auth::user()->email)" class="!w-24">
                    <!-- Titre de l'avatar -->
                    <x-slot:title class="pl-2 text-xl">
                        {{ Auth::user()->name }}
                    </x-slot:title>
                    <!-- Sous-titre de l'avatar avec la date du commentaire et le nombre de commentaires de l'utilisateur -->
                    <x-slot:subtitle class="flex flex-col gap-1 pl-2 mt-2 text-gray-500">
                        <x-icon name="o-calendar" label="{{ $comment->created_at->isoFormat('LL') }}" />
                        <x-icon name="o-chat-bubble-left" label="{{ $comment->user->comments_count }} {{ __(' comments') }}" />
                    </x-slot:subtitle>
                </x-avatar>                

                <div>
                    <!-- Boutons de modification et de suppression du commentaire -->
                    <x-button 
                        label="{{ __('Modify') }}" 
                        wire:click="toggleModifyForm(true)" 
                        class="btn-outline btn-sm" />
                    <x-button 
                        label="{{ __('Delete') }}" 
                        wire:click="deleteComment()"
                        wire:confirm="{{__('Are you sure to delete this comment?')}}" 
                        class="btn-outline btn-error btn-sm" />
                </div>
            </div>

            <!-- Affiche le formulaire de modification si nécessaire -->
            @if($showModifyForm)
                <x-card title="{{ __('Update your comment') }}" shadow="hidden">
                    <x-form wire:submit="updateComment" class="mb-4">
                        <x-textarea
                            wire:model="message"
                            hint="{{ __('Max 1000 chars') }}"
                            rows="5"
                            inline />        
                        <x-slot:actions>
                            <x-button label="{{ __('Cancel') }}" wire:click="toggleModifyForm(false)" class="btn-ghost" />
                            <x-button label="{{ __('Save') }}" class="btn-primary" type="submit" spinner="save" />
                        </x-slot:actions>
                    </x-form>
                </x-card>
            @else
                <!-- Affiche le corps du commentaire -->
                <div class="mb-4">{{ $comment->body }}</div>
            @endif

        @endif

    <!-- Si aucun commentaire n'existe, affiche le formulaire de création -->
    @else

        <x-card title="{{ __('Leave a comment') }}" shadow="hidden">
            <x-form wire:submit="createComment" class="mb-4">
                <x-textarea
                    label=""
                    wire:model="message"
                    placeholder="{{ __('Your comment') }} ..."
                    hint="{{ __('Max 1000 chars') }}"
                    rows="5"
                    inline />        
                <x-slot:actions>
                    <x-button label="{{ __('Save') }}" class="btn-primary" type="submit" spinner="save" />
                </x-slot:actions>
            </x-form>
        </x-card>

    @endif

</div>
