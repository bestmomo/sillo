<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new 
#[Layout('components.layouts.auth')]
class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div>
    <x-card class="h-screen flex items-center justify-center" title="{{__('Reset Password')}}" shadow separator  progress-indicator>
        <x-session-status class="mb-4" :status="session('status')" />
        <x-form wire:submit="resetPassword">
            <x-input label="{{__('E-mail')}}" wire:model="email" icon="o-envelope" inline />
            <x-input label="{{__('Password')}}" wire:model="password" type="password" icon="o-key" inline />
            <x-input label="{{__('Confirm Password')}}" wire:model="password_confirmation" type="password" icon="o-key" inline required autocomplete="new-password" />
            <x-slot:actions>
               <x-button label="{{ __('Reset Password') }}" type="submit" icon="o-paper-airplane" class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>

