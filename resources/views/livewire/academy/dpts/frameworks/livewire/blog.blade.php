<?php

use App\Models\AcademyPost;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

new
#[Layout('components.layouts.academy')] 
class extends Component
{
	use WithPagination;
	use Toast;

	protected $listeners = ['refreshPosts'];

	public function delete(AcademyPost $post)
	{
		$postId = $post->id;
		$post->delete();
		$this->info("Article n° {$postId} effacé !");
		$this->dispatch('refreshPosts');
	}

	public function render(): mixed
	{
		return view('livewire.academy.dpts.frameworks.livewire.blog', [
			'posts' => AcademyPost::orderBy('id', 'desc')->paginate(10),
		]);
	}
}; ?>

<div class='mx-6'>
    <livewire:academy.components.page-title title='Articles' />
    <x-header shadow separator progress-indicator />
    
    <h2 class="mb-2 text-xl">{{ $posts->count() }} article{{ $posts->count() > 1 ? 's' : '' }} / {{ $posts->total() }}</h2>

    {{-- {{ dd($posts, $posts->withQueryString() )}} --}}

    @if ($posts->count())
        <div class="mb-4">
            {{ $posts->links() }}
            {{-- {{ $posts->links('livewire.vendor.pagination.custom-pagination-links') }} --}}
        </div>

        <table>
            <thread>
                <tr>
                    <th>Titre</th>
                    <th>Contenu</th>
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
                                <x-button type='button' icon="s-pencil"
                                {{-- wire:click='edit({{ $post->id }})'  --}}
                                disabled/>
                            </a>
                            <x-button type='button' icon="o-trash" wire:click='delete({{ $post->id }})'
                                wire:confirm="Êtes-vous sûr de vouloir efacer l'article n°{{ $post->id }} ?
                    
Titre:  {{ str($post->title)->words(3) }}" />
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
