<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\Event;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use App\Traits\ManageEvent;

new #[Title('Create Event'), Layout('components.layouts.admin')] class extends Component {
    use Toast, ManageEvent;

    public function mount(): void
    {
        $this->colors = $this->getColors();
    }
    
    // Enregistre la nouvelle page
    public function save()
    {
        $data = $this->validate($this->rules);
        if($this->checkDates()) return;

        Event::create($data);

        $this->success(__('Event added with success.'), redirectTo: '/admin/events/index');
    }

}; ?>

<div>
    <x-header title="{{ __('Add an event') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    @include('livewire.admin.events.event-form')
</div>
