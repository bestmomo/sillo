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

<div>
    <x-menu activate-by-route>
        {{-- Utilisateur --}}
        @if($user = auth()->user())
            <x-menu-separator />
                <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="-mx-2 !-my-2 rounded">
                    <x-slot:actions>
                        <x-button icon="o-power" wire:click="logout" class="btn-circle btn-ghost btn-xs" tooltip-left="{{ __('Logout') }}" no-wire-navigate />
                    </x-slot:actions>
                </x-list-item>
                <x-menu-item title="{{ __('Profile') }}" icon="o-user" link="{{ route('profile') }}" />
                @if($user->isAdminOrRedac())
                    <x-menu-item title="{{ __('Administration') }}" link="{{ route('admin') }}" />
                @endif
            <x-menu-separator />
        @else
            <x-menu-item title="{{ __('Login') }}" link="/login" />
        @endif

        {{-- Menus dynamiques --}}
        @foreach ($menus as $menu)
            @if($menu->submenus->isNotEmpty())
                <x-menu-sub title="{{ $menu->label }}">
                    @foreach ($menu->submenus as $submenu)
                        <x-menu-item title="{{ $submenu->label }}" link="{{ $submenu->link }}" />
                    @endforeach
                </x-menu-sub>
            @else
                <x-menu-item title="{{ $menu->label }}" link="{{ $menu->link }}" />
            @endif
        @endforeach
    </x-menu>
</div>

