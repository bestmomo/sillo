@if ($showForm)
    <x-card title="{{ $formTitle }}" shadow="hidden" class="!p-0">
        <x-form wire:submit="{{ $formAction }}" class="mb-4">
            <x-textarea wire:model="message" hint="{{ __('Max 10000 chars') }}" rows="5" inline />
            <x-slot:actions>
                @if ($formAction === 'updateComment')
                    <x-button label="{{ __('Cancel') }}" wire:click="toggleModifyForm(false)"
                        class="btn-ghost" spinner />
                @endif
                <x-button label="{{ __('Save') }}" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
@else
    <div class="mb-4">{!! $message !!}</div>
@endif
