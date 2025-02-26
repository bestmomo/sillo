<?php
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new
#[Layout('components.layouts.academy')]
class extends Component
{
};
?>

<div class='mx-6'>
    <livewire:academy.dpts.frameworks.livewire.components.users.users-table />
    
    {{-- @php
        echo str_repeat('<hr>', 7);
    @endphp --}}

</div>
