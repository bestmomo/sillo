<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

new 
#[Layout('components.layouts.auth')]
class extends Component {
    
    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect('/');
        }

        auth()->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

}; ?>

<div>
    <x-card class="h-screen flex items-center justify-center" title="{{__('E-mail Verification')}}" subtitle="{{__('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you had issue to receive the email, we will gladly send you another.')}}" shadow separator>
        <x-session-status class="mb-4" :status="session('status')" />
        <x-form wire:submit="sendPasswordResetLink">
            <x-slot:actions>
               <x-button label="{{ __('Resend Verification Email') }}" link="/email/verification-notification" />
               <x-button label="{{ __('Logout') }}" wire:click="logout" class="btn-outline" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
