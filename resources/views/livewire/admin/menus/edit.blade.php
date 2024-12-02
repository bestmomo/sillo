<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\Menu;
use Illuminate\Validation\Rule;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Menu'), Layout('components.layouts.admin')] class extends Component
{
	use Toast;

	public Menu $menu;
	public string $label = '';
	public ?string $link = null;

	// Initialise le composant avec le menu donné.
	public function mount(Menu $menu): void
	{
		$this->menu = $menu;
		$this->fill($this->menu);
	}

	// Enregistrer les modifications apportées au menu.
	public function save(): void
	{
		$data = $this->validate([
			'label' => ['required', 'string', 'max:255', Rule::unique('menus')->ignore($this->menu->id)],
			'link'  => 'nullable|regex:/\/([a-z0-9_-]\/*)*[a-z0-9_-]*/',
		]);

		$this->menu->update($data);

		$this->success(__('Menu updated with success.'), redirectTo: '/admin/menus/index');
	}
}; ?>

<div>
    <x-header title="{{ __('Edit a menu') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card>
        <x-form wire:submit="save">
            <x-input label="{{ __('Title') }}" wire:model="label" />
            <x-input type="text" wire:model="link" label="{{ __('Link') }}" />
            <x-slot:actions>
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
