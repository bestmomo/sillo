<?php
use Livewire\Volt\Component;

new class extends Component {
    public $title='Titre Indéfini';
    public $dpt;
    public $font='new';
    
    public function mount()
    {
        $this->font= $this->dpt  ? 'shadow':'new';
        // Debugbar::info($this->font);
    }
}; 

// {{-- <x-header class="pb-0 mb-[-14px] mt-2 font-{{ $font }} text-green-400" title="{!! $title !!}" /> --}}

?>

<div>
    @section('title', $title)
    {{-- <x-header class="pb-0 mb-[-14px] mt-2 font-{{ $font }} text-green-400" title="{!! $title !!}" /> --}}
    <div class="flex justify-between">
        <p class="pb-0 mb-[-14px] mt-2 font-{{ $font }} text-green-400 text-3xl tracking-wider font-semibold">{!! $title !!}</p>
        <p>{{ config('app.version') }}</p>
    </div>
    
</div>
