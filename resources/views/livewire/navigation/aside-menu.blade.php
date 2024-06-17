@php
    $links = ['blog', 'create-Post', 'todos', 'counter', 'alpine'];
@endphp

<nav class="flex-col ml-3 border-r border-gray-500">
    <div class="mt-7 w-[90px]">

        @foreach ($links as $link)
            <div class="my-5">
                <a href="/t/{{ strtolower($link) }}" :class="{ 'current': true }"
                    class="py-1 px-2 rounded my-5 {{ request()->is('t/' . strtolower($link)) ? 'bg-gray-700 text-white' : '' }}">{{ ucfirst(str_replace('-', ' ',$link)) }}</a>
            </div>
        @endforeach

    </div>
</nav>
