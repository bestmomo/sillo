<?php
use Livewire\Volt\Component;

new class extends Component {
    public $title;
    public function mount()
    {
        $this->title = mb_convert_case($this->title, MB_CASE_UPPER);
    }
};
?>
<livewire:academy.components.titles :title=$title :dpt=true />
