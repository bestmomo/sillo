<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Models\Contact;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

new
#[Title('Contacts')]
#[Layout('components.layouts.admin')]
class extends Component {
	use Toast;
	use WithPagination;

	// Définition des en-têtes des colonnes
	public function headers(): array
	{
		return [
			['key' => 'name', 'label' => __('Name')],
			['key' => 'email', 'label' => __('Email')],
			['key' => 'message', 'label' => __('Message')],
			['key' => 'created_at', 'label' => __('Sent on')],
		];
	}

	// Méthode pour supprimer un contact
	public function deleteContact(Contact $contact): void
	{
		$contact->delete();
		$this->success(__('Contact deleted'));
	}

	// Méthode pour la mise à jour du statut traité/non traité
	public function toggleContact(Contact $contact, bool $status): void
	{
		$contact->handled = $status;
		$contact->save();
		$message = $status ? __('Contact marked as handled') : __('Contact marked as unhandled');
		$this->success($message);
	}

	// Méthode pour récupérer les données nécessaires à la vue
	public function with(): array
	{
		return [
			'headers'        => $this->headers(),
			'contacts'       => Contact::latest()->paginate(10),
			'row_decoration' => ['bg-yellow-500/25' => fn (Contact $contact) => !$contact->handled],
		];
	}
}; ?>

<div>
  <x-header title="{{ __('Contacts') }}" separator progress-indicator />

  <x-card>
    <x-table :headers="$headers" :rows="$contacts" :row-decoration="$row_decoration">
      @scope('cell_created_at', $contact)
      {{ $contact->created_at->isoFormat('LL') }} {{ __('at') }} {{ $contact->created_at->isoFormat('HH:mm') }}
      @endscope
      @scope('actions', $contact)
      <div class="flex">
        @if($contact->handled)
        <x-button icon="o-face-smile" wire:click="toggleContact({{ $contact->id }}, false)"
          tooltip-left="{{ __('Mark as unhandled') }}" spinner class="text-green-500 btn-ghost btn-sm" />
        @else
        <x-button icon="o-face-smile" wire:click="toggleContact({{ $contact->id }}, true)"
          tooltip-left="{{ __('Mark as handled') }}" spinner class="text-red-500 btn-ghost btn-sm" />
        @endif
        <x-button icon="o-envelope"
          link="mailto:{{ $contact->email }}?subject={{ __('Contact') }}&body={{ $contact->message }}"
          tooltip-left="{{ __('Answer') }}" no-wire-navigate spinner class="text-blue-500 btn-ghost btn-sm" />
        <x-button icon="o-trash" wire:click="deleteContact({{ $contact->id }})"
          wire:confirm="{{ __('Are you sure to delete this contact?') }}" tooltip-left="{{ __('Delete') }}" spinner
          class="text-red-500 btn-ghost btn-sm" />
      </div>
      @endscope
    </x-table>
  </x-card>
</div>
