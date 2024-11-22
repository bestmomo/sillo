<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\{Comment, Contact, Page, Post, User};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Dashboard')] #[Layout('components.layouts.admin')] class extends Component {
	use Toast;

	public array $headersPosts;
	public bool $openGlance = true;

	public function mount(): void {
		$this->headersPosts = [['key' => 'date', 'label' => __('Date')], ['key' => 'title', 'label' => __('Title')]];
	}

	public function deleteComment(Comment $comment): void {
		$comment->delete();

		$this->warning('Comment deleted', __('Good bye!'), position: 'toast-bottom');
	}

	public function with(): array {
		$user    = Auth::user();
		$isRedac = $user->isRedac();
		$userId  = $user->id;

		return [
			'pages'          => Page::select('id', 'title', 'slug')->get(),
			'posts'          => Post::select('id', 'title', 'slug', 'user_id', 'created_at', 'updated_at')->when($isRedac, fn (Builder $q) => $q->where('user_id', $userId))->latest()->get(),
			'commentsNumber' => Comment::when($isRedac, fn (Builder $q) => $q->whereRelation('post', 'user_id', $userId))->count(),
			'comments'       => Comment::with('user', 'post:id,title,slug')->when($isRedac, fn (Builder $q) => $q->whereRelation('post', 'user_id', $userId))->latest()->take(5)->get(),
			'users'          => User::count(),
			'contacts'       => Contact::whereHandled(false)->get(),
		];
	}
}; ?>

<div>
    <x-collapse wire:model="openGlance" class="shadow-md">
        <x-slot:heading>
            @lang('In a glance')
        </x-slot:heading>
        <x-slot:content class="flex flex-wrap gap-4">

            <a href="{{ route('posts.index') }}" class="flex-grow">
                <x-stat title="{{ __('Posts') }}" description="" value="{{ $posts->count() }}" icon="s-document-text"
                    class="shadow-hover" />
            </a>

            @if (Auth::user()->isAdmin())
                <a href="{{ route('pages.index') }}" class="flex-grow">
                    <x-stat title="{{ __('Pages') }}" value="{{ $pages->count() }}" icon="s-document"
                        class="shadow-hover" />
                </a>
                <a href="{{ route('users.index') }}" class="flex-grow">
                    <x-stat title="{{ __('Users') }}" value="{{ $users }}" icon="s-user"
                        class="shadow-hover" />
                </a>
            @endif
            <a href="{{ route('comments.index') }}" class="flex-grow">
                <x-stat title="{{ __('Comments') }}" value="{{ $commentsNumber }}" icon="c-chat-bubble-left"
                    class="shadow-hover" />
            </a>
        </x-slot:content>
    </x-collapse>

    <br>

    @foreach ($comments as $comment)
        @if (!$comment->user->valid)
            <x-alert title="{!! __('Comment to valid from ') . $comment->user->name !!}" description="{!! $comment->body !!}" icon="c-chat-bubble-left"
                class="shadow-md alert-warning">
                <x-slot:actions>
                    <x-button link="{{ route('comments.index') }}" label="{!! __('Show the comments') !!}" />
                </x-slot:actions>
            </x-alert>
            <br>
        @endif
    @endforeach

    @if (Auth::user()->isAdmin())
        @foreach ($contacts as $contact)
            <x-alert title="{!! __('Contact to handle from ') . html_entity_decode($contact->name) !!}" description="{!! html_entity_decode($contact->message) !!}" icon="s-pencil-square"
                class="shadow-md alert-info">
                <x-slot:actions>
                    <x-button link="{{ route('contacts.index') }}" label="{!! __('Show the contacts') !!}" />
                </x-slot:actions>
            </x-alert>
            <br>
        @endforeach
    @endif

    <x-collapse class="shadow-md">
        <x-slot:heading>
            @lang('Recent posts')
        </x-slot:heading>
        <x-slot:content>
            <x-table :headers="$headersPosts" :rows="$posts->take(5)" striped>
                @scope('cell_date', $post)
                    @lang('Created') {{ $post->created_at->diffForHumans() }}
                    @if ($post->updated_at != $post->created_at)
                        <br>
                        @lang('Updated') {{ $post->updated_at->diffForHumans() }}
                    @endif
                @endscope
                @scope('actions', $post)
                    <x-popover>
                        <x-slot:trigger>
                            <x-button icon="s-document-text" link="{{ route('posts.show', $post->slug) }}" spinner class="btn-ghost btn-sm" />                            
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Show post')
                        </x-slot:content>
                    </x-popover>
                @endscope
            </x-table>
        </x-slot:content>
    </x-collapse>

    <br>

    <x-collapse class="shadow-md">
        <x-slot:heading>
            @lang('Recent Comments')
        </x-slot:heading>
        <x-slot:content>
            @foreach ($comments as $comment)
                <x-list-item :item="$comment" no-separator no-hover>
                    <x-slot:avatar>
                        <x-avatar :image="Gravatar::get($comment->user->email)">
                            <x-slot:title>
                                {{ $comment->user->name }}
                            </x-slot:title>
                        </x-avatar>
                    </x-slot:avatar>
                    <x-slot:value>
                        @lang ('in post:') {{ $comment->post->title }}
                    </x-slot:value>
                    <x-slot:actions>
                        <x-popover>
                            <x-slot:trigger>
                                <x-button icon="c-eye" link="{{ route('comments.edit', $comment->id) }}" spinner class="btn-ghost btn-sm" />                         
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Edit or answer')
                            </x-slot:content>
                        </x-popover>
                        <x-popover>
                            <x-slot:trigger>
                                <x-button icon="s-document-text" link="{{ route('posts.show', $comment->post->slug) }}" spinner class="btn-ghost btn-sm" />                       
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Show post')
                            </x-slot:content>
                        </x-popover>
                        <x-popover>
                            <x-slot:trigger>
                                <x-button icon="o-trash" wire:click="deleteComment({{ $comment->id }})"
                                    wire:confirm="{{ __('Are you sure to delete this comment?') }}" 
                                    spinner class="text-red-500 btn-ghost btn-sm" />                   
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Delete')
                            </x-slot:content>
                        </x-popover>
                    </x-slot:actions>
                </x-list-item>
                <p class="ml-16">{!! Str::words(nl2br($comment->body), 20, ' ...') !!}</p>
                <br>
            @endforeach
        </x-slot:content>
    </x-collapse>
</div>
