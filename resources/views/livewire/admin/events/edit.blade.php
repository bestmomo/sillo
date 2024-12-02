<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\Event;
use App\Traits\ManageEvent;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Edit Event'), Layout('components.layouts.admin')] class extends Component
{
	use Toast;
	use ManageEvent;

	public Event $event;

	public function mount(Event $event): void
	{
		$this->event = $event;
		$this->fill($this->event);
		$this->colors = $this->getColors();
	}

	// Enregistre le nouvel événement
	public function save()
	{
		$data = $this->validate($this->rules);
		if ($this->checkDates())
		{
			return;
		}

		$this->event->update($data);

		$this->success(__('Event updated with success.'), redirectTo: '/admin/events/index');
	}
}; ?>

<div>
    <x-header title="{{ __('Edit an event') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    @include('livewire.admin.events.event-form')
</div>
