<x-form wire:submit="save">
    <x-input label="{{ __('Title') }}" wire:model.debounce.500ms="title" wire:change="$refresh" />
    <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />
    <x-slot:actions>
        <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
            class="btn-primary" />
    </x-slot:actions>
</x-form>

