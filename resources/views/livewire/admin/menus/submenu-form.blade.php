<x-form wire:submit="saveSubmenu({{ $menu->id ?? 'null' }})">
    <x-radio :options="$subOptions" wire:model="subOption" wire:change="$refresh" />
    @if ($subOption == 1)
        <x-choices label="{{ __('Post') }}" wire:model="subPost" :options="$postsSearchable" option-label="title"
            hint="{{ __('Select a post, type to search') }}" debounce="300ms" min-chars="2"
            no-result-text="{{ __('No result found!') }}" single searchable @change-selection="$wire.changeSelection($event.detail.value)" />
    @elseif($subOption == 2)
        <x-select label="{{ __('Page') }}" option-label="title" :options="$pages"
            placeholder="{{ __('Select a page') }}" wire:model="subPage"
            wire:change="$refresh" />
    @elseif($subOption == 3)
        <x-select label="{{ __('Serie') }}" option-label="title" :options="$series"
            placeholder="{{ __('Select a serie') }}" wire:model="subSerie"
            wire:change="$refresh" />
    @elseif($subOption == 4)
        <x-select label="{{ __('Category') }}" option-label="title" :options="$categories"
            placeholder="{{ __('Select a category') }}" wire:model="subCategory"
            wire:change="$refresh" />
    @endif
    <x-input label="{{ __('Title') }}" wire:model="sublabel" />
    <x-input type="text" wire:model="sublink" label="{{ __('Link') }}" />
    <x-slot:actions>
        <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save"
            type="submit" class="btn-primary" />
    </x-slot:actions>
</x-form>
