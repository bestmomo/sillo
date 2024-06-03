<?php

use App\Models\Comment;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\WithPagination; 
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;

new 
#[Layout('components.layouts.admin')]
class extends Component {

    use Toast, WithPagination;

    public string $search = '';
    public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];
    public $role = 'all';

    public function deleteComment(Comment $comment): void
    {
        $comment->delete();
        
        $this->success(__('Comment deleted'));
    }

    public function validComment(Comment $comment): void
    {
        $comment->user->valid = true;
        $comment->user->save();

        $this->success(__('Comment validated'));
    }

    public function headers(): array
    {
        return [
            ['key' => 'user_name', 'label' => __('Author')],
            ['key' => 'body', 'label' => __('Comment'), 'sortable' => false],
            ['key' => 'post_title', 'label' => __('Post')],
            ['key' => 'created_at', 'label' => __('Sent on')],
        ];
    }

    public function comments(): LengthAwarePaginator
    {
        return Comment::query()
        ->when($this->search, fn(Builder $q) => $q->where('body', 'like', "%$this->search%"))
        ->orderBy(...array_values($this->sortBy))
        ->when(Auth::user()->isRedac(), fn(Builder $q) => $q->whereRelation('post', 'user_id', Auth::id()))
        ->with(['user', 'post' => function ($query) {
                    $query->select('id', 'title', 'slug');
                }])
        ->withAggregate('user', 'name')
        ->paginate(10);
    }

    public function with(): array
    {
        return [
            'headers' => $this->headers(),
            'comments' => $this->comments(),
        ];
    }
}; ?>

<div>
    <x-header title="{{__('Comments')}}" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="{{__('Search...')}}"  wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
    </x-header>

    <x-card>
        <x-table striped :headers="$headers" :rows="$comments" link="/admin/comments/{id}/edit" :sort-by="$sortBy" with-pagination>
            @scope('cell_created_at', $comment)      
                {{ $comment->created_at->isoFormat('LL') }} {{ __('at')}} {{ $comment->created_at->isoFormat('HH:mm') }}
            @endscope
            @scope('cell_body', $comment)
                {!! $comment->body !!}
            @endscope
            @scope('cell_user_name', $comment)
                <x-avatar :image="Gravatar::get($comment->user->email)" >
                    <x-slot:title>
                        {{ $comment->user->name }}
                    </x-slot:title>
                </x-avatar>
            @endscope
            @scope('cell_post_title', $comment)
                {{ $comment->post->title }}
            @endscope
            @scope('actions', $comment)
                <div class="flex">
                    @if(!$comment->user->valid)
                        <x-button icon="c-eye" wire:click="validComment({{ $comment->id }})" wire:confirm="{{__('Are you sure to valid this comment?')}}" tooltip-left="{!! __('Valider') !!}" spinner class="btn-ghost btn-sm text-yellow-500" />
                    @endif
                    <x-button icon="s-document-text" link="{{ route('posts.show', $comment->post->slug) }}" tooltip-left="{!! __('Show post') !!}" spinner class="btn-ghost btn-sm" />
                    <x-button icon="o-trash" wire:click="deleteComment({{ $comment->id }})" wire:confirm="{{__('Are you sure to delete this comment?')}}" tooltip-left="{{ __('Delete') }}" spinner class="btn-ghost btn-sm text-red-500" />
                </div>
            @endscope
        </x-table>
    </x-card>
</div>
