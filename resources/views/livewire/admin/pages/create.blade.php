<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\Page;
use illuminate\Support\Str;
use Livewire\Attributes\{Layout, Rule, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Create Page'), Layout('components.layouts.admin')] class extends Component {
	use Toast;

	#[Rule('required|max:65000')]
	public string $body = '';

	#[Rule('required|max:255')]
	public string $title = '';

	#[Rule('required|max:255|unique:posts,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')]
	public string $slug = '';

	#[Rule('required|max:70')]
	public string $seo_title = '';

	#[Rule('required|max:160')]
	public string $meta_description = '';

	#[Rule('required|regex:/^[A-Za-z0-9-éèàù]{1,50}?(,[A-Za-z0-9-éèàù]{1,50})*$/')]
	public string $meta_keywords = '';

	// Méthode appelée avant la mise à jour de la propriété $title
	public function updatedTitle($value): void
	{
		$this->generateSlug($value);
		$this->seo_title = $value;
	}

	// Enregistre la nouvelle page
	public function save()
	{
		$data = $this->validate();

		Page::create($data);

		$this->success(__('Page added with success.'), redirectTo: '/admin/pages/index');
	}

	// Méthode pour générer le slug à partir du titre
	private function generateSlug(string $title): void
	{
		$this->slug = Str::of($title)->slug('-');
	}
}; ?>

<div>
    <x-card>
		<x-header title="{{__('Add a page')}}" shadow separator progress-indicator>
			<x-slot:actions>
				<x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline" link="{{ route('admin') }}" />
			</x-slot:actions>
		</x-header>
		<x-form wire:submit="save">
			<x-input type="text" wire:model="title" label="{{ __('Title') }}" placeholder="{{ __('Enter the title') }}"
				wire:change="$refresh" />
			<x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />
			<x-editor wire:model="body" label="{{ __('Content') }}" :config="config('tinymce.config')"
				folder="{{ 'photos/' . now()->format('Y/m') }}" />
			<x-card title="{{ __('SEO') }}" shadow separator>
				<x-input placeholder="{{ __('Title') }}" wire:model="seo_title" hint="{{ __('Max 70 chars') }}" />
				<br>
				<x-textarea label="{{ __('META Description') }}" wire:model="meta_description"
					hint="{{ __('Max 160 chars') }}" rows="2" inline />
				<br>
				<x-textarea label="{{ __('META Keywords') }}" wire:model="meta_keywords"
					hint="{{ __('Keywords separated by comma') }}" rows="1" inline />
			</x-card>
			<x-slot:actions>
				<x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
					class="btn-primary" />
			</x-slot:actions>
		</x-form>
    </x-card>
</div>
