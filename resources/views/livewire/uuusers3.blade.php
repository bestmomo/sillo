<div>

    <style>
        .t3>thead>tr>th {
            background-color: #000;
            color: greenyellow;
        }
    </style>

    <x-header title="Uuusers3 - MaryUI" shadow separator progress-indicator />

    @include('components.partials.academy.helpers.input')

    {{-- You can use any `$wire.METHOD` on `@row-click` --}}
    <x-table :headers="$headers" :rows="$users" :sort-by="$sortBy" striped link="/admin/users/{id}/edit" with-pagination>

        @scope('cell_name', $user)
            <span class="font-bold">
                {{ $user->name }} {{ $user->firstname }}
            </span><br>
            {{ $user->email }}
        @endscope

        @scope('cell_role', $user)
            @if ($user->role === 'admin')
                <x-badge value="{{ __('Administrator') }}" class="badge-error" />
            @elseif($user->role === 'redac')
                <x-badge value="{{ __('Redactor') }}" class="badge-warning" />
            @elseif($user->role === 'user')
                {{ __('User') }}
            @endif
        @endscope

        @php

            $this->roles = [
                'admin' => 'Administrator',
                'redac' => 'Redactor',
                'user' => 'User',
            ];

        @endphp

        @scope('cell_isStudent', $user)
            @if ($user->isStudent)
                <span
                    title="{{ trans_choice(':n is registered with the Academy', 'n', ['n' => $user->name]) }}
@if (!$user->valid) {{ __('But invalid status') }} @endif">

                    <x-icon name="o-academic-cap" :class="$user->valid ? 'text-cyan-500' : 'text-red-500'" style="width: 28px; height: 28px;" />
                </span>
            @else
                <span
                    title="{{ trans_choice(':n is a :r not student', ['n', 'm'], ['n' => $user->name, 'r' => strtolower(__($this->roles[$user->role]))]) }}
{{ __('Not registered with the Academy') }}">
                    <x-icon name="o-user" class="w-7 h-7 text-gray-400" />
                </span>
            @endif
        @endscope

        @scope('cell_valid', $user)
            @if ($user->valid)
                <x-icon-check />
            @else
                <x-icon-novalid />
            @endif
        @endscope

    </x-table>

    <br>

</div>
