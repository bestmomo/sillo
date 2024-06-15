<div>

    <div class="flex items-center">
        <x-input type="text" class="my-2" wire:model="todo"></x-input>
        <x-button class="btn-primary ml-3" type="button" wire:click='add'>Add</x-button>

    </div>
    
    <h2>Simple Todos</h2>

    <ul>
        @foreach ($todos as $todo)
            <li>- {{ $todo }}</li>
            <li wire:key="{{ $loop->index }}>- {{ $todo }}</li>
        @endforeach
    </ul>
</div>
