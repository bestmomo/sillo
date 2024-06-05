<?php

use Livewire\Volt\Component;
use App\Models\Page;

new class extends Component {

    public Page $page;
  
    public function mount($slug): void
    {
        $this->page = Page::where('slug', $slug)->firstOrFail();
    }

}; ?>

<div>
    <x-header title="{!! $page->title !!}" />
    <div class="relative items-center w-full px-5 py-5 mx-auto prose md:px-12 max-w-7xl">
        {!! $page->body !!}
    </div>  
</div>
