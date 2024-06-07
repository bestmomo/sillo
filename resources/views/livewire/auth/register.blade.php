<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
 
// Définition du composant avec les attributs de titre et de mise en page
new
#[Title('Register')]
#[Layout('components.layouts.auth')]
class extends Component {
 
    // Définition des règles de validation pour les champs du formulaire
    #[Rule('required|string|max:255|unique:users')]
    public string $name = '';
 
    #[Rule('required|email|unique:users')]
    public string $email = '';
 
    #[Rule('required|confirmed')]
    public string $password = '';
 
    #[Rule('required')]
    public string $password_confirmation = '';
 
    // Méthode pour enregistrer un nouvel utilisateur
    public function register()
    {
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
 
        // Redirection vers la page d'accueil
        return redirect('/');
    }
}; ?>

<div>
    <!-- Formulaire d'inscription -->
    <x-card class="flex items-center justify-center h-screen" title="{{__('Register')}}" shadow separator progress-indicator>
 
        <x-form wire:submit="register">
            <!-- Champ de nom -->
            <x-input label="{{__('Name')}}" wire:model="name" icon="o-user" inline />
            <!-- Champ d'email -->
            <x-input label="{{__('E-mail')}}" wire:model="email" icon="o-envelope" inline />
            <!-- Champ de mot de passe -->
            <x-input label="{{__('Password')}}" wire:model="password" type="password" icon="o-key" inline />
            <!-- Champ de confirmation du mot de passe -->
            <x-input label="{{__('Confirm Password')}}" wire:model="password_confirmation" type="password" icon="o-key" inline />
    
            <x-slot:actions>
                <!-- Bouton pour rediriger vers la page de connexion -->
                <x-button label="{{__('Already registered?')}}" class="btn-ghost" link="/login" />
                <!-- Bouton pour soumettre le formulaire -->
                <x-button label="{{__('Register')}}" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login" />
            </x-slot:actions>
        </x-form>

    </x-card>
</div>
