<?php

namespace App\Repositories;

use App\Models\{ Post, Category, Serie };
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository
{
    public function getPosts()
    {
        return Post::select(
                    'id',
                    'slug',
                    'image',
                    'title',
                    'excerpt',
                    'user_id',
                    'category_id',
                    'serie_id',
                    'created_at')
                ->with('user:id,name','category','serie')
                ->whereActive(true)
                ->latest();
    }
    public function getPostsPaginate(Category|null $category, Serie|null $serie): LengthAwarePaginator
    {
        $query = $this->getPosts();

        if($category) {
            $query->whereBelongsTo($category);  
        } 
    
        if($serie) {
            $query->whereBelongsTo($serie)->oldest();  
        }             

        return $query->paginate(config('app.pagination'));
    }

    public function getPostBySlug(string $slug): Post
    {
        $post = Post::with(
                    'user:id,name',
                    'category',
                    'serie'
                )
                ->withCount('validComments')
                ->whereSlug($slug)
                ->firstOrFail();

        if($post->serie_id) {
            $post->previous = $post->parent_id ? Post::findOrFail($post->parent_id) : null;
            $post->next = Post::whereParentId($post->id)->first() ?: null;
        }
        
        return $post;
    }

    public function search($search)
    {
        return $this->getPosts()
                    ->where(function ($q) use ($search) {
                        $q->where('excerpt', 'like', "%$search%")
                        ->orWhere('body', 'like', "%$search%")
                        ->orWhere('title', 'like', "%$search%");
                    })->paginate(config('app.pagination'));
    }

    // Méthode pour générer un slug unique
    public function generateUniqueSlug($slug): string
    {
        $newSlug = $slug;
        $counter = 1;
        while (Post::where('slug', $newSlug)->exists()) {
            $newSlug = $slug . '-' . $counter;
            $counter++;
        }
        return $newSlug;
    }
}