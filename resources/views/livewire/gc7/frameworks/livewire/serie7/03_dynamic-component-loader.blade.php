<?php
use Livewire\Volt\Component;

class DynamicComponentLoader extends Component
{
    public $component = '';

    public function setComponent($value)
    {
        $this->component = "gc7.frameworks.livewire.serie7.{$value}";
    }

} ?>

<div>
    @if ($componentName)
        @livewire($componentName)
    @endif

</div>
