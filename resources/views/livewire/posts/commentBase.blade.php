<?php

use Livewire\Volt\Component;
use App\Models\Comment;
use Livewire\Attributes\Rule;
use App\Notifications\CommentCreated;
use Illuminate\Contracts\Database\Eloquent\Builder;

new class extends Component {

    public int $postId;
    public Comment|null $comment = null;
    public bool $showCreateForm = true;
    public bool $showModifyForm = false;
    public bool $alert = false;

    #[Rule('required|max:1000')]
    public string $message = '';
    
    public function mount($postId): void
    {
        $this->postId = $postId;
    }

    public function createComment(): void
    {
        $data = $this->validate();

        if(!Auth::user()->valid) {
            $this->alert = true;
        }

        $this->comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $this->postId,
            'body' => $data['message'],
        ]);

        $this->comment->load([
            'post' => function (Builder $query) {$query->with('user')->select('id', 'title', 'user_id');},
            'user',
        ]);

        $this->comment->post->user->notify(new CommentCreated($this->comment));

        $this->message = $data['message'];
    }

    public function updateComment(): void
    {
        $data = $this->validate();

        $this->comment->body = $data['message'];
        $this->comment->save();

        $this->toggleModifyForm(false);
    }

    public function toggleModifyForm(bool $state): void
    {
        $this->showModifyForm = $state;
    }

    public function deleteComment(): void
    {
        $this->comment->delete();
        $this->comment = null;
        $this->message = '';
    }

}; ?>

<div>
    <div class="flex flex-col mt-4">

        @if($this->comment)

            @if($alert)
                <x-alert title="{!!__('This is your first comment')!!}" description="{!!__('It will be validate by an administrator before it appears here')!!}" icon="o-exclamation-triangle" class="alert-warning" />
            @else

                <div class="flex justify-between mb-4">            
                    <x-avatar :image="Gravatar::get(Auth::user()->email)" class="!w-24">
            
                        <x-slot:title class="text-xl pl-2">
                            {{ Auth::user()->name }}
                        </x-slot:title>
                    
                        <x-slot:subtitle class="text-gray-500 flex flex-col gap-1 mt-2 pl-2">
                            <x-icon name="o-calendar" label="{{ $comment->created_at->isoFormat('LL') }}" />
                            <x-icon name="o-chat-bubble-left" label="{{ $comment->user->comments_count }} {{ __(' comments') }}" />
                        </x-slot:subtitle>
                    
                    </x-avatar>                

                    <div>
                        <x-button 
                            label="{{ __('Modify') }}" 
                            wire:click="toggleModifyForm(true)" 
                            class="btn-outline btn-sm" />
                        <x-button 
                            label="{{ __('Supprimer') }}" 
                            wire:click="deleteComment()"
                            wire:confirm="{{__('Are you sure to delete this comment?')}}" 
                            class="btn-outline btn-error btn-sm" />
                    </div>
                </div>

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
                    <div class="mb-4">{{ $comment->body }}</div>
                @endif

            @endif

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

</div>
