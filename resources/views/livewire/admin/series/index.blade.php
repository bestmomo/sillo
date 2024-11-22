<?php

use App\Models\{Category, Serie};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Livewire\Attributes\{Layout, Rule};
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

new #[Layout('components.layouts.admin')] class extends Component {
	use Toast;
	use WithPagination;

	public int $category_id;
	public array $sortBy = ['column' => 'title', 'direction' => 'asc'];

	#[Rule('required|max:255|unique:categories,title')]
	public string $title = '';

	#[Rule('required|max:255|unique:posts,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')]
	public string $slug = '';

	// Définir l'ID de la catégorie par défaut lors du montage du composant.
	public function mount(): void {
		$category          = Category::first();
		$this->category_id = $category->id;
	}

	// Définir les en-têtes de table.
	public function headers(): array {
		$headers = [['key' => 'title', 'label' => __('Title')], ['key' => 'slug', 'label' => 'Slug'], ['key' => 'category_title', 'label' => __('Category')]];

		if (Auth::user()->isAdmin()) {
			$headers[] = ['key' => 'user_name', 'label' => __('Author')];
		}

		return $headers;
	}

	// Mettre à jour le slug lorsque le titre change.
	public function updating($property, $value) {
		if ('title' == $property) {
			$this->slug = Str::slug($value, '-');
		}
	}

	// Supprimer une série.
	public function delete(Serie $serie): void {
		$serie->delete();

		$this->warning(__('Serie deleted with success.'));
	}

	// Enregistrer une nouvelle série.
	public function save(): void {
		$data = $this->validate();

		Serie::create(
			$data + [
				'category_id' => $this->category_id,
				'user_id'     => Auth::id(),
			],
		);

		$this->success(__('Serie created with success.'));
	}

	// Fournir les données nécessaires à la vue.
	public function with(): array {
		return [
			'categories' => Category::all(),
			'series'     => Serie::withAggregate('category', 'title')
				->when(Auth::user()->isAdmin(), fn (Builder $q) => $q->withAggregate('user', 'name'))
				->when(!Auth::user()->isAdmin(), fn (Builder $q) => $q->where('user_id', Auth::id()))
				->orderBy(...array_values($this->sortBy))
				->paginate(10),
			'headers' => $this->headers(),
		];
	}
}; ?>

<div>
    <x-header title="{{ __('Series') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    @if ($series->count() > 0)
        <x-card>
            <x-table striped :headers="$headers" :rows="$series" :sort-by="$sortBy" link="/admin/series/{id}/edit"
                with-pagination>
                @scope('cell_category.title', $post)
                    {{ $serie->category->title }}
                @endscope
                @scope('actions', $serie)
                    <x-popover>
                        <x-slot:trigger>
                            <x-button icon="o-trash" wire:click="delete({{ $serie->id }})"
                                wire:confirm="{{ __('Are you sure to delete this serie?') }}" spinner
                                class="text-red-500 btn-ghost btn-sm" />
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Delete')
                        </x-slot:content>
                    </x-popover>
                @endscope
            </x-table>
        </x-card>
        <br>
    @endif
    <x-card class="" title="{{ __('Create a new serie') }}">

        <x-form wire:submit="save">
            <x-select label="{{ __('Category') }}" option-label="title" :options="$categories" wire:model="category_id" />
            <x-input label="{{ __('Title') }}" wire:model="title" wire:change="$refresh" />
            <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />
            <x-slot:actions>
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>

    </x-card>
</div>
