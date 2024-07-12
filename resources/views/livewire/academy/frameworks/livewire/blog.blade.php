<?php

use App\Models\AcademyPost;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

new #[Title('Blog')] #[Layout('components.layouts.academy')] class extends Component {
	use WithPagination;
	use Toast;

	protected $listeners = ['refreshPosts'];

	public function delete(AcademyPost $post)
	{
		$postId = $post->id;
		$post->delete();
		$this->info("Post # {$postId} deleted !");
		$this->dispatch('refreshPosts');
	}

	public function render(): mixed
	{
		// 2do cf. possibilité de ne pas utiliser le render (sert pour delete())
		return view('livewire.academy.frameworks.livewire.blog', [
			'posts' => AcademyPost::orderBy('id', 'desc')->paginate(10),
		]);
	}
}; ?>

<div>
    <x-header title="Blog" shadow separator progress-indicator>
    </x-header>
    <h2 class="mb-2 text-xl">{{ $posts->count() }} Post{{ $posts->count() > 1 ? 's' : '' }} / {{ $posts->total() }}</h2>

    {{-- {{ dd($posts, $posts->withQueryString() )}} --}}

    @if ($posts->count())
        <div class="mb-4">
            {{ $posts->links() }}
            {{-- {{ $posts->links('livewire.vendor.pagination.custom-pagination-links') }} --}}
        </div>

        <table>
            <thread>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th class='text-center' style='max-width:100px!important;'>Actions</th>
                </tr>
            </thread>
            <tbody>
                @foreach ($posts as $post)
                    <tr wire:key="{{ $post->id }}">
                        <td>{{ $post->title }}</td>
                        <td>{{ str($post->content)->words(2) }}</td>
                        <td class='p-0 text-center' style='max-width:100px!important;'>
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
    @endif
    <div class="my-4">
        {{ $posts->links() }}
    </div>

</div>
