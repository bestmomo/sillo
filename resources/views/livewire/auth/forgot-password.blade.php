<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

// Définition du composant avec l'attribut de mise en page
new
#[Layout('components.layouts.auth')]
class extends Component
{
	// Déclaration de la propriété pour stocker l'email
	public string $email = '';

	// Méthode pour envoyer le lien de réinitialisation du mot de passe
	public function sendPasswordResetLink(): void
	{
		// Validation de l'email
		$this->validate([
			'email' => ['required', 'string', 'email'],
		]);

		// Envoi du lien de réinitialisation du mot de passe
		$status = Password::sendResetLink(
			$this->only('email')
		);

		// Vérification du statut de l'envoi du lien
		if (Password::RESET_LINK_SENT != $status)
		{
			// En cas d'erreur, ajout de l'erreur à la propriété des erreurs
			$this->addError('email', __($status));

			return;
		}

		// Réinitialisation de la valeur de l'email après envoi réussi
		$this->reset('email');

		// Affichage d'un message de succès
		session()->flash('status', __($status));
	}
}; ?>

<div>
    <x-card class="flex items-center justify-center h-screen" title="{{__('Password renewal')}}" subtitle="{{__('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.')}}" shadow separator  progress-indicator>
        <x-session-status class="mb-4" :status="session('status')" />
        <x-form wire:submit="sendPasswordResetLink">
            <x-input label="{{__('Your e-mail')}}" wire:model="email" icon="o-envelope" required />
			<p class="text-xs text-gray-500"><span class="text-red-600">*</span> @lang('Required information')</p>
            <x-slot:actions>
                <x-button label="{{ __('Email Password Reset Link') }}" type="submit" icon="o-paper-airplane" class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
