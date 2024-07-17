<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Edit User'), Layout('components.layouts.admin')] class extends Component {
	use Toast;

	public User $user;
	public string $name      = '';
	public string $firstname = '';
	public string $email     = '';
	public string $role      = '';
	public bool $valid       = false;
	public bool $isStudent;

	// Initialiser le composant avec un utilisateur donné.
	public function mount(User $user): void
	{
		$this->user = $user;

		$this->fill($this->user);
	}

	// Sauvegarder les modifications apportées à l'utilisateur.
	public function save()
	{
		$data = $this->validate([
			'name'      => ['required', 'string', 'max:255'],
			'firstname' => ['required', 'string', 'max:255'],
			'email'     => ['required', 'email', Rule::unique('users')->ignore($this->user->id)],
			'role'      => ['required', Rule::in(['admin', 'redac', 'user'])],
			'isStudent' => ['required', 'boolean'],
			'valid'     => ['required', 'boolean'],
		]);

		$this->user->update($data);

		$this->success(__('User edited with success.'), redirectTo: '/admin/users/index');
	}

	// Fournir les données nécessaires à la vue
	public function with(): array
	{
		return [
			'roles' => [
				['name' => __('Administrator'), 'id' => 'admin'],
				['name' => __('Redactor'), 'id' => 'redac'],
				['name' => __('User'), 'id' => 'user'],
			],
		];
	}
}; ?>

<x-card>
    <a href="/admin/dashboard" title="{{ __('Back to Dashboard') }}">
        <x-header title="{{ __('Edit an account') }}" shadow separator progress-indicator />
    </a>
    <x-form wire:submit="save">
        {{-- // 2fix input group for name and firstname --}}
        <x-input label="{{ __('Name') }}" wire:model="name" icon="o-user" inline />
        <x-input label="{{ __('Firstname') }}" wire:model="firstname" icon="o-user" inline />
        <x-input label="{{ __('E-mail') }}" wire:model="email" icon="o-envelope" inline />
        <br>
        <x-radio label="{{ __('User role') }}" inline label="{{ __('Select a role') }}" :options="$roles"
            wire:model="role" />
        <br>
				<div class="flex justify-around">
					<x-toggle label="{{ __('Valid user') }}" inline wire:model="valid" />
					<x-toggle label="{{ __('Is student') }}" inline wire:model="isStudent" />
					<x-slot:actions>
				</div>
				<div>
					<x-button label="{{ __('Cancel') }}" icon="o-hand-thumb-down" class="btn-outline"
                link="/admin/users/index" />
            <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
						class="btn-primary" />
					</x-slot:actions>
				</div>
    </x-form>
</x-card>
