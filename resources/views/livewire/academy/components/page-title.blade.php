<?php
use Livewire\Volt\Component;
//2do voire si simplifiable (pas de php ?)2
new class () extends Component {
  public $title;
};
?>
<div>
	<x-header class="pb-0 mb-[-14px] font-new text-green-400" title="{!! $title !!}" shadow separator progress-indicator/>
</div>

