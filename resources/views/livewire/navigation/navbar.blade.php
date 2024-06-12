<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Menu;
use Illuminate\Support\Collection;

new class extends Component 
{
    // Collection de menus
    public Collection $menus;

    /**
     * Initialise le composant avec les menus donnés.
     * 
     * @param Collection $menus
     * @return void
     */
    public function mount(Collection $menus): void
    {
        $this->menus = $menus;
    }

    /**
     * Déconnecte l'utilisateur actuellement authentifié.
     * 
     * @return void
     */
    public function logout(): void
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        $this->redirect('/');
    }
};
?>

<x-nav sticky full-width>
    <!-- Marque du site -->
    <x-slot:brand>
        <label for="main-drawer" class="mr-3 lg:hidden">
            <x-icon name="o-bars-3" class="cursor-pointer" />
        </label>
    </x-slot:brand>

    <!-- Actions de la barre de navigation -->
    <x-slot:actions>
        <span class="hidden lg:block">
            @if($user = auth()->user())
                <!-- Menu déroulant pour l'utilisateur connecté -->
                <x-dropdown>
                    <x-slot:trigger>
                        <x-button label="{{ $user->name }}" class="btn-ghost" />
                    </x-slot:trigger>
                    <x-menu-item title="{{ __('Profile') }}" link="{{ route('profile') }}" />
                    <x-menu-item title="{{ __('Logout') }}" wire:click="logout" />
                    @if($user->isAdminOrRedac())
                        <x-menu-item title="{{ __('Administration') }}" link="{{ route('admin') }}" />
                    @endif
                </x-dropdown>
            @else
                <!-- Bouton de connexion pour les utilisateurs non connectés -->
                <x-button label="{{ __('Login') }}" link="/login" class="btn-ghost" />
            @endif

            <!-- Menus dynamiques -->
            @foreach ($menus as $menu)
                @if($menu->submenus->isNotEmpty())
                    <x-dropdown>
                        <x-slot:trigger>
                            <x-button label="{{ $menu->label }}" class="btn-ghost" />
                        </x-slot:trigger>
                        @foreach ($menu->submenus as $submenu)
                            <x-menu-item title="{{ $submenu->label }}" link="{{ $submenu->link }}" style="min-width: max-content;" />
                        @endforeach
                    </x-dropdown>
                @else
                    <x-button label="{{ $menu->label }}" link="{{ $menu->link }}" class="btn-ghost" />
                @endif
            @endforeach
        </span>
        @auth
            <x-button icon="c-chat-bubble-oval-left" link="/chat" tooltip-bottom="{{ __('Chat')}}" class="btn-circle btn-ghost" />
        @endauth
        <x-theme-toggle />
        <livewire:search />
    </x-slot:actions>
</x-nav>
