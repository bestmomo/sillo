<?php

use App\Models\PostGc7;
use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

new #[Title('Blog')] #[Layout('components.layouts.gc7')] class extends Component {
    //
    public $posts;
    public function mount()
    {
        $this->posts = PostGc7::all();
    }

    public function delete(PostGc7 $post)
    {
        $post->delete();
    }
}; ?>

<div>
    <h1 class="text-center font-bold text-xl">Blog</h1>

    <h2 class="text-lg">Posts</h2>

    {{-- {{ dd($posts) }} --}}

    <table>
        <thread>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th></th>
            </tr>
        </thread>
        <tbody>
            @foreach ($posts as $post)
                <tr wire:key="{{ $post->id }}">
                    <td>{{ $post->title }}</td>
                    <td>{{ str($post->content)->words(2) }}</td>
                    <td><x-button type='button' icon="o-trash" wire:click='delete({{ $post->id }})'
                            wire:confirm="Are you sure you want to delete this post?"
                        >
                        </x-button></td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
