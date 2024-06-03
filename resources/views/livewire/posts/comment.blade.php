<?php

use Livewire\Volt\Component;
use App\Models\Comment;
use Livewire\Attributes\Rule;
use Illuminate\Support\Collection;
use App\Notifications\CommentCreated;
use Illuminate\Contracts\Database\Eloquent\Builder;

new class extends Component {

    public Comment|null $comment;
    public Collection $comments;
    public array $childs = [];
    public bool $showAnswerForm = false;
    public bool $showModifyForm = false;
    public int $depth;
    public bool $alert = false;

    #[Rule('required|max:1000')]
    public string $message = '';
   
    // Initialise le composant avec les données du commentaire.
    public function mount($comment, $comments, $depth): void
    {
        $this->comment = $comment;
        $this->comments = $comments;
        $this->depth = $depth;
        $this->message = $comment->body;

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

        $item->depth = $this->depth + 1;        

        if(Auth::user()->valid) {
            array_push($this->childs, $item);
        } else {
            $this->alert = true;
        }

        $item->load([
            'post' => function (Builder $query) {$query->with('user')->select('id', 'title', 'user_id');},
            'user',
        ]);

        $item->post->user->notify(new CommentCreated($item));

        $this->toggleAnswerForm(false);
    }

    // Met à jour le commentaire actuel.
    public function updateAnswer(): void
    {
        $data = $this->validate();

        $this->comment->body = $data['message'];
        $this->comment->save();

        $this->toggleModifyForm(false);
    }

    // Supprime le commentaire actuel.
    public function deleteComment(): void
    {
        $this->comment->delete();
        $this->childs = [];
        $this->comment = null;
    }

}; ?>

<div>
    @if($this->comment)

        <div class="flex flex-col mt-4" style="margin-left:{{ $depth * 3 }}rem">

            <div class="flex justify-between mb-4">

                <x-avatar :image="Gravatar::get($comment->user->email)" class="!w-24">
        
                    <x-slot:title class="text-xl pl-2">
                        {{ $comment->user->name }}
                    </x-slot:title>
                
                    <x-slot:subtitle class="text-gray-500 flex flex-col gap-1 mt-2 pl-2">
                        <x-icon name="o-calendar" label="{{ $comment->created_at->isoFormat('LL') }}" />
                        <x-icon name="o-chat-bubble-left" label="{{ $comment->user->comments_count }} {{ __(' comments') }}" />
                    </x-slot:subtitle>
                
                </x-avatar>

                <div>
                    @if(Auth::check())
                        @if(Auth::user()->name == $comment->user->name)
                            <x-button 
                                label="{{ __('Modify') }}" 
                                wire:click="toggleModifyForm(true)" 
                                class="btn-outline btn-warning btn-sm" />
                            <x-button 
                                label="{{ __('Supprimer') }}" 
                                wire:click="deleteComment()"
                                wire:confirm="{{__('Are you sure to delete this comment?')}}" 
                                class="btn-outline btn-error btn-sm ml-2" />
                        @endif
                        @if($comment->depth < config('app.commentsNestedLevel'))
                            <x-button 
                                label="{{ __('Answer') }} " 
                                wire:click="toggleAnswerForm(true)" 
                                class="btn-outline btn-sm ml-2" />
                        @endif
                    @endif  
                </div>

            </div>

            @if($showModifyForm)
                <x-card title="{{ __('Update your comment') }}" shadow="hidden">
                    <x-form wire:submit="updateAnswer" class="mb-4">
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
                <div class="mb-4">@if($comment->user->role === "admin" || $comment->user->role ===  "redac") {!! $comment->body !!} @else {{ $comment->body }} @endif</div>
            @endif

            @if($alert)
                <x-alert title="{!!__('This is your first comment')!!}" description="{{__('It will be validate by an administrator before it appears here')}}" icon="o-exclamation-triangle" class="alert-warning" />
            @endif

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
                            <x-button label="{{ __('Cancel') }}" wire:click="toggleAnswerForm(false)" class="btn-ghost" />
                            <x-button label="{{ __('Save') }}" class="btn-primary" type="submit" spinner="save" />
                        </x-slot:actions>
                    </x-form>
                </x-card>
            @endif

        </div>

    @endif

    @foreach ($childs as $child)
        <livewire:posts.comment :comment="$child" :$comments :depth="$depth + 1" :key="$child->id" >
    @endforeach

</div>
