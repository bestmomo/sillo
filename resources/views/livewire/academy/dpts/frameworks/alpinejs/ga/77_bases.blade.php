<div>
    <div role="tablist" class="tabs tabs-lifted">
        <input type="radio" name="my_tab_1" role="tab" class="tab text-red-500" aria-label="Tab 1" checked />
        <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">Tab content 1</div>

        <input type="radio" name="my_tab_2" role="tab" class="tab" aria-label="Tab 2" />
        <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">Tab content 2</div>

        <input type="radio" name="my_tab_3" role="tab" class="tab" aria-label="Tab 3" />
        <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">Tab content 3</div>
    </div>

    <x-tabs wire:model="selectedTab">
    <x-tab name="users-tab">
        <x-slot:label>  
            Users
            <x-badge value="3" class="badge-primary" />
        </x-slot:label>
 
        <div>Users</div>
    </x-tab>
    <x-tab name="tricks-tab" label="Tricks">
        <div>Tricks</div>
    </x-tab>
    <x-tab name="musics-tab" label="Musics">
        <div>Musics
            <x-badge value="77" class="badge-primary" />
        </div>
    </x-tab>
</x-tabs>
    
    <button
        class="inline-block cursor-pointer rounded-md bg-gray-800 px-4 py-3 text-center text-sm font-semibold uppercase text-white transition duration-200 ease-in-out hover:bg-gray-900">
        Button
    </button>

    <span class="countdown font-mono text-6xl">
        <span style="--value:20;"></span>
    </span>

    <hr>

    <h1>Avis sur un film</h1>

    <div x-data="{ showSpoiler: false }">

        <template x-if="!showSpoiler">
            <button class='btn btn-primary' x-transition.duration.2000ms x-show="!showSpoiler"
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

        <script>
            let countdownValue = 20;
            const countdownElement = document.querySelector('.countdown span');

            const countdownInterval = setInterval(() => {
                countdownValue--;
                countdownElement.style.setProperty('--value', countdownValue);
                countdownElement.textContent = countdownValue;

                if (countdownValue <= 0) {
                    clearInterval(countdownInterval);
                }
            }, 1000);
        </script>
    </div>
