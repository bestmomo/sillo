<?php

use Mary\Traits\Toast;
use App\Models\PostGc7;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

new #[Title('Blog')] #[Layout('components.layouts.gc7')] class extends Component {
    use WithPagination;
    use Toast;

    protected $listeners = ['refreshPosts'];

    public function delete(PostGc7 $post)
    {
        $postId = $post->id;
        $post->delete();
        $this->info("Post # {$postId} deleted");
        $this->dispatch('refreshPosts');
    }
    public function render(): mixed
    {
        return view('livewire.gc7.abc.livewire.blog', [
            'posts' => PostGc7::paginate(10),
        ]);
    }
}; ?>

<div>
    <h1 class="text-center font-bold text-xl">Blog</h1>

    <h2 class="text-lg">Posts</h2>
    
    {{-- {{ dd($posts, $posts->withQueryString() )}} --}}

    <div class="mb-4">
        {{ $posts->links() }}
        {{-- {{ $posts->links('livewire.vendor.pagination.custom-pagination-links') }} --}}
    </div>

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
                    <td>
                        <a href='/t/post/edit'>
                            <x-button type='button' icon="s-pencil" wire:click='edit({{ $post->id }})' />

                        </a>
                        <x-button type='button' icon="o-trash" wire:click='delete({{ $post->id }})'
                            wire:confirm="Are you sure you want to delete this post # {{ $post->id }} ?
                    
Title:  {{ str($post->title)->words(3) }}" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="my-4">
        {{ $posts->links() }}
    </div>

</div>
