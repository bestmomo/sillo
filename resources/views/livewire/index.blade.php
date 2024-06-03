<?php

use Livewire\Volt\Component;
use App\Models\{Post, Category, Serie};
use App\Repositories\PostRepository;
use Illuminate\Pagination\LengthAwarePaginator;

new class extends Component {

    public string $slug;
    public Category|null $category = null;
    public Serie|null $serie = null;
    public string $param = '';
    
    public function mount($slug = '', $param = ''): void
    {
        $this->slug = $slug;

        if($slug !== '') {
            if(request()->segment(1) === 'category') {
                $this->category = Category::whereSlug($slug)->firstOrFail();
            } else {
                $this->serie = Serie::whereSlug($slug)->firstOrFail();
            }            
        }

        $this->param = $param;
    }

    public function getPosts(): LengthAwarePaginator
    {     
        $postRepository = new PostRepository;

        if($this->param !== '') {
            return $postRepository->search($this->param);
        }

        return $postRepository->getPostsPaginate($this->category, $this->serie);
    }

    public function with(): array
    {
        return [
            'posts' => $this->getPosts(),
        ];
    }

}; ?>

<div class="relative items-center grid w-full px-5 py-5 mx-auto md:px-12 max-w-7xl">

    @if($category)
        <x-header title="{{ __('Posts for category ') }}  {!! $category->title !!}" separator />
    @elseif($serie)
        <x-header title="{{ __('Posts for serie ') }} {!! $serie->title !!}" separator />
    @elseif($param !== '')
        <x-header title="{{ __('Posts for search ') }} '{!! $param !!}'" separator />
    @endif
    <div class="mb-4">{{ $posts->links() }}</div>
    <div class="grid w-full grid-cols-1 gap-6 mx-auto sm:grid-cols-2 lg:grid-cols-3 gallery">
        @foreach($posts as $post)
            <x-card 
                title="{!! $post->title !!}" >
                <div>{!! $post->excerpt !!}</div>
                <hr>
                <div class="flex justify-between">
                    <p wire:click="" class="text-left" style="cursor: pointer;">{{ $post->user->name }}</p>
                    <p class="text-right"><em>{{ $post->created_at->isoFormat('LL') }}</em></p>
                </div>
                <x-slot:figure>
                    <a href="{{ url('/posts/' . $post->slug) }}">
                        <img src="{{ asset('storage/photos/' . $post->image) }}" />
                    </a>
                </x-slot:figure>
                <x-slot:actions>
                    <x-button label="{{ $post->category->title }}" link="{{ url('/category/' . $post->category->slug) }}" class="btn-outline btn-sm" />
                    @if($post->serie)
                        <x-button label="{{ $post->serie->title }}" link="{{ url('/serie/' . $post->serie->slug) }}" class="btn-outline btn-sm" />
                    @endif
                    <x-button label="{{ __('Read') }}" link="{{ url('/posts/' . $post->slug) }}" class="btn-outline btn-sm" />
                </x-slot:actions>
            </x-card>
        @endforeach
    </div>
    <div class="mb-4">{{ $posts->links() }}</div>
</div>
