<?php

use App\Models\Contact;
use Livewire\Attributes\{Layout, Rule};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

// Définition du composant avec les attributs de titre et de mise en page
new #[Title('Contact')] #[Layout('components.layouts.auth')] class extends Component {
	use Toast;

	// Définition des règles de validation pour les champs du formulaire
	#[Rule('required|string|max:255')]
	public string $name = '';

	#[Rule('required|email')]
	public string $email = '';

	#[Rule('required|max:1000')]
	public string $message = '';

	#[Rule('nullable|numeric|exists:users,id')]
	public ?int $user_id = null;

	// Méthode de montage pour pré-remplir les champs avec les informations de l'utilisateur authentifié
	public function mount(): void
	{
		if (Auth::check()) {
			$this->name    = Auth::user()->name;
			$this->email   = Auth::user()->email;
			$this->user_id = Auth::id();
		}
	}

	// Méthode pour enregistrer le formulaire de contact
	public function save()
	{
		// Validation des données du formulaire
		$data = $this->validate();

		// Création d'un nouveau contact avec les données validées
		Contact::create($data);

		// Affichage d'un message de réussite avec une redirection
		$this->success(__('Your message has been sent!'), redirectTo: '/');
	}
}; ?>

<div>
    <!-- Formulaire de contact encapsulé dans une carte -->
    <x-card title="{{ __('Contact') }}" subtitle="{{ __('Use this form to contact me') }}" shadow separator
        progress-indicator>
        <x-form wire:submit="save">
            <!-- Affichage des champs de nom et d'email uniquement si l'utilisateur n'est pas connecté -->
            @if (!Auth()->check())
                <x-input label="{{ __('Name') }}" wire:model="name" icon="o-user" inline />
                <x-input label="{{ __('E-mail') }}" wire:model="email" icon="o-envelope" inline />
            @endif
            <!-- Champ de message -->
            <x-textarea wire:model="message" hint="{{ __('Max 1000 chars') }}" rows="5"
                placeholder="{{ __('Your message...') }}" inline />
            <!-- Boutons d'actions -->
            <x-slot:actions>
                <x-button label="{{ __('Cancel') }}" link="/" class="btn-ghost" />
                <x-button label="{{ __('Save') }}" type="submit" icon="o-paper-airplane" class="btn-primary"
                    spinner="login" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
