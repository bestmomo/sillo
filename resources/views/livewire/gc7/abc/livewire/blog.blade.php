<?php

use App\Models\Post;
use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

new #[Title('Blog')] #[Layout('components.layouts.gc7')] class extends Component {
    //
    public $posts;
    public function mount()
    {
        $this->posts = Post::all();
    }

    function shortenText($text, $words_count = 5)
    {
        return implode(' ', array_slice(explode(' ', $text), 0, $words_count));
    }
}; ?>

<div>
    <h1 class="text-center font-bold text-xl">Blog</h1>

    <h2 class="text-lg">Posts</h2>

    {{-- {{ dd($posts) }} --}}

    <table>
        <thread>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Content</th>
            </tr>
        </thread>
        <tbody>
            @foreach ($posts as $post)
            
                <tr wire:key="{{ $post->id }}">
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ str($post->body)->words(5) }}</td>
                </tr>
                
            @endforeach
        </tbody>
    </table>

</div>
