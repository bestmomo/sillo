<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new
#[Title('Pets')]
#[Layout('components.layouts.academy')]
class extends Component {
	// https://learnwebcode.github.io/json-example/pets-data.json
}; ?>

<div>
    <script src="/assets/js/helpers.js"></script>
    @section('styles')
        <style>
            {{ file_get_contents(resource_path('views/livewire/academy/frameworks/alpinejs/pets/styles.css')) }}
        </style>
    @endsection

    <x-header title="Pets" shadow separator progress-indicator></x-header>

    <div x-data="{
        pets: [],
        loadedYet: false,
        ucfirst: window.ucFirst,
        affLog: function() {
            console.log('OK! Ready for Pets.')
        }
    }" x-init="affLog(), { pets } = await (await fetch('https://learnwebcode.github.io/json-example/pets-data.json')).json(), loadedYet = true" />

    <template x-if="!pets.length && loadedYet">
        <p>Whoops, you have no pets.</p>
    </template>

    <template x-for="(pet, index) in pets">
        <div class="all-pets flex flex-column mx-auto max-w-[700px] justify-center mt-5">

            <div class="pet-card card bg-base-100 mb-3 max-y-[100] overflow-hidden  justify-center"
                x-data="{ showAge: false }">
                <div class="flex">

                    {{-- PHOTO --}}
                    <img class="pet-image w-[45%] object-cover" :src="pet.photo" alt="animal">

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
                        <div class="card-actions flex flex-col">

                            <p>
                                {{-- AGE --}}
                                <button class="cool-button btn btn-primary btn-xs" x-on:click="showAge =!showAge">Toggle
                                    Age
                                </button>
                                <span x-show="showAge" x-transition.duration.700ms x-text="pet.birthYear"></span>
                            </p>

                            <p>
                                {{-- DELETE --}}
                                <button class="delete-pet btn btn-error btn-xs"
                                    x-on:click="pets=pets.filter(
                                    (pet, loopedIndex) => loopedIndex !== index
                                    ),
                                    console.log('Imagine we also send an API request to an url to delete', pet.name)
                                    ">Delete Pet</button>
                            </p>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </template>
</div>
