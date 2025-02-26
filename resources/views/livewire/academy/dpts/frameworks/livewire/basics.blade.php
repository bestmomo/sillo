<?php
include_once 'basics.php';
?>

<div class='mx-6'>
    {{-- <livewire:academy.components.page-title title='Bases de Livewire'/> --}}
    <livewire:academy.components.page-title title='Bases de Livewire' />
    <x-header shadow separator progress-indicator />

    <h1>Simples exemples</h1>

    {{-- <livewire:academy.dpts.frameworks.livewire.hello-world/> //2fix ← Err 500 on real server is certainly here --}}
    {{-- //2fix LW / Blog: Faire pour réel SIMU des deletes --}}
    {{-- //2fix LW / New Post Err 500 --}}
    {{-- //2fix LW / NesForm: En réel, pas de calcul des caractères --}}
    {{-- //2fix ALPINE / GA: Err 500 --}}
    {{-- //2fix: ALPINE / Chats : Le point de menu n'est pas sensé apparaître en réel --}}

    <livewire:academy.dpts.frameworks.livewire.counter />

    <div class="my-6">
        <livewire:academy.dpts.frameworks.livewire.Todos />
    </div>

</div>
