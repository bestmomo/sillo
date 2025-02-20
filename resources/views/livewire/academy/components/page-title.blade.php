<?php
use Livewire\Volt\Component;

new class extends Component {
    public $title;
};
?>
<div>
    <livewire:academy.components.titles :title="$title" :dpt=false />
</div>
