<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Mary\Traits\Toast;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

new
#[Title('Profile')]
#[Layout('components.layouts.auth')]
class extends Component 
{
    use Toast;

    public User $user;
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
 
    public function mount(): void
    {
        $this->user = Auth::user();
        $this->fill($this->user);
    }

    public function save(): void
    {
        $data = $this->validate([
            'email' => [
                'required','email',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'password' => 'confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);

        $this->user->update($data);

        $this->success(__('Profile updated with success.'), redirectTo: '/profile');
    }

    public function deleteAccount(): void
    {
        $this->user->delete();
        $this->success(__('Account deleted with success.'), redirectTo: '/');
    }

    public function generatePassword($length = 16): void
    {
        $this->password = Str::random($length);
    }

}; ?>

<div>
    <x-card class="h-screen flex items-center justify-center" title="{{__('Update profile')}}" shadow separator >
        <x-form wire:submit="save">

            <x-avatar :image="Gravatar::get($user->email)" class="!w-24">
    
                <x-slot:title class="text-xl pl-2">
                    {{ $user->name }}
                </x-slot:title>
            
                <x-slot:subtitle class="text-gray-500 flex flex-col gap-1 mt-2 pl-2">
                    <x-icon name="o-hand-raised" label="{{ __('Your name can\'t be changed') }}" />
                    <a href="https://fr.gravatar.com/"><x-icon name="c-user" label="{{ __('You can change your profile picture on Gravatar') }}" /></a>
                </x-slot:subtitle>
            
            </x-avatar>

            <x-input 
                label="{{__('E-mail')}}" 
                value="{{ $email }}" 
                wire:model="email" 
                icon="o-envelope" 
                inline />

                <hr>

            <x-input label="{{__('Password')}}" wire:model="password" icon="o-key" inline />
            <x-input label="{{__('Confirm Password')}}" wire:model="password_confirmation" icon="o-key" inline />
            <x-button label="{{ __('Generate a secure password')}}" wire:click="generatePassword()" icon="m-wrench" class="btn-outline btn-sm" />

            <x-slot:actions>
                <x-button 
                    label="{{ __('Cancel') }}" 
                    link="/"
                    class="btn-ghost" />
                <x-button 
                    label="{{__('Delete account')}}" 
                    icon="c-hand-thumb-down"
                    wire:confirm="{{__('Are you sure to delete your account?')}}"
                    wire:click="deleteAccount"
                    class="btn-warning" />
                <x-button 
                    label="{{__('Save')}}" 
                    icon="o-paper-airplane" 
                    spinner="save" 
                    type="submit" 
                    class="btn-primary" />
            </x-slot:actions>

        </x-form>
    </x-card>
</div>
