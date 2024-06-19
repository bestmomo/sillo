<?php
include_once 'pets.php';
?>

<div>
    @section('styles')
        <style>
            {{ file_get_contents(resource_path('views/livewire/gc7/frameworks/alpinejs/pets/styles.css')) }}
        </style>
    @endsection

    <div class="all-pets flex flex-column mx-auto max-w-[700px] justify-center mt-5">
        <div class="pet-card card card-side bg-base-100 mb-3 max-y-[100] overflow-hidden h-[200px]">
            <div class="flex">
                {{-- <figure class="pet-image"> --}}
                <img class="w-[300px] object-cover" src="https://learnwebcode.github.io/json-example/images/dog-1.jpg"
                    alt="dog1">
                {{-- </figure> --}}
                <div class="pet-text card-body w-[400px] pt-5">
                    <h2 class="card-title">NAME Here</h2>
                    <p class="my-0 py-0" class="specie">Species: Dog</p>
                    <p class="food my-0 py-0">Favorite food: Carrots, celery, fish</p>
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
    </div>

    <div class="all-pets flex flex-column mx-auto max-w-[700px] justify-center mt-5">
        <div class="pet-card card card-side bg-base-100 mb-3 max-y-[100] overflow-hidden h-[200px]">
            <div class="flex">
                {{-- <figure class="pet-image"> --}}
                <img class="w-[300px] object-cover" src="https://learnwebcode.github.io/json-example/images/dog-1.jpg"
                    alt="dog1">
                {{-- </figure> --}}
                <div class="pet-text card-body w-[400px] pt-5">
                    <h2 class="card-title">NAME Here</h2>
                    <p class="my-0 py-0" class="specie">Species: Dog</p>
                    <p class="food my-0 py-0">Favorite food: Carrots, celery, fish</p>
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
    </div>

    <div class="all-pets flex flex-column mx-auto max-w-[700px] justify-center mt-5">
        <div class="pet-card card card-side bg-base-100 mb-3 max-y-[100] overflow-hidden h-[200px]">
            <div class="flex">
                {{-- <figure class="pet-image"> --}}
                <img class="w-[300px] object-cover" src="https://learnwebcode.github.io/json-example/images/dog-1.jpg"
                    alt="dog1">
                {{-- </figure> --}}
                <div class="pet-text card-body w-[400px] pt-5">
                    <h2 class="card-title">NAME Here</h2>
                    <p class="my-0 py-0" class="specie">Species: Dog</p>
                    <p class="food my-0 py-0">Favorite food: Carrots, celery, fish</p>
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
    </div>


</div>
