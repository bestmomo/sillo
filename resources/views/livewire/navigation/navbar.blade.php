<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Menu;
use Illuminate\Support\Collection;

new class extends Component 
{
    public Collection$menus;

    // Initialise le composant avec les menus donnés.
    public function mount($menus)
    {
        $this->menus = $menus;
    }

    // Déconnecte l'utilisateur actuellement authentifié.
    public function logout(): void
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        $this->redirect('/');
    }

}; ?>

<x-nav sticky full-width>
    <x-slot:brand>
        <label for="main-drawer" class="lg:hidden mr-3">
            <x-icon name="o-bars-3" class="cursor-pointer" />
        </label>
    </x-slot:brand>

    <x-slot:actions> 
        <span class="hidden lg:block">
            @if($user = auth()->user())
                <x-dropdown>
                    <x-slot:trigger>
                        <x-button label="{{ $user->name }} " class="btn-ghost" />
                    </x-slot:trigger>
                    <x-menu-item title="{{ __('Profile') }}" link="{{ route('profile') }}" />
                    <x-menu-item title="{{ __('Logout') }}" wire:click="logout" />
                    @if($user->isAdminOrRedac())
                        <x-menu-item title="{{ __('Administration') }}" link="{{ route('admin') }}" />
                    @endif
                </x-dropdown>   
            @else
                <x-button label="{{ __('Login') }}" link="/login" class="btn-ghost" />
            @endif

            @foreach ($menus as $menu)                
                @if($menu->submenus->isNotEmpty())
                    <x-dropdown>
                        <x-slot:trigger>
                            <x-button label="{{$menu->label}}" class="btn-ghost" />
                        </x-slot:trigger>
                        @foreach ($menu->submenus as $submenu)
                            <x-menu-item title="{{ $submenu->label }}"  link="{{ $submenu->link }}" style="min-width: max-content;" />
                        @endforeach
                    </x-dropdown>
                @else
                    <x-button label="{{ $menu->label }}" link="{{ $menu->link }}" class="btn-ghost" />
                @endif
            @endforeach
        </span>
        <x-theme-toggle />
        <livewire:search />  
    </x-slot:actions>
</x-nav>

