<?php

use Livewire\Attributes\{Layout, Rule, Title};
use Livewire\Volt\Component;

// Définition du composant avec les attributs de titre et de mise en page
new
#[Title('Login')]
#[Layout('components.layouts.auth')]
class extends Component {
	// Déclaration des règles de validation des champs
	#[Rule('required|email')]
	public string $email = '';

	#[Rule('required')]
	public string $password = '';

	// Méthode pour gérer la connexion de l'utilisateur
	public function login()
	{
		// Validation des informations de connexion
		$credentials = $this->validate();

		// Tentative de connexion de l'utilisateur
		if (auth()->attempt($credentials)) {
			// Régénération de la session
			request()->session()->regenerate();

			if (auth()->user()->isAdmin()) {
				return redirect()->intended('/admin/dashboard');
			}

			// Redirection vers la page d'origine ou la page d'accueil
			return redirect()->intended('/');
		}

		// Ajout d'une erreur si les informations de connexion sont incorrectes
		$this->addError('email', __('The provided credentials do not match our records.'));
	}
}; ?>

<div>
    <!-- Formulaire de connexion -->
    <x-card class="flex items-center justify-center h-screen" title="{{ __('Login') }}" shadow separator progress-indicator>
        <!-- Formulaire de soumission -->
        <x-form wire:submit="login">
            <!-- Champ d'email -->
            <x-input label="{{ __('E-mail') }}" wire:model="email" icon="o-envelope" type="email" inline />
            <!-- Champ de mot de passe -->
            <x-input label="{{ __('Password') }}" wire:model="password" type="password" icon="o-key" type="password" inline />
            <!-- Option de souvenir de connexion -->
            <x-checkbox label="{{ __('Remember me') }}" wire:model="remember" />

            <!-- Actions du formulaire -->
            <x-slot:actions>
                <div class="flex flex-col space-y-2 flex-end sm:flex-row sm:space-y-0 sm:space-x-2">
                    <!-- Bouton pour soumettre le formulaire de connexion -->
                    <x-button label="{{ __('Login') }}" type="submit" icon="o-paper-airplane" class="ml-2 btn-primary sm:order-1" />
                    <div class="flex flex-col space-y-2 flex-end sm:flex-row sm:space-y-0 sm:space-x-2">
                        <!-- Bouton pour réinitialiser le mot de passe -->
                        <x-button label="{{ __('Forgot your password?') }}" class="btn-ghost" link="/forgot-password" />
                        <!-- Bouton pour créer un compte -->
                        <x-button label="{{ __('Create an account') }}" class="btn-ghost" link="/register" />
                    </div>
                </div>
            </x-slot:actions>
        </x-form>
    </x-card>
</div>



