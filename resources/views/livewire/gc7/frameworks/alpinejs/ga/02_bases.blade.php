<div>

    @section('styles')
        <style>
            {{ file_get_contents(resource_path('views\\livewire\\gc7\\frameworks\\alpinejs\\ga\\02_css.css')) }}
        </style>
    @endsection

    <div role="tablist" class="tabs tabs-lifted">
        <a role="tab" class="tab tab-active hover:text-white">Tab 1</a>
        <a role="tab" class="tab">Tab 2</a>
        <a role="tab" class="tab hover:text-white">Tab 3</a>
        <a role="tab"
            class="tab tab-active [--tab-bg:black] [--tab-border-color:white] text-orange-500 bold glass hover:bg-orange-500 hover:text-white transition duration-500 ease-in-out">Tab4</a>
    </div>

</div>
