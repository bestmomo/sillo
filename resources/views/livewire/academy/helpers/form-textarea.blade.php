<?php

use App\Models\Comment;
use App\Notifications\CommentCreated;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

new class() extends Component {
	public $id;
	public $action;
	public $title;
	public $placeholder = '';
	public $cancelBtn   = false;
	public int $postId;

	// Attribut de validation pour le message des commentaires
	#[Rule('required|max:1000')]
	public string $message = '';

	public function mount($postId)
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
			'post' => function (Builder $query) {
				$query->with('user')->select('id', 'title', 'user_id');
			},
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
}; ?>

<div>
    FORM HELPER (Post: {{ $postId }})
    <hr>
    <x-card title="{{ __($title) }}" shadow="hidden">
        <x-form wire:submit="createComment" class="mb-4">
            <x-textarea label="" wire:model="message"
                placeholder="{{ $placeholder ? __($placeholder) . '...' : '' }}" hint="{{ __('Max 1000 chars') }}"
                rows="1" inline />
            {{-- ci-dessus 5 --}}

            <x-slot:actions>
                @if ($cancelBtn)
                    <!-- Bouton pour annuler la réponse -->
                    <x-button label="{{ __('Cancel') }}" wire:click="toggleAnswerForm(false)" class="btn-ghost" />
                @endif
                <!-- Bouton pour sauvegarder la réponse -->
                <x-button label="{{ __('Save') }}" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
{{-- 
<div>
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
</div> 
--}}
