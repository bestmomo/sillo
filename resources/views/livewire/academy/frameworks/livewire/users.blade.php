<?php
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new #[Title('Users'), Layout('components.layouts.academy')] class extends Component {
};
?>
<div>
    {{-- <x-header title="Users" shadow separator progress-indicator/> --}}
        
    <livewire:academy.frameworks.livewire.components.users.users-table />
    
    {{-- @php
        echo str_repeat('<hr>', 7);
    @endphp --}}

</div>
