<div>
    <h2>New Textarea Helper pour the post # {{ $postId }} - Annuler ({{ $cancelBtn }}): {{ $cancelBtn ? '111': '000' }}</h2>
    <hr>
    type: {{ gettype($cancelBtn) }}
    
    <hr>
    
    <x-card title="{{ __($title) }}" shadow="hidden">
        <x-form wire:submit="createComment" class="mb-4">
            <x-textarea label="" wire:model="message"
                placeholder="{{ $placeholder ? __($placeholder) . '...' : '' }}" hint="{{ __('Max 1000 chars') }}"
                rows="1" inline />
            {{-- ci-dessus 5 --}}
            <x-slot:actions>
                @if ($cancelBtn)
                    <!-- Bouton pour annuler la réponse -->
                    <x-button label="{{ __('Cancel') }}" wire:click="toggleAnswerForm(false)" class="btn-ghost" />
                @endif
                <!-- Bouton pour sauvegarder la réponse -->
                <x-button label="{{ __('Save') }}" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
