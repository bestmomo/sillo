<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\{Category, Post, Serie};
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\{Builder, Collection};
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\{Auth, Storage};
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

// Définition du composant Livewire avec le layout 'components.layouts.admin'
new #[Title('Edit Post'), Layout('components.layouts.admin')] class extends Component
{
	// Utilisation des traits Toast et WithPagination
	use Toast;
	use WithPagination;

	// Déclaration des propriétés du composant
	public string $search = '';
	public array $sortBy  = ['column' => 'created_at', 'direction' => 'desc'];
	public Collection $categories;
	public Collection $series;
	public $category_id = 0;
	public $serie_id    = 0;
	public int $perPage = 10;

	// Initialisation du composant avec les données par défaut
	public function mount(): void
	{
		$this->categories = $this->getCategories();
		$this->series     = new Collection();
	}

	// Méthode pour obtenir les en-têtes des colonnes
	public function headers(): array
	{
		$headers = [['key' => 'title', 'label' => __('Title')]];

		if (Auth::user()->isAdmin())
		{
			$headers = array_merge($headers, [['key' => 'user_name', 'label' => __('Author')]]);
		}

		return array_merge($headers, [['key' => 'category_title', 'label' => __('Category')], ['key' => 'serie_title', 'label' => __('Serie')], ['key' => 'comments_count', 'label' => __('')], ['key' => 'active', 'label' => __('Published')], ['key' => 'pinned', 'label' => __('Pinned')], ['key' => 'date', 'label' => __('Date')]]);
	}

	// Méthode pour obtenir les posts avec pagination
	public function posts(): LengthAwarePaginator
	{
		return Post::query()
			->select('id', 'title', 'slug', 'category_id', 'active', 'pinned', 'user_id', 'created_at', 'updated_at')
			->when(Auth::user()->isAdmin(), fn (Builder $q) => $q->withAggregate('user', 'name'))
			->when(!Auth::user()->isAdmin(), fn (Builder $q) => $q->where('user_id', Auth::id()))
			->when($this->category_id, fn (Builder $q) => $q->where('category_id', $this->category_id))
			->when($this->serie_id, fn (Builder $q) => $q->whereHas('serie', fn (Builder $q) => $q->where('id', $this->serie_id)))
			->withAggregate('category', 'title')
			->withAggregate('serie', 'title')
			->withcount('comments')
			->when($this->search, fn (Builder $q) => $q->where('title', 'like', "%{$this->search}%"))
			->when('date' === $this->sortBy['column'], fn (Builder $q) => $q->orderBy('created_at', $this->sortBy['direction']), fn (Builder $q) => $q->orderBy($this->sortBy['column'], $this->sortBy['direction']))
			->latest()
			->paginate($this->perPage);
	}

	// Méthode pour obtenir les catégories
	public function getCategories(): Collection
	{
		if (Auth::user()->isAdmin())
		{
			return Category::all();
		}

		return Category::whereHas('posts', fn (Builder $q) => $q->where('user_id', Auth::id()))->get();
	}

	// Méthode pour obtenir les séries d'une catégorie donnée
	public function getSeries(int $category_id): Collection
	{
		return Serie::whereHas('posts', fn (Builder $q) => $q->where('category_id', $category_id)->when(Auth::user()->isRedac(), fn (Builder $q) => $q->where('user_id', Auth::id())))->get();
	}

	// Méthode appelée avant la mise à jour d'une propriété
	public function updating($property, $value): void
	{
		if ('serie_id' == $property)
		{
			$this->serie_id = $value;
		}

		if ('category_id' == $property)
		{
			$this->series   = '' != $value ? $this->getSeries($value) : new Collection();
			$this->serie_id = 0;
		}
	}

	// Méthode pour supprimer un article
	public function deletePost(int $postId): void
	{
		$post = Post::findOrFail($postId);
		// Storage::disk('public')->delete('photos/' . $post->image); // Décommenter pour supprimer l'image associée
		$post->delete();
		$this->success("{$post->title} " . __('deleted'));
	}

	// Méthode pour cloner un article
	public function clonePost(int $postId): void
	{
		$originalPost       = Post::findOrFail($postId);
		$clonedPost         = $originalPost->replicate();
		$postRepository     = new PostRepository();
		$clonedPost->slug   = $postRepository->generateUniqueSlug($originalPost->slug);
		$clonedPost->active = false;
		$clonedPost->save();

		redirect()->route('posts.edit', $clonedPost->slug);
	}

	// Méthode pour fournir des données additionnelles au composant
	public function with(): array
	{
		return [
			'posts'   => $this->posts(),
			'headers' => $this->headers(),
		];
	}
}; ?>

<div>
    <x-header title="{{ __('Posts') }}" separator progress-indicator>
        <x-slot:actions>
            <x-input placeholder="{{ __('Search...') }}" wire:model.live.debounce="search" clearable
                icon="o-magnifying-glass" />
            <x-button label="{{ __('Add a post') }}" class="btn-outline lg:hidden" link="{{ route('posts.create') }}" />
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    @if ($posts->count() > 0)

        <x-collapse>
            <x-slot:heading>
                @lang(__('Filters'))
            </x-slot:heading>
            <x-slot:content>
                <x-select label="{{ __('Category') }}" :options="$categories" placeholder="{{ __('Select a category') }}"
                    option-label="title" wire:model="category_id" wire:change="$refresh" />
                <br>
                @if ($series->count() > 0)
                    <x-select label="{{ __('Serie') }}" :options="$series" placeholder="{{ __('Select a serie') }}"
                        option-label="title" wire:model="serie_id" wire:change="$refresh" />
                @endif
            </x-slot:content>
        </x-collapse>

        <br>

        <x-card>
            <x-table striped :headers="$headers" :rows="$posts" :sort-by="$sortBy" per-page="perPage" link="/admin/posts/{slug}/edit" with-pagination>
                @scope('header_comments_count', $header)
                    {{ $header['label'] }}
                    <x-icon name="c-chat-bubble-left" />
                @endscope

                @scope('cell_user.name', $post)
                    {{ $post->user->name }}
                @endscope
                @scope('cell_category.title', $post)
                    {{ $post->category->title }}
                @endscope
                @scope('cell_comments_count', $post)
                    @if ($post->comments_count > 0)
                        <x-badge value="{{ $post->comments_count }}" class="badge-primary" />
                    @endif
                @endscope
                @scope('cell_active', $post)
                    @if ($post->active)
                        <x-icon name="o-check-circle" />
                    @endif
                @endscope
				@scope('cell_pinned', $post)
					@if ($post->pinned)
						<x-icon name="o-check-circle" />
					@endif
				@endscope
                @scope('cell_date', $post)
					<span class="whitespace-nowrap">
						{{ $post->created_at->isoFormat('LL') }}
						@if(!$post->created_at->isSameDay($post->updated_at))
							<p>@lang('Change') : {{ $post->updated_at->isoFormat('LL') }}</p>
						@endif
					</span>
                @endscope

                @scope('actions', $post)
                    <div class="flex">
                        <x-popover>
                            <x-slot:trigger>
                                <x-button icon="o-finger-print" wire:click="clonePost({{ $post->id }})" spinner
                                    class="btn-ghost btn-sm" />
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Clone')
                            </x-slot:content>
                        </x-popover>
                        <x-popover>
                            <x-slot:trigger>
                                <x-button icon="o-trash" wire:click="deletePost({{ $post->id }})"
                                    wire:confirm="{{ __('Are you sure to delete this post?') }}" spinner
                                    class="text-red-500 btn-ghost btn-sm" />
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Delete')
                            </x-slot:content>
                        </x-popover>
                    </div>
                @endscope
            </x-table>
        </x-card>

    @endif
</div>
