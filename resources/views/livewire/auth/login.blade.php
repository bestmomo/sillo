<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new 
#[Title('Login')]
#[Layout('components.layouts.auth')]
class extends Component {

    #[Rule('required|email')]
    public string $email = '';
 
    #[Rule('required')]
    public string $password = '';

    public function login()
    {
        $credentials = $this->validate();
 
        if (auth()->attempt($credentials)) {
            request()->session()->regenerate();
 
            return redirect()->intended('/');
        }
 
        $this->addError('email', __('The provided credentials do not match our records.'));
    }
}; ?>

<div>
    <x-card class="h-screen flex items-center justify-center" title="{{__('Login')}}" shadow separator progress-indicator>
 
        <x-form wire:submit="login">
            <x-input label="{{__('E-mail')}}" wire:model="email" icon="o-envelope" inline />
            <x-input label="{{__('Password')}}" wire:model="password" type="password" icon="o-key" inline />
            <x-checkbox label="{{ __('Remember me') }}" wire:model="remember"/>

            <x-slot:actions>
                <x-button label="{{__('Forgot your password?')}}" class="btn-ghost" link="/forgot-password" />
                <x-button label="{{__('Create an account')}}" class="btn-ghost" link="/register" />
                <x-button label="{{__('Login')}}" type="submit" icon="o-paper-airplane" class="btn-primary" />
            </x-slot:actions>
        </x-form>

    </x-card>
</div>
