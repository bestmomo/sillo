<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\Page;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

new
#[Title('Pages'), Layout('components.layouts.admin')]
class extends Component {
	use Toast;
	use WithPagination;

	// Définir les en-têtes de la table.
	public function headers(): array
	{
		return [
			['key' => 'title', 'label' => __('Title')],
			['key' => 'slug', 'label' => 'Slug'],
		];
	}

	// Supprimer une page.
	public function deletePage(Page $page): void
	{
		$page->delete();
		$this->success(__('Page deleted'));
	}

	// Fournir les données nécessaires à la vue.
	public function with(): array
	{
		return [
			'pages'   => Page::select('id', 'title', 'slug')->get(),
			'headers' => $this->headers(),
		];
	}
}; ?>

<div>
	<a href="/admin/dashboard" title="{{ __('Back to Dashboard') }}">
		<x-header title="{{__('Pages')}}" separator progress-indicator>
	</a>
    <x-slot:actions>
      <x-button label="{{ __('Add a page') }}" class="btn-outline" link="{{ route('pages.create') }}" />
    </x-slot:actions>
  </x-header>

  <x-card>
    <x-table striped :headers="$headers" :rows="$pages" link="/admin/pages/{slug}/edit">
      @scope('actions', $page)
		<x-popover>
			<x-slot:trigger>
				<x-button 
					icon="o-trash" 
					wire:click="deletePage({{ $page->id }})" 
					wire:confirm="{{ __('Are you sure to delete this page?') }}" 
					spinner 
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
