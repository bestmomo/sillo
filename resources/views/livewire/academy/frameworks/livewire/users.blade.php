<?php
use App\Models\User;
use Mary\Traits\Toast;
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Rule, Title};

new 
#[Title('Users'), Layout('components.layouts.academy')] 
class extends Component {};
?>
<div>
    <x-header title="Users" shadow separator progress-indicator/>
    
    <livewire:academy.frameworks.livewire.components.users.users-table />

</div>
