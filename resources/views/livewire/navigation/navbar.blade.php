<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{Auth, Session};
use Livewire\Volt\Component;

new class extends Component {
    // Property to hold the collection of menus
    public Collection $menus;

    /**
     * Method to initialize the component with the given menus collection
     *
     * @param Collection $menus - The collection of menus to be assigned to the property
     */
    public function mount(Collection $menus): void
    {
        // Assign the provided menus collection to the property
        $this->menus = $menus;
    }

    /**
     * Method to handle the user logout process
     */
    public function logout(): void
    {
        // Log out the user using the web guard
        Auth::guard('web')->logout();

        // Invalidate the current session
        Session::invalidate();
        // Regenerate the CSRF token for security purposes
        Session::regenerateToken();

        // Redirect the user to the homepage
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
            @if ($user = auth()->user())
                <!-- Menu déroulant pour l'utilisateur connecté -->
                <x-dropdown>
                    <x-slot:trigger>
                        <x-button label="{{ $user->name }}" class="btn-ghost" />
                    </x-slot:trigger>
                    <x-menu-item title="{{ __('Profile') }}" link="{{ route('profile') }}" />
                    <x-menu-item title="{{ __('Logout') }}" wire:click="logout" />
                    @if ($user->isAdminOrRedac())
                        <x-menu-item title="{{ __('Administration') }}" link="{{ route('admin') }}" />
                    @endif
                </x-dropdown>
            @else
                <!-- Bouton de connexion pour les utilisateurs non connectés -->
                <x-button label="{{ __('Login') }}" link="/login" class="btn-ghost" />
            @endif

            <!-- Menus dynamiques -->
            @foreach ($menus as $menu)
                @if ($menu->submenus->isNotEmpty())
                    <x-dropdown>
                        <x-slot:trigger>
                            <x-button label="{{ $menu->label }}" class="btn-ghost" />
                        </x-slot:trigger>
                        @foreach ($menu->submenus as $submenu)
                            <x-menu-item title="{{ $submenu->label }}" link="{{ $submenu->link }}"
                                style="min-width: max-content;" />
                        @endforeach
                    </x-dropdown>
                @else
                    <x-button label="{{ $menu->label }}" link="{{ $menu->link }}" class="btn-ghost" />
                @endif
            @endforeach
        </span>
        @auth
            @if ($user->favoritePosts()->exists())
                <a title="{{ __('Favorites posts') }}" href="{{ route('posts.favorites') }}"><x-icon name="s-star"
                        class="w-7 h-7" /></a>
            @endif
            @if ($user->isStudent)
                <a title="{{ __('Academy access') }}" href="{{ route('academy.test') }}"><x-icon name="o-academic-cap"
                        class="w-7 h-7" /></a>
            @endif
            <a title="{{ __('Chat') }}" href="{{ route('chat') }}"><x-icon name="o-chat-bubble-oval-left"
                    class="w-6 h-6" /></a>
        @endauth
        <x-theme-toggle title="{{ __('Toggle theme') }}" class="w-4 h-8" />
        <livewire:search />
    </x-slot:actions>
</x-nav>
