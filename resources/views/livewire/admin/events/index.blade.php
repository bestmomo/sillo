<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\Event;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

new #[Title('Quizzes'), Layout('components.layouts.admin')] class extends Component {
    use Toast, WithPagination;

    public string $search = '';

    // Définir les en-têtes de la table
    public function headers(): array
    {
        return [
            ['key' => 'label', 'label' => __('Title')],
            ['key' => 'description', 'label' => __('Description')],
            ['key' => 'color', 'label' => __('Color')],
            ['key' => 'date', 'label' => __('Date')],
        ];
    }

    // Supprimer un événement
    public function deleteEvent(Event $event): void
    {
        $event->delete();
        $this->success(__('Event deleted'));
    }

    public function getEvents(): LengthAwarePaginator
    {
        $events = Event::orderBy('start_date', 'asc')
            ->when($this->search, fn(Builder $q) => $q->where('label', 'like', "%{$this->search}%"))
            ->paginate(10);

        // Formater les événements pour inclure la date ou la plage de dates
        $events->getCollection()->transform(function ($event) {
            if (is_null($event->end_date)) {
                $event->formatted_date = Carbon::parse($event->start_date)->isoFormat('LL');
            } else {
                $event->formatted_date = Carbon::parse($event->start_date)->isoFormat('LL') . ' - ' . Carbon::parse($event->end_date)->isoFormat('LL');
            }
            return $event;
        });

        return $events;
    }

    // Fournir les données nécessaires à la vue
    public function with(): array
    {
        return [
            'events' => $this->getEvents(), 
            'headers' => $this->headers(),
        ];
    }
}; ?>

<div>
    <x-header title="{{ __('Events') }}" separator progress-indicator>
        <x-slot:actions>
            <x-input placeholder="{{ __('Search...') }}" wire:model.live.debounce="search" clearable
            icon="o-magnifying-glass" />
            <x-button label="{{ __('Add an event') }}" class="btn-outline lg:hidden" link="{{ route('events.create') }}" />
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table :headers="$headers" :rows="$events" link="/admin/events/{id}/edit" with-pagination>
            @scope('cell_color', $event)
                <x-badge value="  " class="bg-{{$event->color}}-200" />
            @endscope
            @scope('cell_date', $event)
                {{ $event->formatted_date }}
            @endscope
            @scope('actions', $event)
                <x-popover>
                    <x-slot:trigger>
                        <x-button icon="o-trash" wire:click="deleteEvent({{ $event->id }})"
                            wire:confirm="{{ __('Are you sure to delete this event?') }}" spinner
                            class="text-red-500 btn-ghost btn-sm" />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                        @lang('Delete')
                    </x-slot:content>
                </x-popover>
            @endscope
        </x-table>
    </x-card>
</div>
