@php
    $linkos = ['blog', 'create-Post', 'todos', 'counter', 'alpine', 'new-form', 'test'];

    $frameworksLinks = getGc7FrameworksLinks();

    function affLink($link)
    {
        return $link != 'create-post' ? $link : 'new-post';
    }

@endphp
<div>
    <nav class="flex-col ml-2 border-r border-gray-500">

        <div class="mt-7 w-[99px]">
            
            <div
                class="my-4 ml-0 py-1 px-1 text-xs text-left rounded mr-3 {{ request()->is('frameworks') ? 'bg-gray-700 text-white' : '' }}">
                <a href="/frameworks">FRAMEWORKS</a></div>
            
            @foreach ($frameworksLinks as $framework => $links)
                <div class="{{ $loop->index ? 'mt-4' : '' }}">{{ strtoupper($framework) }}</div>
                <hr>
                @foreach ($links as $link)
                    <div class="my-2">
                        <a href="/framework/{{ $framework }}/{{ $link }}"
                            class="py-1 px-2 rounded my-5 
                            {{ request()->is('framework/' . $framework . '/' . $link) ? 'bg-gray-700 text-white' : '' }}">{{ ucfirst(str_replace('-', ' ', affLink($link))) }}</a>
                    </div>
                @endforeach
            @endforeach

        </div>
    </nav>
</div>
