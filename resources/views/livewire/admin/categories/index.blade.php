<?php

// Importations des classes nécessaires
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\{Layout, Rule};
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

// Définition du composant Livewire avec le layout 'components.layouts.admin'
new #[Layout('components.layouts.admin')] class extends Component
{
	// Utilisation des traits Toast et WithPagination
	use Toast;
	use WithPagination;

	// Déclaration des propriétés du composant
	public array $sortBy = ['column' => 'title', 'direction' => 'asc'];

	#[Rule('required|max:255|unique:categories,title')]
	public string $title = '';

	#[Rule('required|max:255|unique:posts,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')]
	public string $slug = '';

	// Méthode pour obtenir les en-têtes des colonnes
	public function headers(): array
	{
		return [['key' => 'title', 'label' => __('Title')], ['key' => 'slug', 'label' => 'Slug']];
	}

	// Méthode appelée avant la mise à jour de la propriété $title
	public function updatedTitle($value): void
	{
		$this->generateSlug($value);
	}

	// Méthode pour supprimer une catégorie
	public function delete(Category $category): void
	{
		$category->delete();

		$this->success(__('Category deleted with success.'));
	}

	// Méthode pour sauvegarder une catégorie
	public function save(): void
	{
		$data = $this->validate();

		Category::create($data);

		$this->success(__('Category created with success.'));
	}

	// Méthode pour fournir des données additionnelles au composant
	public function with(): array
	{
		return [
			'categories' => Category::orderBy(...array_values($this->sortBy))->paginate(10),
			'headers'    => $this->headers(),
		];
	}

	// Méthode pour générer le slug à partir du titre
	private function generateSlug(string $title): void
	{
		$this->slug = Str::of($title)->slug('-');
	}
}; ?>
<div>
    <x-header title="{{ __('Categories') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card>
        <x-table striped :headers="$headers" :rows="$categories" :sort-by="$sortBy" link="/admin/categories/{id}/edit"
            with-pagination>
            @scope('actions', $category)
                <x-popover>
                    <x-slot:trigger>
                        <x-button icon="o-trash" wire:click="delete({{ $category->id }})"
                            wire:confirm="{{ __('Are you sure to delete this category?') }}" spinner
                            class="text-red-500 btn-ghost btn-sm" />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                        @lang('Delete')
                    </x-slot:content>
                </x-popover>
            @endscope
        </x-table>
    </x-card>

    <x-card title="{{ __('Create a new category') }}">
        @include('livewire.admin.categories.category-form')
    </x-card>
</div>
