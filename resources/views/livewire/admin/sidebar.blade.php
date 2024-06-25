<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Menu;

new class extends Component 
{
    public function logout(): void
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        $this->redirect('/');
    }
    
}; ?>

<div>    
    <x-menu activate-by-route>
        <x-menu-separator />
            <x-list-item :item="Auth::user()" value="name" sub-value="email" no-separator no-hover class="-mx-2 !-my-2 rounded">
                <x-slot:actions>
                    <x-button icon="o-power" wire:click="logout" class="btn-circle btn-ghost btn-xs" tooltip-left="{{__('Logout')}}" no-wire-navigate />
                </x-slot:actions>
            </x-list-item>
        <x-menu-separator />

        <x-menu-item title="{{ __('Dashboard') }}" icon="s-building-office-2" link="{{ route('admin') }}" />
        <x-menu-sub title="{{ __('Posts') }}" icon="s-document-text">
            <x-menu-item title="{{ __('All posts') }}" link="{{ route('posts.index') }}" />
            <x-menu-item title="{{ __('Add a post') }}" link="{{ route('posts.create') }}" />
            @if(Auth::user()->isAdmin())
                <x-menu-item title="{{ __('Categories') }}" link="{{ route('categories.index') }}" />
            @endif
            <x-menu-item title="{{ __('Series') }}" link="{{ route('series.index') }}" />
        </x-menu-sub>
        @if(Auth::user()->isAdmin())
            <x-menu-sub title="{{ __('Pages') }}" icon="s-document">
                <x-menu-item title="{{ __('All pages') }}" link="{{ route('pages.index') }}" />
                <x-menu-item title="{{ __('Add a page') }}" link="{{ route('pages.create') }}" />
            </x-menu-sub>
            <x-menu-item icon="s-user" title="{{ __('Accounts') }}" link="{{ route('users.index') }}" />
        @endif
        <x-menu-item icon="c-chat-bubble-left" title="{{ __('Comments') }}" link="{{ route('comments.index') }}" />  
        @if(Auth::user()->isAdmin())      
            <x-menu-sub title="{{ __('Menus') }}" icon="m-list-bullet">
                <x-menu-item title="{{ __('Navbar') }}" link="{{ route('menus.index') }}" />
                <x-menu-item title="{{ __('Footer') }}" link="{{ route('menus.footers') }}" />
            </x-menu-sub>
            <x-menu-item icon="c-photo" title="{{ __('Images') }}" link="{{ route('images.index') }}" />    
            <x-menu-item icon="s-pencil-square" title="{{ __('Contacs') }}" link="{{ route('contacts.index') }}" />
        @endif
        <x-menu-item icon="m-arrow-right-end-on-rectangle" title="{{ __('Go on site') }}" link="/" />
        <x-menu-item>
            <x-theme-toggle />
        </x-menu-item>
    </x-menu>
</div>
