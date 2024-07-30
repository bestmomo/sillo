<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\{Footer};
use Illuminate\Support\Collection;
use Livewire\Attributes\{Layout, Rule, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Footer Menu'), Layout('components.layouts.admin')] class extends Component {
	use Toast;

	public Collection $footers;

	#[Rule('required|max:255|unique:footers,label')]
	public string $label = '';

	#[Rule('nullable|regex:/\/([a-z0-9_-]\/*)*[a-z0-9_-]*/')]
	public string $link = '';

	// Méthode appelée lors de l'initialisation du composant.
	public function mount(): void
	{
		$this->getFooters();
	}

	// Récupérer les footers triés par ordre.
	public function getFooters(): void
	{
		$this->footers = Footer::orderBy('order')->get();
	}

	// Monter un footer d'un rang.
	public function up(Footer $footer): void
	{
		$previousFooter = Footer::where('order', '<', $footer->order)
			->orderBy('order', 'desc')
			->first();

		$this->swap($footer, $previousFooter);
	}

	// Descendre un footer d'un rang.
	public function down(Footer $footer): void
	{
		$previousFooter = Footer::where('order', '>', $footer->order)
			->orderBy('order', 'asc')
			->first();

		$this->swap($footer, $previousFooter);
	}

	// Supprimer un footer.
	public function deleteFooter(Footer $footer): void
	{
		$footer->delete();
		$this->reorderFooters();
		$this->getFooters();
		$this->success(__('Footer deleted with success.'));
	}

	// Enregistrer un nouveau footer.
	public function saveFooter(): void
	{
		$data          = $this->validate();
		$data['order'] = $this->footers->count() + 1;
		$newFooter     = Footer::create($data);
		$this->footers->push($newFooter);
		$this->success(__('Footer created with success.'));
	}

	// Échanger les ordres de deux footers.
	private function swap(Footer $footer, Footer $previousFooter): void
	{
		$tempOrder             = $footer->order;
		$footer->order         = $previousFooter->order;
		$previousFooter->order = $tempOrder;

		$footer->save();
		$previousFooter->save();
		$this->getFooters();
	}

	// Réordonner les footers après suppression.
	private function reorderFooters(): void
	{
		$footers = Footer::orderBy('order')->get();
		foreach ($footers as $index => $footer) {
			$footer->order = $index + 1;
			$footer->save();
		}
	}
}; ?>

<div>
    <x-header title="{{ __('Footer') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card>

        @foreach ($footers as $footer)
            <x-list-item :item="$footer" no-separator no-hover>
                <x-slot:value>
                    {{ $footer->label }}
                </x-slot:value>
                <x-slot:sub-value>
                    {{ $footer->link }}
                </x-slot:sub-value>
                <x-slot:actions>
                    @if ($footer->order > 1)
                        <x-popover>
                            <x-slot:trigger>
                                <x-button icon="s-chevron-up" wire:click="up({{ $footer->id }})" spinner />
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Up')
                            </x-slot:content>
                        </x-popover>
                    @endif
                    @if ($footer->order < $footers->count())
                        <x-popover>
                            <x-slot:trigger>
                                <x-button icon="s-chevron-down" wire:click="down({{ $footer->id }})" spinner />
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Down')
                            </x-slot:content>
                        </x-popover>
                    @endif
                    <x-popover>
                        <x-slot:trigger>
                            <x-button icon="c-arrow-path-rounded-square" link="{{ route('footers.edit', $footer->id) }}"
                                class="text-blue-500 btn-ghost btn-sm" spinner />
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Edit')
                        </x-slot:content>
                    </x-popover>
                    <x-popover>
                        <x-slot:trigger>
                            <x-button icon="o-trash" wire:click="deleteMenu({{ $footer->id }})"
                                wire:confirm="{{ __('Are you sure to delete this footer?') }}" spinner
                                class="text-red-500 btn-ghost btn-sm" />
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Delete')
                        </x-slot:content>
                    </x-popover>
                </x-slot:actions>
            </x-list-item>
        @endforeach

    </x-card>

    <br>

    <x-card class="" title="{{ __('Create a new footer') }}">

        <x-form wire:submit="saveFooter">
            <x-input label="{{ __('Title') }}" wire:model="label" />
            <x-input type="text" wire:model="link"
                label="{{ __('Link') }} ({{ __('I.e.') }}: /{{ __('my-page') }}, /pages/slug {{ __('or') }} /pages/{{ strtolower(__('Folder')) }}/{{ __('my_page') }}-1)" />
            <x-slot:actions>
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
