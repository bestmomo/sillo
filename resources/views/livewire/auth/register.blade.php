<?php

use App\Models\User;
use App\Notifications\UserRegistered;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\{Layout, Rule, Title};
use Livewire\Volt\Component;

// Définition du composant avec les attributs de titre et de mise en page
new #[Title('Register')] #[Layout('components.layouts.auth')] class extends Component
{
	// Définition des règles de validation pour les champs du formulaire
	#[Rule('required|string|max:255|unique:users')]
	public string $name = '';

	#[Rule('required|email|unique:users')]
	public string $email = '';

	#[Rule('required|confirmed|min:8')]
	public string $password = '';

	#[Rule('required')]
	public string $password_confirmation = '';

	#[Rule('sometimes|nullable')]
	public ?string $gender = null;

	// Méthode pour enregistrer un nouvel utilisateur
	public function register()
	{
		// Vérification du champ honeypot
		if ($this->gender)
		{
			// Si le champ honeypot est rempli, c'est probablement un bot
			abort(403);
		}

		// Validation des données
		$data = $this->validate();

		// Hashage du mot de passe
		$data['password'] = Hash::make($data['password']);

		// Création de l'utilisateur
		$user = User::create($data);

		// Authentification de l'utilisateur
		auth()->login($user);

		// Régénération de la session
		request()->session()->regenerate();

		// Notification aux administrateurs
		$admins = User::where('role', 'admin')->get();

		foreach ($admins as $admin)
		{
			$admin->notify(new UserRegistered($user));
		}

		// Redirection vers la page d'accueil
		return redirect('/');
	}
}; ?>

<div>
    <!-- Formulaire d'inscription -->
    <x-card class="flex items-center justify-center h-screen" title="{{ __('Register') }}" shadow separator
        progress-indicator>

        <x-form wire:submit="register">
			<x-input label="{{ __('Your name') }}" wire:model="name" icon="o-user" required />
            <x-input label="{{ __('Your e-mail') }}" wire:model="email" icon="o-envelope" required />
            <x-input label="{{ __('Your password') }}" wire:model="password" icon="o-key" required />
            <x-input label="{{ __('Confirm Password') }}" wire:model="password_confirmation" icon="o-key" required />
                
            <div style="display: none;">
                <x-input wire:model="gender" type="text" inline />
            </div>
			<p class="text-xs text-gray-500"><span class="text-red-600">*</span> @lang('Required information')</p>
            <x-slot:actions>
                <!-- Bouton pour rediriger vers la page de connexion -->
                <x-button label="{{ __('Already registered?') }}" class="btn-ghost" link="/login" />
                <!-- Bouton pour soumettre le formulaire -->
                <x-button label="{{ __('Register') }}" type="submit" icon="o-paper-airplane" class="btn-primary"
                    spinner="login" />
            </x-slot:actions>
        </x-form>

    </x-card>
</div>
