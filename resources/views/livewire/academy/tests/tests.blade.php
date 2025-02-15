<?php

use Barryvdh\Debugbar\Facades\Debugbar;
include_once 'tests.php'; ?>

@section('title', __('Test'))
<div class="container mx-auto">

    <x-header title="{{ __('Tests') }}" separator progress-indicator>
        <x-slot:actions>
            {{-- <x-input placeholder="{{ __('Search...') }}" wire:model.live.debounce.300ms="search" clearable
                icon="o-magnifying-glass" /> --}}
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    @if (!Str::startsWith(config('app.locale'), 'fr'))
        <x-card separator class="my-3 -mt-3 bg-error text-center text-xl text-white font-bold shadow-xl">
            ⚠️ Please note that this section is exclusively in French. The refined and adopted versions, however, will be
            multi-language and online 🙂 !
        </x-card>
    @endif

    <x-card separator class="mb-6 border-2 shadow-xl">

        {{-- @foreach ($subjects as $subject)

            <x-list-item :item="$subject" value="title"> <x-slot:avatar>
                    {{ Debugbar::info($subject) }}
                    <x-badge value="{{ ucfirst(strtolower($subject['state'])) }}"
                        class="text-black badge-{{ $subject['stateColor'] }}" />
                </x-slot:avatar> <x-slot:sub-value class='truncable-none overflow-visible'> {{ $subject['description'] }}
                    <hr class="my-3">
                    <p class="text-lg font-bold">Situation actuelle :</p>
                    <a href="{{ route($subject['actual'][1]) }}" class="link">
                        {{ $subject['actual'][0] }}
                    </a>
                    <p class="text-lg font-bold mt-3">Situation proposée :</p>
                    @foreach($subject['proposed'] as $proposed)
                        <p class=" link my-1">
                            <a href="{{ route($proposed[1]) }}">
                                {{  $proposed[0] }}
                            </a>
                        </p>

                    @endforeach

                </x-slot:sub-value>

            </x-list-item>

        @endforeach --}}

    </x-card>

</div>
