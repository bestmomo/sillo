<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\{Hash, Password, Session};
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\{Layout, Locked};
use Livewire\Volt\Component;

// Définition du composant avec l'attribut de mise en page
new
#[Layout('components.layouts.auth')]
class extends Component
{
	#[Locked]
	public string $token = '';

	public string $email                 = '';
	public string $password              = '';
	public string $password_confirmation = '';

	// Méthode pour initialiser le composant avec le jeton et l'email
	public function mount(string $token): void
	{
		$this->token = $token;

		$this->email = request()->input('email');
	}

	// Méthode pour réinitialiser le mot de passe
	public function resetPassword(): void
	{
		// Validation des données du formulaire
		$this->validate([
			'token'    => ['required'],
			'email'    => ['required', 'string', 'email'],
			'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
		]);

		// Réinitialisation du mot de passe
		$status = Password::reset(
			$this->only('email', 'password', 'password_confirmation', 'token'),
			function ($user)
			{
				$user->forceFill([
					'password'       => Hash::make($this->password),
					'remember_token' => Str::random(60),
				])->save();

				event(new PasswordReset($user));
			}
		);

		// Gestion du statut de la réinitialisation du mot de passe
		if (Password::PASSWORD_RESET != $status)
		{
			$this->addError('email', __($status));

			return;
		}

		// Affichage du statut de la réinitialisation
		Session::flash('status', __($status));

		// Redirection vers la page de connexion
		$this->redirectRoute('login', navigate: true);
	}
}; ?>

<div>
    <!-- Formulaire de réinitialisation du mot de passe -->
    <x-card class="flex items-center justify-center h-screen" title="{{__('Reset Password')}}" shadow separator progress-indicator>
        <!-- Affichage du statut de la réinitialisation -->
        <x-session-status class="mb-4" :status="session('status')" />
        <x-form wire:submit="resetPassword">
            <!-- Champ d'email -->
            <x-input label="{{__('E-mail')}}" wire:model="email" icon="o-envelope" inline />
            <!-- Champ de mot de passe -->
            <x-input label="{{__('Password')}}" wire:model="password" type="password" icon="o-key" inline />
            <!-- Champ de confirmation du mot de passe -->
            <x-input label="{{__('Confirm Password')}}" wire:model="password_confirmation" type="password" icon="o-key" inline required autocomplete="new-password" />
            <x-slot:actions>
               <!-- Bouton pour réinitialiser le mot de passe -->
               <x-button label="{{ __('Reset Password') }}" type="submit" icon="o-paper-airplane" class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
