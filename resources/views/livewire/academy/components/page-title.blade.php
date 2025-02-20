<?php
use Livewire\Volt\Component;

new class extends Component {
    public $title;
};
?>
<livewire:academy.components.titles :title="$title" />
