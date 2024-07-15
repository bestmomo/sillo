    <div class="field mb-5">
        <x-input 
            type="text" 
            placeholder="{{ __('Search...') }}" icon="o-magnifying-glass"
            wire:model.live.debounce.300ms="search" 
            :clearable="!empty($this->search)"
             x-init="$nextTick(() => $el.focus())"
            autofocus
        />
    </div>
