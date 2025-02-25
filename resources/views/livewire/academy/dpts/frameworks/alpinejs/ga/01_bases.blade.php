<div>

    <h1>Avis sur un film</h1>

    <div x-data="{ showSpoiler: false }">

        <span @click.window="if (showSpoiler) showSpoiler = false"></span>

        <x-button class='btn-primary w-[150px] text-white glass' x-on:click.stop="showSpoiler = !showSpoiler"><span
                x-text="!showSpoiler ? 'Montrer le spoiler':'Cacher le spoiler'"></span></x-button>

        <button class='btn btn-primary ml-2 text-white glass' x-transition.duration.2000ms x-show="!showSpoiler"
            @click="showSpoiler = true">Afficher le spoiler (No .stop)</button>
            
        <button class='btn btn-primary ml-2 text-white glass' x-transition.duration.2000ms x-show="!showSpoiler"
            @click.stop="showSpoiler = true">Avec</button>

        <div class="text-justify">

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur suscipit repellendus ipsam dicta,
                ipsum
                illo culpa deleniti laborum!</p>

            <p>Porro iste nihil cum assumenda blanditiis molestias voluptates voluptate dignissimos explicabo ab
                repudiandae?</p>

            <p x-cloak x-transition.duration.2000ms x-show="showSpoiler"><strong>V 1: Ce paragraphe spoile le
                    film...</strong> Porro vitae hic est tenetur ipsa ab a unde. Commodi sequi eum quasi quisquam quas
                aperiam!</p>

            <template  x-if="showSpoiler">
                <p><strong>V 2: Ce paragraphe spoile le film...</strong> Porro vitae hic est tenetur ipsa ab a unde.
                    Commodi
                    sequi eum quasi quisquam quas aperiam!</p>
            </template>

        </div>

        <button
            class='btn btn-outline btn-block text-orange-500 hover:bg-orange-500 hover:text-black glass transition duration-[500ms] ease-in-out'
            x-on:click.stop="showSpoiler = true" x-transition.duration.2000ms x-show="!showSpoiler">Show
            Spoiler</button>

    </div>

</div>
