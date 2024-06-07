<?php

use Livewire\Volt\Component;
use App\Models\Comment;
use Livewire\Attributes\Rule;
use Illuminate\Support\Collection;
use App\Notifications\CommentCreated;
use Illuminate\Contracts\Database\Eloquent\Builder;

new class extends Component {

    // Propriétés du composant
    public ?Comment $comment;
    public Collection $comments;
    public array $childs = [];
    public bool $showAnswerForm = false;
    public bool $showModifyForm = false;
    public int $depth;
    public bool $alert = false;

    // Attribut de validation pour le message des commentaires
    #[Rule('required|max:1000')]
    public string $message = '';
   
    // Initialise le composant avec les données du commentaire.
    public function mount($comment, $comments, $depth): void
    {
        $this->comment = $comment;
        $this->comments = $comments;
        $this->depth = $depth;
        $this->message = $comment->body;

        // Récupération des enfants du commentaire actuel
        foreach ($comments as $item) {
            if($item->parent_id == $comment->id) {
                array_unshift($this->childs, $item);
            }
        }
    }

    // Affiche ou masque le formulaire de réponse.
    public function toggleAnswerForm(bool $state): void
    {
        $this->showAnswerForm = $state;        
        $this->message = '';
    }

    // Affiche ou masque le formulaire de modification.
    public function toggleModifyForm(bool $state): void
    {
        $this->showModifyForm = $state;
    }

    // Crée un nouveau commentaire en réponse à celui actuel.
    public function createAnswer(): void
    {
        $data = $this->validate();
        $data['parent_id'] = $this->comment->id;
        $data['user_id'] = Auth::id();
        $data['post_id'] = $this->comment->post_id;
        $data['body'] = $this->message;

        $item = Comment::create($data);

        // Attribution de la profondeur au nouveau commentaire
        $item->depth = $this->depth + 1;        

        // Ajout du nouveau commentaire aux enfants du commentaire actuel
        if(Auth::user()->valid) {
            array_push($this->childs, $item);
        } else {
            $this->alert = true;
        }

        // Chargement des relations pour le nouveau commentaire
        $item->load([
            'post' => function (Builder $query) {$query->with('user')->select('id', 'title', 'user_id');},
            'user',
        ]);

        // Notification de l'utilisateur du post
        $item->post->user->notify(new CommentCreated($item));

        // Masquage du formulaire de réponse
        $this->toggleAnswerForm(false);
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
        $this->childs = [];
        $this->comment = null;
    }

}; ?>

<div>
    <!-- Vérifie si un commentaire existe -->
    @if($comment)
        <!-- Conteneur du commentaire avec une marge dépendant de la profondeur -->
        <div class="flex flex-col mt-4" style="margin-left:{{ $depth * 3 }}rem">
            
            <!-- Entête du commentaire -->
            <div class="flex justify-between mb-4">
                <!-- Avatar de l'utilisateur -->
                <x-avatar :image="Gravatar::get($comment->user->email)" class="!w-24">
                    <!-- Titre de l'avatar -->
                    <x-slot:title class="pl-2 text-xl">
                        {{ $comment->user->name }}
                    </x-slot:title>
                    <!-- Sous-titre de l'avatar avec la date du commentaire et le nombre de commentaires de l'utilisateur -->
                    <x-slot:subtitle class="flex flex-col gap-1 pl-2 mt-2 text-gray-500">
                        <x-icon name="o-calendar" label="{{ $comment->created_at->isoFormat('LL') }}" />
                        <x-icon name="o-chat-bubble-left" label="{{ $comment->user->comments_count }} {{ __(' comments') }}" />
                    </x-slot:subtitle>
                </x-avatar>
                
                <!-- Actions disponibles pour l'utilisateur authentifié -->
                <div>
                    @auth
                        @if(Auth::user()->name == $comment->user->name)
                            <!-- Bouton pour modifier le commentaire -->
                            <x-button 
                                label="{{ __('Modify') }}" 
                                wire:click="toggleModifyForm(true)" 
                                class="btn-outline btn-warning btn-sm" />
                            <!-- Bouton pour supprimer le commentaire -->
                            <x-button 
                                label="{{ __('Delete') }}" 
                                wire:click="deleteComment()"
                                wire:confirm="{{__('Are you sure to delete this comment?')}}" 
                                class="ml-2 btn-outline btn-error btn-sm" />
                        @endif
                        <!-- Bouton pour répondre au commentaire -->
                        @if($comment->depth < config('app.commentsNestedLevel'))
                            <x-button 
                                label="{{ __('Answer') }} " 
                                wire:click="toggleAnswerForm(true)" 
                                class="ml-2 btn-outline btn-sm" />
                        @endif
                    @endauth  
                </div>
            </div>

            <!-- Affichage du formulaire de modification si activé -->
            @if($showModifyForm)
                <x-card title="{{ __('Update your comment') }}" shadow="hidden">
                    <x-form wire:submit="updateAnswer" class="mb-4">
                        <x-textarea
                            wire:model="message"
                            hint="{{ __('Max 1000 chars') }}"
                            rows="5"
                            inline />        
                        <x-slot:actions>
                            <!-- Bouton pour annuler la modification -->
                            <x-button label="{{ __('Cancel') }}" wire:click="toggleModifyForm(false)" class="btn-ghost" />
                            <!-- Bouton pour sauvegarder la modification -->
                            <x-button label="{{ __('Save') }}" class="btn-primary" type="submit" spinner="save" />
                        </x-slot:actions>
                    </x-form>
                </x-card>
            <!-- Affichage du corps du commentaire -->
            @else
                <div class="mb-4">@if($comment->user->role === "admin" || $comment->user->role ===  "redac") {!! $comment->body !!} @else {{ $comment->body }} @endif</div>
            @endif

            <!-- Affichage de l'alerte si activée -->
            @if($alert)
                <x-alert title="{!!__('This is your first comment')!!}" description="{{__('It will be validated by an administrator before it appears here')}}" icon="o-exclamation-triangle" class="alert-warning" />
            @endif

            <!-- Affichage du formulaire de réponse si activé -->
            @if($showAnswerForm)
                <x-card title="{{ __('Your answer') }}" shadow="hidden">
                    <x-form wire:submit="createAnswer" class="mb-4">
                        <x-textarea
                            label=""
                            wire:model="message"
                            placeholder="{{ __('Your answer') }} ..."
                            hint="{{ __('Max 1000 chars') }}"
                            rows="5"
                            inline />        
                        <x-slot:actions>
                            <!-- Bouton pour annuler la réponse -->
                            <x-button label="{{ __('Cancel') }}" wire:click="toggleAnswerForm(false)" class="btn-ghost" />
                            <!-- Bouton pour sauvegarder la réponse -->
                            <x-button label="{{ __('Save') }}" class="btn-primary" type="submit" spinner="save" />
                        </x-slot:actions>
                    </x-form>
                </x-card>
            @endif

        </div>
    @endif

    <!-- Rendu récursif des enfants du commentaire actuel -->
    @foreach ($childs as $child)
        <livewire:posts.comment :comment="$child" :$comments :depth="$depth + 1" :key="$child->id" >
    @endforeach

</div>

