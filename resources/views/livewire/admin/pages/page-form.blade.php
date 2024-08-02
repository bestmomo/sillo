<x-card>
    <x-form wire:submit="save">
        <x-input type="text" wire:model="title" label="{{ __('Title') }}"
            placeholder="{{ __('Enter the title') }}" wire:change="$refresh" />
        <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" /><br>
        <x-checkbox label="{{ __('Published') }}" wire:model="active" /><br>
        <x-editor wire:model="body" label="{{ __('Content') }}" :config="config('tinymce.config')"
            folder="{{ 'photos/' . now()->format('Y/m') }}" />
        <x-card title="{{ __('SEO') }}" shadow separator>
            <x-input placeholder="{{ __('Title') }}" wire:model="seo_title" hint="{{ __('Max 70 chars') }}" />
            <br>
            <x-textarea label="{{ __('META Description') }}" wire:model="meta_description"
                hint="{{ __('Max 160 chars') }}" rows="2" inline />
            <br>
            <x-textarea label="{{ __('META Keywords') }}" wire:model="meta_keywords"
                hint="{{ __('Keywords separated by comma') }}" rows="1" inline />
        </x-card>
        <x-slot:actions>
            <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                class="btn-primary" />
        </x-slot:actions>
    </x-form>
</x-card>

