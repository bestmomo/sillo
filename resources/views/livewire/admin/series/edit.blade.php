<?php

use App\Models\{Category, Serie};
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Layout('components.layouts.admin')] class extends Component
{
	use Toast;

	public Serie $serie;
	public string $title = '';
	public string $slug  = '';
	public int $category_id;

	// Initialise le composant avec une série donnée.
	public function mount(Serie $serie): void
	{
		if (Auth()->user()->isRedac() && $serie->user_id !== Auth()->id())
		{
			abort(403);
		}

		$this->serie = $serie;

		$this->fill($this->serie);
	}

	// Met à jour le slug lorsque le titre change.
	public function updating($property, $value)
	{
		if ('title' == $property)
		{
			$this->slug = Str::slug($value);
		}
	}

	// Sauvegarde les modifications apportées à la série.
	public function save(): void
	{
		$data = $this->validate([
			'title'       => 'required|string|max:255',
			'category_id' => 'required|integer|exists:categories,id',
			'slug'        => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('series')->ignore($this->serie->id)],
		]);

		$this->serie->update($data);

		$this->success(__('Serie updated with success.'), redirectTo: '/admin/series/index');
	}

	// Fournit les données nécessaires à la vue.
	public function with(): array
	{
		return [
			'categories' => Category::all(),
		];
	}
}; ?>

<div>
    <x-header title="{{ __('Edit a serie') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card>
        <x-form wire:submit="save">
            <x-select label="{{ __('Category') }}" option-label="title" :options="$categories" wire:model="category_id"
                wire:change="$refresh" />
            <x-input label="{{ __('Title') }}" wire:model="title" wire:change="$refresh" />
            <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />
            <x-slot:actions>
                <x-button label="{{ __('Cancel') }}" icon="o-hand-thumb-down" class="btn-outline"
                    link="/admin/series/index" />
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>

    </x-card>
</div>
