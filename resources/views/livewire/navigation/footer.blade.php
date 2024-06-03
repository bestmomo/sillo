<?php

use Livewire\Volt\Component;
use App\Models\Footer;

new class extends Component 
{
    public function with(): array
    {
        return [
            'footers' => Footer::orderBy('order')->get(),
        ];
    }

}; ?>

<footer class="flex justify-center gap-x-2 text-gray-500">
    @foreach ($footers as $footer)
        <a href="{{ $footer->link }}" class="hover:text-gray-500 mr-2">
            @lang($footer->label)
        </a>        
    @endforeach
    <a href="{{ route('contact') }}" class="hover:text-gray-500 mr-2">
        @lang('Contact')
    </a>    
    <div>© 2024 - Bestmomo</div>     
</footer>

