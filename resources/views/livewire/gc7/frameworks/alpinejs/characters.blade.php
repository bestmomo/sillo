<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Title('Characters')] #[Layout('components.layouts.gc7.main')] class extends Component {
    //
}; ?>

<div>

    @section('styles')
        <style>
            {{ file_get_contents(resource_path('views/livewire/gc7/frameworks/alpinejs/characters/styles.css')) }}
        </style>
    @endsection

    @section('scripts')
        <script src="/assets/js/characters.js"></script>
    @endsection

    <x-header class="mb-0" title="Characters" shadow separator progress-indicator></x-header>

    <div id="wrapper" x-data="characters">
        <div x-show="loading" x-transition.duration.1000ms class="spinner text-center">
            <span class="loading loading-spinner loading-lg"></span>
        </div>

        <div x-show="error" x-text="error" class="error"></div>

        <ul x-show="!loading && !error">

            <div class="flex flex-wrap justify-between gap-4">
                <template x-for="character in characters" :key="character.id">

                    <article class="characterCard_Wrapper">

                        <div class="characterCard__ImgWrapper fkUcVI">
                            <img :src="character.image" :alt="character.name" />
                        </div>

                        <div class="characterCard__ContentWrapper isMAic ml-2">
                            <div class="section">
                                <a :href="character.url" rel="noopener noreferrer" target="_blank"
                                    class="externalLink__ExternalLink-sc-1lixk38-0 ffGNdR">
                                    <h2 id="nameTitle"><span x-text="character.name">T</span></h2>
                                </a>

                                <span class="status">

                                    <span class="status__icon"
                                        :class="{
                                            'bg-red-500': character.status === 'Dead',
                                            'bg-black': character.status === 'unknown',
                                            'bg-green-400': character.status === 'Alive'
                                        }"></span>

                                    <span x-text="character.status"></span>&nbsp;-&nbsp;<span
                                        x-text="character.species"></span>
                            </div>
                            <div class="section"><span class="text-gray">Last known location:</span><a
                                    :href="character.location.url" rel="noopener noreferrer" target="_blank"
                                    class="externalLink__ExternalLink-sc-1lixk38-0 ffGNdR"><span
                                        x-text="character.location.name"></span></a>
                            </div>

                            <div x-show="character.episode1 && typeof character.episode1 !== 'undefined'"
                                class="section"><span class="text-gray">First seen in <span
                                        x-text="character.episode1 ? character.episode1.episode : ''"></span></span>
                                <a :href="character.episode[0]" rel="noopener noreferrer" target="_blank"
                                    class="externalLink__ExternalLink-sc-1lixk38-0 ffGNdR"><span
                                        x-text="character.episode1 ? character.episode1.name : ''"></span>
                                </a>
                            </div>

                        </div>

                    </article>

                </template>
            </div>

        </ul>
    </div>
</div>
