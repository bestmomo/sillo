<?php

use Livewire\Volt\Component;
use App\Models\{ Comment, Post };
use App\Repositories\PostRepository;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Attributes\Rule;

new class extends Component {

    public Post $post;
    public Post|null $next;
    public Post|null $previous;
    public Collection $comments;
    public bool $listComments = false;
    public int $commentsCount;

    #[Rule('required|max:1000')]
    public string $message = '';
    
    // Initialise le composant avec le post spécifié.
    public function mount($slug): void
    {
        $postRepository = new PostRepository;

        $this->post = $postRepository->getPostBySlug($slug);
        $this->fill( 
            $this->post->only('next', 'previous'), 
        ); 
        $this->commentsCount = $this->post->valid_comments_count;
        $this->comments = new Collection();
    }

    // Méthode pour cloner un article
    public function clonePost(int $postId): void
    {
        $originalPost = Post::findOrFail($postId);
        $clonedPost = $originalPost->replicate();
        $postRepository = new PostRepository;
        $clonedPost->slug = $postRepository->generateUniqueSlug($originalPost->slug);
        $clonedPost->active = false;
        $clonedPost->save();

        redirect()->route('posts.edit', $clonedPost->slug);
    }

    // Montre les commentaires associés au post.
    public function showComments(): void
    {
        $this->listComments = true;

        $this->comments = $this->post->validComments()
                            ->with(['user' => function ($query) {
                                $query->select('id', 'name', 'email', 'role')->withCount('comments');
                            }])
                            ->latest()
                            ->get();
    }

}; ?>

<div>
    <div class="flex justify-end gap-4">
        @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->id == $post->user_id))
            <x-button icon="c-pencil-square" link="{{ route('posts.edit', $post) }}" tooltip-left="{{ __('Edit') }}" spinner class="btn-ghost btn-sm" />
            <x-button icon="o-finger-print" wire:click="clonePost({{ $post->id }})" tooltip-left="{{ __('Clone') }}" spinner class="btn-ghost btn-sm" />
        @endif   
        <x-button class="btn-sm"><a href="{{ url('/category/' . $post->category->slug) }}">{{ $post->category->title }}</a></x-button>
        @if($post->serie)
            <x-button class="btn-sm"><a href="{{ url('/serie/' . $post->serie->slug) }}">{{ $post->serie->title }}</a></x-button>
        @endif        
    </div>
    <x-header title="{!! $post->title !!}" subtitle="{{ $post->created_at->isoFormat('LL') }} "  />
    <div class="relative items-center w-full px-5 py-5 mx-auto md:px-12 max-w-7xl">
        <div class="flex flex-col items-center mb-4">
            <img src="{{ asset('storage/photos/' . $post->image) }}" />
        </div>
        <br>
        {!! $post->body !!}
    </div>
    <br><hr>

    <div class="flex justify-between">
        <p>@lang('By ') {{ $post->user->name }}</p>
        <em>
            @if($this->commentsCount != 0) 
                @lang('Number of comments: ') {{ $this->commentsCount }}
            @else
                @lang('No comments')
            @endif
        </em>
    </div>

    @if($post->serie)
        <br>
        <div class="{{ $previous ? 'flex justify-between' : 'flex justify-end' }}">
            @if($previous)
                <x-button label="{{ __('Previous') }}" icon="s-arrow-left" link="{{ url('/posts/' . $previous->slug) }}" class="btn-sm" />
            @endif
            @if($next)
                <x-button label="{{ __('Next') }}" icon-right="s-arrow-right" link="{{ url('/posts/' . $next->slug) }}" class="btn-sm" />
            @endif
        </div>        
    @endif

    <div class="relative items-center w-full px-5 py-5 mx-auto md:px-12 max-w-7xl">
        @if($this->listComments)
            <x-card title="{{ __('Comments') }}" shadow separator >
                @foreach ($comments as $comment)
                    @if(!$comment->parent_id)
                        <livewire:posts.comment :$comment :$comments :depth="0" :key="$comment->id" />
                    @endif
                @endforeach
                @if(Auth::check())
                    <livewire:posts.commentBase :postId="$this->post->id" />
                @endif
            </x-card>
        @else
            @if($this->commentsCount > 0)
                <div class="flex justify-center">            
                    <x-button label="{{ $this->commentsCount > 1 ? __('View comments') : __('View comment') }}" wire:click="showComments" class="btn-outline" />
                </div>
            @else
                @if(Auth::check())
                    <livewire:posts.commentBase :postId="$this->post->id" />
                @endif
            @endif            
        @endif
    </div>
    
</div>
