<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\Footer;
use Illuminate\Validation\Rule;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Edit Footer'), Layout('components.layouts.admin')] class extends Component {
	use Toast;

	public Footer $footer;
	public string $label = '';
	public string $link  = '';

	// Initialise le composant avec le footer donné.
	public function mount(Footer $footer): void
	{
		$this->footer = $footer;
		$this->fill($this->footer);
	}

	// Enregistrer les modifications apportées au footer.
	public function save(): void
	{
		$data = $this->validate([
			'label' => ['required', 'string', 'max:255', Rule::unique('footers')->ignore($this->footer->id)],
			'link'  => 'regex:/\/([a-z0-9_-]\/*)*[a-z0-9_-]*/',
		]);

		$this->footer->update($data);

		$this->success(__('Footer updated with success.'), redirectTo: '/admin/footers/index');
	}
}; ?>

<div>
    <x-header title="{{ __('Edit a footer') }}" separator progress-indicator>
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
