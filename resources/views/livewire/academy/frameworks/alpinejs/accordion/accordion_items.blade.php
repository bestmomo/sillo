<?php

use Livewire\Volt\Component;

new class() extends Component {
	public $items;
};

?>
<div>

    <div class="join join-vertical w-full">

        @foreach ($items as $item)
            <div class="collapse collapse-arrow join-item border border-base-300">
                <input type="radio" name="my-accordion-4" checked="checked" />
                <div class="collapse-title text-xl font-medium">
                    {{ $item[0] }}
                </div>
                <div class="collapse-content">
                    <p>{{ $item[1] }}</p>
                </div>
            </div>
        @endforeach
    </div>

</div>
