<?php

use Livewire\Volt\Component;
use App\Models\Page;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Mary\Traits\Toast;

new 
#[Layout('components.layouts.admin')]
class extends Component {

    use Toast, WithPagination;

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
        $this->success(__("Page deleted"));
    }

    // Fournir les données nécessaires à la vue.
    public function with(): array
    {
        return [
            'pages' => Page::select('id', 'title', 'slug')->get(),
            'headers' => $this->headers(),
        ];
    }

}; ?>

<div>
    <x-header title="{{__('Pages')}}" separator progress-indicator >
        <x-slot:actions>
            <x-button label="{{ __('Add a page') }}" class="btn-outline" link="{{ route('pages.create') }}" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table striped :headers="$headers" :rows="$pages" link="/admin/pages/{slug}/edit" >
            @scope('actions', $page)
                <x-button icon="o-trash" wire:click="deletePage({{ $page->id }})" tooltip-left="{{ __('Delete') }}" wire:confirm="{{ __('Are you sure to delete this page?') }}" spinner class="btn-ghost btn-sm text-red-500" />
            @endscope
        </x-table>
    </x-card>
</div>

