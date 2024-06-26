<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Mary\Traits\Toast;
use App\Models\Comment;
use App\Models\Contact;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

new #[Layout('components.layouts.admin')] class extends Component {
	use Toast;

	public array $headersPosts;
	public bool $openGlance = true;

	public function mount(): void
	{
		$this->headersPosts = [['key' => 'date', 'label' => __('Date')], ['key' => 'title', 'label' => __('Title')]];
	}

	public function deleteComment(Comment $comment): void
	{
		$comment->delete();

		$this->warning('Comment deleted', __('Good bye!'), position: 'toast-bottom');
	}

	public function with(): array
	{
		return [
			'pages'          => Page::select('id', 'title', 'slug')->get(),
			'posts'          => Post::select('id', 'title', 'slug', 'user_id', 'created_at', 'updated_at')->when(Auth::user()->isRedac(), fn (Builder $q) => $q->where('user_id', Auth::id()))->get(),
			'commentsNumber' => Comment::when(Auth::user()->isRedac(), fn (Builder $q) => $q->whereRelation('post', 'user_id', Auth::id()))->count(),
			'comments'       => Comment::with('user', 'post:id,title,slug')->when(Auth::user()->isRedac(), fn (Builder $q) => $q->whereRelation('post', 'user_id', Auth::id()))->take(5)->get(),
			'users'          => User::count(),
			'contacts'       => Contact::whereHandled(false)->get(),
		];
	}
};
