<div>

@section('styles')
    <style>
        {{ file_get_contents(resource_path('views\\livewire\\gc7\\frameworks\\alpinejs\\ga\\02_css.css')) }}
    </style>
@endsection

    <div role="tablist" class="tabs tabs-lifted">
        <a role="tab" class="tab tab-active hover:text-white">Tab 1</a>
        <a role="tab" class="tab myBtnEffect">Tab 2</a>
        <a role="tab" class="tab hover:text-white">Tab 3</a>
        <a role="tab"
            class="tab tab-active [--tab-bg:black] [--tab-border-color:white] text-orange-500 bold glass
        hover:bg-orange-500
        hover:text-white
        
        transition duration-500 ease-in-out">Tab
            4</a>

    </div>





    <hr>

    <h1>Avis sur un film</h1>

    <div x-data="{ showSpoiler: false }">

        <template x-if="!showSpoiler">
            <button
                class='btn btn-outline btn-block
            text-orange-500 hover:bg-orange-500 hover:text-black glass
            transition duration-[500ms] ease-in-out
            
            '
                x-on:click="showSpoiler = true">

                Show Spoiler</button>
            ' x-transition.duration.2000ms x-show="!showSpoiler"
            x-on:click="showSpoiler = true">Show Spoiler</button>
        </template>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur suscipit repellendus ipsam dicta, ipsum
            illo culpa deleniti laborum!</p>

        <p>Porro iste nihil cum assumenda blanditiis molestias voluptates voluptate dignissimos explicabo ab
            repudiandae?</p>

        <template x-if="showSpoiler">
            <p><strong>Ce paragraphe spoile le film...</strong> Porro vitae hic est
                tenetur ipsa ab a unde. Commodi sequi
                eum quasi quisquam quas aperiam!</p>
        </template>

    </div>
