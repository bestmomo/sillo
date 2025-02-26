<?php include_once 'cases.php'; ?>

<div class="container mx-auto">
    <livewire:academy.components.dpt-title title='Tous les Cas' />
    <x-header shadow separator progress-indicator />

        @foreach ($subjects as $subject)
            <x-list-item :item="$subject" value="title" class='border rounded-xl'>
                <x-slot:avatar>
                    {{-- {{ Debugbar::info($subject) }} --}}
                    <x-badge value="{{ ucfirst(strtolower($subject['state'])) }}"
                        class="text-black badge-{{ $subject['stateColor'] }}" />
                </x-slot:avatar>
                <x-slot:sub-value class='truncable-none overflow-visible'> {!! $subject['description'] !!}
                    <hr class="my-3">
                    <p class="text-lg font-bold">Situation actuelle :</p>
                    <a href="{{ route($subject['actual'][1]) }}" class="link">
                        {{ $subject['actual'][0] }}
                    </a>
                    <p class="text-lg font-bold mt-3">Situation proposée :</p>
                    @foreach ($subject['proposed'] as $proposed)
                        <p class=" link my-1">
                            <a href="{{ route($proposed[1]) }}">
                                {{ $proposed[0] }}
                            </a>
                        </p>
                    @endforeach
                </x-slot:sub-value>
            </x-list-item>
            @if (!$loop->last)
                <p class='my-1 text-yellow-900 text-center text-sm leading-none'>o O o</p>
            @endif
        @endforeach
</div>
