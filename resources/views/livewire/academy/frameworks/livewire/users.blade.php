<?php
use App\Models\User;
use Mary\Traits\Toast;
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Rule, Title};

new #[Title('Users'), Layout('components.layouts.academy')] class extends Component {};
?>
<div>
    {{-- <x-header title="Users" shadow separator progress-indicator/> --}}

    {{-- Source: https://www.youtube.com/watch?v=zPNdejemUtg --}}
    {{-- <livewire:academy.frameworks.livewire.components.users.users-table /> --}}
    
    <livewire:uuusers3 />
    
    {{-- @php
        echo str_repeat('<hr>', 7);
    @endphp
    <livewire:uuusers2 /> --}}
    {{-- @php
        echo str_repeat('<hr>', 7);
    @endphp
    <livewire:uuusers1 /> --}}

</div>
