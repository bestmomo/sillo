<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\{ Page, Post, Comment, User, Contact };
use Illuminate\Support\Str;
use Mary\Traits\Toast;
use Illuminate\Database\Eloquent\Builder;

new 
#[Layout('components.layouts.admin')]
class extends Component {

    use Toast;

    public array $headersPosts;
    public bool $openGlance = true;

    public function mount(): void
    {
        $this->headersPosts =  [
            ['key' => 'date', 'label' => __('Date')],
            ['key' => 'title', 'label' => __('Title')],      
        ];
    }

    public function deleteComment(Comment $comment): void
    {
        $comment->delete();
        
        $this->warning("Comment deleted", __('Good bye!'), position: 'toast-bottom');
    }

    public function with(): array
    {
        return [
            'pages' => Page::select('id', 'title', 'slug')->get(),
            'posts' => Post::select('id', 'title', 'slug', 'user_id', 'created_at', 'updated_at')
                                    ->when(Auth::user()->isRedac(), 
                                        fn( Builder $q) => $q->where('user_id', Auth::id()))
                                    ->get(),
            'commentsNumber' => Comment::when(Auth::user()->isRedac(), 
                                            fn( Builder $q) => $q->whereRelation('post', 'user_id', Auth::id()))
                                        ->count(),
            'comments' => Comment::with('user', 'post:id,title,slug')
                                    ->when(Auth::user()->isRedac(), 
                                        fn( Builder $q) => $q->whereRelation('post', 'user_id', Auth::id()))->take(5)
                                    ->get(),
            'users' => User::count(),
            'contacts' => Contact::whereHandled(false)->get(),
        ];
    }

}; ?>

<div>
    <x-collapse wire:model="openGlance" class="shadow-md" >
        <x-slot:heading>
            @lang('In a glance')
        </x-slot:heading>
        <x-slot:content class="flex gap-4">
            <x-stat 
                title="{{ __('Posts') }}"
                value="{{ $posts->count() }}"
                icon="s-document-text"
                class="shadow-md" />
            @if(Auth::user()->isAdmin())
                <x-stat
                    title="{{ __('Pages') }}"
                    value="{{ $pages->count() }}"
                    icon="s-document"
                    class="shadow-md" />
                <x-stat
                    title="{{ __('Users') }}"
                    value="{{ $users }}"
                    icon="s-user"
                    class="shadow-md" />
            @endif
            <x-stat
                title="{{ __('Comments') }}"
                value="{{ $commentsNumber }}"
                icon="c-chat-bubble-left"
                class="shadow-md" />
        </x-slot:content>
    </x-collapse>

    <br>

    @foreach($comments as $comment)
        @if(!$comment->user->valid)
            <x-alert title="{{ __('Comment to valid from ') . $comment->user->name }}" description="{{ $comment->body }}" icon="c-chat-bubble-left" class="alert-warning shadow-md" >
                <x-slot:actions>
                    <x-button link="{{ route('comments.index') }}" label="{!! __('Show the comments') !!}" />
                </x-slot:actions>
            </x-alert>
            <br>
        @endif
    @endforeach

    @if(Auth::user()->isAdmin())
        @foreach($contacts as $contact)
            <x-alert title="{{ __('Contact to handle from ') . $contact->name }}" description="{{ $contact->message }}" icon="s-pencil-square" class="alert-info shadow-md" >
                <x-slot:actions>
                    <x-button link="{{ route('contacts.index') }}" label="{!! __('Show the contacts') !!}" />
                </x-slot:actions>
            </x-alert>
            <br>
        @endforeach
    @endif
    
    <x-collapse class="shadow-md" >
        <x-slot:heading>
            @lang('Recent posts')
        </x-slot:heading>
        <x-slot:content>
            <x-table :headers="$headersPosts" :rows="$posts->take(5)" striped>
                @scope('cell_date', $post)
                    @lang('Created') {{ $post->created_at->diffForHumans() }}
                    @if($post->updated_at != $post->created_at)
                        <br>
                        @lang('Updated') {{ $post->updated_at->diffForHumans() }}
                    @endif
                @endscope
                @scope('actions', $post)
                    <x-button icon="s-document-text" link="{{ route('posts.show', $post->slug) }}" tooltip-left="{!! __('Show post') !!}" spinner class="btn-ghost btn-sm" />
                @endscope
            </x-table>
        </x-slot:content>
    </x-collapse>

    <br>

    <x-collapse class="shadow-md" >
        <x-slot:heading>
            @lang('Recent Comments')
        </x-slot:heading>
        <x-slot:content>
            @foreach($comments as $comment)
                <x-list-item :item="$comment" no-separator no-hover >
                    <x-slot:avatar>
                        <x-avatar :image="Gravatar::get($comment->user->email)" >
                            <x-slot:title>
                                {{ $comment->user->name }}
                            </x-slot:title>
                        </x-avatar>
                    </x-slot:avatar>
                    <x-slot:value>
                        @lang ('in post:') {{ $comment->post->title }}
                    </x-slot:value>                        
                    <x-slot:actions>
                        <x-button icon="c-eye" link="{{ '/admin/comments/' . $comment->id . '/edit' }}" tooltip-left="{!! __('Edit or answer') !!}" spinner class="btn-ghost btn-sm" />
                        <x-button icon="s-document-text" link="{{ route('posts.show', $comment->post->slug) }}" tooltip-left="{!! __('Show post') !!}" spinner class="btn-ghost btn-sm" />
                        <x-button icon="o-trash" wire:click="deleteComment({{ $comment->id }})" wire:confirm="{{__('Are you sure to delete this comment?')}}" tooltip-left="{{ __('Delete') }}" spinner class="text-red-500 btn-ghost btn-sm" />
                    </x-slot:actions>
                </x-list-item>
                <p class="ml-16">{{ Str::words($comment->body, 20, ' ...') }}</p>
                <br>
            @endforeach
        </x-slot:content>
    </x-collapse>
</div>