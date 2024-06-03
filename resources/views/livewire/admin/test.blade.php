<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new 
#[Layout('components.layouts.admin')]
class extends Component {

    public $text;

    public function with(): array
    {
        return [
            'config' => [
                'language' => 'fr_FR',
                'plugins' => 'codesample',
                'toolbar' => 'undo redo style | fontfamily fontsize | alignleft aligncenter alignright alignjustify | bullist numlist | copy cut paste pastetext | hr | codesample | link quickimage quicktable',
                'toolbar_sticky' => true,
                'min_height' => 1500,
                'license_key' => 'gpl',
            ],
        ];
    }

}; ?>

<div>
    <form action="" method="get">
        <x-editor 
            wire:model="text" 
            :config="$config" 
            label="Description" 
            hint="The full product description" />
    </form>
</div>
