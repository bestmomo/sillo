<?php
include_once 'pets.php';
// https://learnwebcode.github.io/json-example/pets-data.json
?>
<div>
    <script src="/assets/js/helpers.js"></script>
    @section('styles')
        <style>
            {{ file_get_contents(resource_path('views/livewire/gc7/frameworks/alpinejs/pets/styles.css')) }}
        </style>
    @endsection


    <div x-data="{
        pets: [],
        affLog: function() {
            console.log('OK! Ready.')
        },
        ucfirst: window.ucFirst
    }" x-init="{ pets } = await (await fetch('https://learnwebcode.github.io/json-example/pets-data.json')).json();
    affLog()">

        <template class="all-pets flex flex-column mx-auto max-w-[700px] justify-center mt-5"
            x-for="(pet, index) in pets">

            <div class="pet-card card bg-base-100 mb-3 max-y-[100] overflow-hidden h-[200px] justify-center">
                <div class="flex">

                    <img class="pet-image w-[40%] object-cover" :src="pet.photo" alt="animal">

                    <div class="pet-text card-body w-full sm:w-[400px] pt-5">

                        {{-- NAME --}}
                        <div class="card-title"><strong x-text="pet.name"></strong></div>

                        {{-- SPECIES --}}
                        <p class="specie my-0 py-0 text-xs sm:text-base"><span x-text="pet.species"></span></p>

                        {{-- FOOD --}}
                        <template x-if="pet.favFoods">
                            <p class="food my-0 py-0 text-xs sm:text-base overflow-auto  whitespace-normal">Favorite
                                foods:
                                <span x-html="ucfirst(pet.favFoods.join(', '))"></span>
                            </p>
                        </template>

                        {{-- ACTION --}}
                        <div class="card-actions">
                            <p>
                                <button class="cool-button btn btn-primary btn-xs">Toggle Age
                                </button>
                            </p>
                            <p>
                                <button class="btn btn-error delete-pet btn-xs">Delete Pet
                                </button>
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </template>

    </div>
</div>
