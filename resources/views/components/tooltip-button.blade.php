<div class="tooltip-container">
    <span class="tooltip">
        <x-button
            class= "{{ $class }}" 
            icon = "{{ $icon }}"
            wire:click="{{ $action }}"
            @if ($confirm) wire:confirm="{{ $confirm }}" @endif 
            spinner
        />
        <span class="tooltiptext">{{ $tooltip }}</span>
    </span>
</div>
