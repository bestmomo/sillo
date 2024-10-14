<?php

use Livewire\Attributes\{Layout, Validate, Title};
use Livewire\Volt\Component;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

new
#[Title('Login')]
#[Layout('components.layouts.auth')]
class extends Component {

    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

	public function login()
	{
        $this->validate();

        $this->authenticate();

        Session::regenerate();

        if (auth()->user()->isAdmin()) {
            return redirect()->intended('/admin/dashboard');
        }

        $this->redirectIntended(default: url('/'), navigate: true);
	}

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only(['email', 'password']), $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }

}; ?>

<div>
    <x-card class="flex items-center justify-center h-screen" title="{{ __('Login') }}" shadow separator progress-indicator>
        <x-form wire:submit="login">
            <x-input label="{{ __('E-mail') }}" wire:model="email" icon="o-envelope" type="email" inline />
            <x-input label="{{ __('Password') }}" wire:model="password" type="password" icon="o-key" type="password" inline />
            <x-checkbox label="{{ __('Remember me') }}" wire:model="remember" />
            <x-slot:actions>
                <div class="flex flex-col space-y-2 flex-end sm:flex-row sm:space-y-0 sm:space-x-2">
                    <x-button label="{{ __('Login') }}" type="submit" icon="o-paper-airplane" class="ml-2 btn-primary sm:order-1" />
                    <div class="flex flex-col space-y-2 flex-end sm:flex-row sm:space-y-0 sm:space-x-2">
                        <x-button label="{{ __('Forgot your password?') }}" class="btn-ghost" link="/forgot-password" />
                        <x-button label="{{ __('Create an account') }}" class="btn-ghost" link="/register" />
                    </div>
                </div>
            </x-slot:actions>
        </x-form>
    </x-card>
</div>