<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new #[Title('Characters')] #[Layout('components.layouts.academy')] class extends Component {
}; ?>

<div>

    @section('styles')
        <style>
            {{ file_get_contents(resource_path('views/livewire/academy/frameworks/alpinejs/characters/styles.css')) }}
        </style>
    @endsection

    @section('scripts')
        <script src="/assets/js/characters/main.js"></script>
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

                        <div class="characterCard__ImgWrapper fkUcVI cursor-pointer">
                            <img :src="character.image" :alt="character.name" @click="handleClick(character)"
                                :title="getTooltipText(character)" />
                        </div>

                        <div class="characterCard__ContentWrapper isMAic leading-2 ml-2 mt-3">
                            <div class="section leading-none">
                                <a :href="character.url" rel="noopener noreferrer" target="_blank"
                                    class="externalLink__ExternalLink-sc-1lixk38-0 ffGNdR">
                                    <h2 id="nameTitle"><span x-text="character.name">T</span></h2>
                                </a>

                                <div class="status mt-1">

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


                <!-- *************** -->
                <!--     SIDEBAR     -->
                <!-- *************** -->
                <div x-cloak x-show="isOpen"
                    class="fixed h-screen w-[60%] md:w-1/2 max-w-3/5 bg-beige top-0 right-0 z-30 p-16 flex flex-col items-start gap-10 shadow-2xl"
                    x-transition:enter="transition ease-gentle duration-700" x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-gentle duration-700"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">

                    <button
                        class="font-regular text-neutral-800 flex gap-1 items-center py-1 px-2 rounded-full border w-[90px] justify-center"
                        @click="isOpen=false">
                        <svg whidth="16" height="16" viewbow="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">

                            <path d="M12.5 3.5L3.5 12.5" stroke="#805120" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M12.5 12.5L3.5 3.5" stroke="#805120" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>

                        Close
                    </button>
                    <div class="flex items-center gap-10">
                        <div class="w-50 h-50 rounded-3xl overflow-hidden flex-schrink-0">
                            <img :src="currentCharacter.image" alt="" class="w-full h-full object-cover">
                        </div>

                        <div class="text-3xl text-base-300 font-semibold leading-none px-2 pb-2"
                            x-text="currentCharacter.name"></div>
                    </div>
                    <div class = "text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque impedit
                        quidem autem atque. Ullam voluptates, eos molestiae molestias ab dolorem ratione distinctio
                        numquam, eligendi voluptatibus sapiente porro odio ipsum eaque.</div>
                </div>

                <!-- *************** -->
                <!--     OVERLAY     -->
                <!-- *************** -->
                <div x-cloak x-show="isOpen" class="w-screen h-screen z-20 bg-base-200 opacity-40 fixed inset-0"
                    @click="isOpen = false" x-transition:enter="transition ease-in-out duration-[1000ms]"
                    x-transition:enter-start="opacity-0 scale-0" x-transition:enter-end="opacity-40 scale-100"
                    x-transition:leave="transition ease-in-out duration-500"
                    x-transition:leave-start="opacity-40 scale-100" x-transition:leave-end="opacity-0 scale-0">
                </div>

            </div>
        </ul>
    </div>
</div>
