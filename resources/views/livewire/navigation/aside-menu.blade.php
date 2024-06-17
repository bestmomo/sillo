@php
    $links = ['blog', 'todos', 'counter'];
@endphp

<nav class="flex-col ml-3 border-r border-gray-500">
    <div class="mt-7 w-[90px]">

        @foreach ($links as $link)
            <div class="my-5">
                <a href="/t/{{ $link }}" :class="{ 'current': true }"
                    class="py-1 px-2 rounded my-5 {{ request()->is('t/' . $link) ? 'bg-gray-700 text-white' : '' }}">{{ ucfirst($link) }}</a>
            </div>
        @endforeach

    </div>
</nav>
