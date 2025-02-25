<?php
use Livewire\Volt\Component;

new class extends Component {
    public $test;
    public function mount()
    {
        $this->test = ucfirst($this->test);
    }
};
?>

<div>
    <p class="text-right">Nom du test : <b>{{ $test ?? 'no' }}</b></p>
    Ready for another next test...
</div>
