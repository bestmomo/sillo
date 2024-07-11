<?php

use App\Models\User;

use function Livewire\Volt\{mount, state};

// state(['count' => fn() => User::count()]);
state(['count' => 0]);
$inc = fn () => $this->count++;

mount(function () {
	$this->count = User::count();
	sleep(3);
	$this->dispatch('update-subtitle', newSubtitle: 'New API Cpnt');
});

?>

<div>
    <x-header shadow separator progress-indicator />

    <div class="m-5 mt-1">
        Count : {{ $count }}<br>
        <button class='btn btn-primary mt-3' wire:click="inc">Increment !</button>
    </div>

</div>

@script
    <script>
        setInterval(() => {
            $wire.dispatch('update-subtitle', {
                newSubtitle: 'Api Component'
            });
        }, 7000);
    </script>
@endscript
