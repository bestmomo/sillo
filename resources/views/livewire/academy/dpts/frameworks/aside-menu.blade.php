@php

    $frameworksLinks = getAcademyFrameworksLinks();

    function affLink($link)
    {
        return $link != 'create-post' ? $link : 'new-post';
    }

@endphp

<nav class="flex-col ml-2 border-r border-gray-500">

    <div class="mt-5 w-[99px] mb-6">

        <div
            class="mt-4 ml-0 mr-1 py-1 pl-2 pr-3 text-base font-bold text-left rounded {{ request()->is('academy') ? 'bg-gray-700 text-green-500' : '' }}">
            <a href="/academy">ACADEMY</a>
        </div>
        <div class="mt-4 ml-0 pt-1 px-1 text-xs text-left rounded mr-3
{{ request()->is('academy/frameworks') ? 'bg-gray-700 text-green-500' : '' }}">

            <a href="/academy/frameworks">FRAMEWORKS</a>
        </div>
        <div class='x-auto w-full text-center mb-4 pr-3 font-bold'><small><a href="/t">Tests</a></small></div>

        @foreach ($frameworksLinks as $framework => $links)
                        <div class="{{ $loop->index ? 'mt-4' : '' }}">{{ strtoupper($framework) }}</div>
                        <hr>
                        @foreach ($links as $link)
                                            <div class="my-1">
                                                <a href="/academy/framework/{{ $framework }}/{{ $link }}"
                                                    class="py-1 px-2 rounded my-3 pl-2
                            {{ request()->is('academy/framework/' . $framework . '/' . $link) ? 'bg-gray-700 text-green-400' : '' }}">{{ ucfirst(str_replace('-', ' ', affLink($link))) }}</a>

                                            </div>
                        @endforeach
        @endforeach

    </div>
</nav>
