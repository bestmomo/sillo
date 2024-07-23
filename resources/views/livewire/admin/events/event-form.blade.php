<x-card>
    <x-form wire:submit="save">
        <x-input type="text" wire:model="label" label="{{ __('Title') }}" />
        <x-input type="text" wire:model="description" label="{{ __('Description') }}" />
        <x-select class="bg-{{$color}}-200" label="{{ __('Color') }}" icon="c-paint-brush" :options="$colors" wire:model="color" wire:change="$refresh" />
        <x-datepicker label="{{ __('Start Date') }}" wire:model="start_date" icon="o-calendar" :config="config('app.dateConfig')" />
        <x-datepicker label="{{ __('End Date') }}" wire:model="end_date" icon="o-calendar" :config="config('app.dateConfig')" hint="{{ __('Optional') }}" />          
        <x-slot:actions>
            <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                class="btn-primary" />
        </x-slot:actions>
    </x-form>        
</x-card>
