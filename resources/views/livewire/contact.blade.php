<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use App\Models\Contact;
use Mary\Traits\Toast;

new
#[Title('Contact')]
#[Layout('components.layouts.auth')]
class extends Component {

    use Toast;
  
    #[Rule('required|string|max:255')]
    public string $name = '';
 
    #[Rule('required|email')]
    public string $email = '';
    
    #[Rule('required|max:1000')]
    public string $message = '';

    #[Rule('nullable|numeric|exists:users,id')]
    public int|null $user_id = null;
    
    public function mount(): void
    {
        if(Auth::check()) {
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $this->user_id = Auth::id();
        }
    }
    
    public function save()
    {
        $data = $this->validate();

        Contact::create($data);

        $this->success(__('Your message has been sent!'), redirectTo: '/');
    }

}; ?>

<div>
    <x-card 
        title="{{__('Contact')}}" 
        subtitle="{{ __('Use this form to contact me') }}"
        shadow 
        separator
        progress-indicator>
        <x-form wire:submit="save">
            @if(!Auth()->check())
                <x-input 
                    label="{{__('Name')}}" 
                    wire:model="name" 
                    icon="o-user" 
                    inline />
                <x-input 
                    label="{{__('E-mail')}}" 
                    wire:model="email" 
                    icon="o-envelope" 
                    inline />
            @endif
            <x-textarea
                wire:model="message"
                hint="{{ __('Max 1000 chars') }}"
                rows="5"
                placeholder="{{ __('Your message...')}}"
                inline />
            <x-slot:actions>
                <x-button label="{{ __('Cancel') }}" link="/" class="btn-ghost" />
                <x-button label="{{__('Save')}}" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login" />
            </x-slot:actions>
        </x-form>        
    </x-card>
</div>
