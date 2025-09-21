<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\{Auth, RateLimiter};
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\{Layout, Title, Validate};
use Livewire\Volt\Component;

new
#[Title('Login')]
#[Layout('components.layouts.auth')]
class extends Component
{
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

		if (auth()->user()->isAdmin())
		{
			return redirect()->intended('/admin/dashboard');
		}

		$this->redirectIntended(default: url('/'), navigate: true);
	}

	public function authenticate(): void
	{
		$this->ensureIsNotRateLimited();

		if (!Auth::attempt($this->only(['email', 'password']), $this->remember))
		{
			RateLimiter::hit($this->throttleKey());

			throw ValidationException::withMessages([
				'email' => __('auth.failed'),
			]);
		}

		RateLimiter::clear($this->throttleKey());
	}

	protected function ensureIsNotRateLimited(): void
	{
		if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5))
		{
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
		return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
	}
}; ?>

<div>
    <x-card class="flex items-center justify-center h-screen" title="{{ __('Log In') }}" shadow separator progress-indicator>
        <x-form wire:submit="login" >
            <x-input label="{{ __('Your e-mail') }}" wire:model="email" icon="o-envelope" type="email" required />
            <x-password label="{{ __('Your password') }}" wire:model="password" clearable required />
            <x-checkbox label="{{ __('Remain identified for a few days') }}" wire:model="remember" />
            <p class="text-xs text-gray-500"><span class="text-red-600">*</span> @lang('Required information')</p>
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