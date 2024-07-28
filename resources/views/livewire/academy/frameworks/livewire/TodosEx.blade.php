<?php

use Livewire\Volt\Component;

new class() extends Component {
	public $todosEx = [];
	public $todos   = ['Take out trash', 'Do dishes'];
}; ?>

<div>
    <h2>Todos</h2>

    <ul>
        @forelse ($todos as $key=>$todo)
            <li wire:key="{{ $key }}">- {{ $todo }}</-li>
            @empty
            <li>&nbsp;&nbsp;&nbsp;Nothing to do.</li>
        @endforelse
        </-ul>

        <br><br>

        <h2>TodosEx</h2>
        <ul>
            @forelse ($todosEx as $todo)
                <li>- {{ $todo }}</li>
            @empty
                <li class="ml-3">Nothing yet to do.</li>
            @endforelse
        </ul>
</div>
