<div>
    
    <h1>Avis sur un film</h1>
    <div x-data="{ showSpoiler: false }">

        <x-button class='btn-primary' x-on:click="showSpoiler = !showSpoiler">Toggle Spoiler</x-button>

        <button class='btn btn-primary ml-2' x-transition.duration.2000ms x-show="!showSpoiler"
            x-on:click="showSpoiler = true">Show Spoiler</button>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur suscipit repellendus ipsam dicta, ipsum
            illo culpa deleniti laborum!</p>

        <p>Porro iste nihil cum assumenda blanditiis molestias voluptates voluptate dignissimos explicabo ab
            repudiandae?</p>

        <p><strong>Ce paragraphe spoile le film...</strong> Porro vitae hic est
            tenetur ipsa ab a unde. Commodi sequi
            eum quasi quisquam quas aperiam!</p>
            
    </div>
</div>
