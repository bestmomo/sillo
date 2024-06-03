<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{ User, Contact, Post, Comment, Page };
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Users
        // Create 1 admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);
        // Create 2 redactors
        User::factory()->count(2)->create([
            'role' => 'redac',
        ]);
        // Create 3 users
        User::factory()->count(3)->create();

        $nbrUsers = 6;

        // Categories
        DB::table('categories')->insert([
            [
                'title' => 'Category 1',
                'slug' => Str::of('Category 1')->slug('-'),
            ],
            [
                'title' => 'Category 2',
                'slug' => Str::of('Category 2')->slug('-'),
            ],
            [
                'title' => 'Category 3',
                'slug' => Str::of('Category 3')->slug('-'),
            ],
        ]);

        $nbrCategories = 3;

        // Series
        DB::table('series')->insert([
            [
                'title' => 'Serie 1',
                'slug' => Str::of('Serie 1')->slug('-'),
                'category_id' => 1,
                'user_id' => 1,
            ],
            [
                'title' => 'Serie 2',
                'slug' => Str::of('Serie 2')->slug('-'),
                'category_id' => 1,
                'user_id' => 1,
            ],
        ]);

        $nbrSeries = 2;

        $this->createPost(1, 1, 1);
        $this->createPost(2, rand (1, $nbrCategories));
        $this->createPost(3, 1, 1, 1);
        $this->createPost(4, 1, 1, 3);
        $this->createPost(5, rand (1, $nbrCategories));
        $this->createPost(6, 1, 2);
        $this->createPost(7, 1, 2, 6);
        $this->createPost(8, rand (1, $nbrCategories));
        $this->createPost(9, rand (1, $nbrCategories));

        $nbrPosts = 9;

        // Comments
        foreach (range(1, $nbrPosts - 1) as $i) {
            $this->createComment($i, rand(1, $nbrUsers));
        }

        $comment = $this->createComment(2, 3);
        $this->createComment(2, 4, $comment->id);

        $comment = $this->createComment(2, 6);
        $this->createComment(2, 3, $comment->id);

        $comment = $this->createComment(2, 6, $comment->id);

        $comment = $this->createComment(2, 3, $comment->id);
        $this->createComment(2, 6, $comment->id);

        $comment = $this->createComment(4, 4);

        $comment = $this->createComment(4, 5, $comment->id);
        $this->createComment(4, 2, $comment->id);
        $this->createComment(4, 1, $comment->id);

        // Contacts
        Contact::factory()->count(5)->create();

        // Pages
        $items = [
            ['about-us', 'About us'],
            ['terms', 'Terms'],
            ['faq', 'FAQ'],
            ['privacy-policy', 'Privacy Policy'],
        ];

        foreach($items as $item) {
            Page::factory()->create([
                'slug' => $item[0],
                'title' => $item[1],
            ]);
        }

        // Menus
        DB::table('menus')->insert([
            ['label' => 'Categorie 1', 'link' => null, 'order' => 3],
            ['label' => 'Categorie 2', 'link' => '/category/category-2', 'order' => 2],
            ['label' => 'Categorie3', 'link' => '/category/category-3', 'order' => 1],
        ]);

        // Sous-menus
        DB::table('submenus')->insert([
            ['label' => 'Série 1', 'order' => 1, 'link' => '/serie/serie-1', 'menu_id' => 1],
            ['label' => 'Série 2', 'order' => 2, 'link' => '/serie/serie-2', 'menu_id' => 1],
            ['label' => 'Tout', 'order' => 2, 'link' => '/category/category-1', 'menu_id' => 1],
        ]);

        // Footer
        DB::table('footers')->insert([
            ['label' => 'Terms', 'order' => 3, 'link' => 'terms'],
            ['label' => 'Faq', 'order' => 2, 'link' => 'faq'],
            ['label' => 'Accueil', 'order' => 1, 'link' => '/'],
        ]);
    }

    protected function createPost($id, $category_id, $serie_id = null, $parent_id = null)
    {
        return Post::factory()->create([
            'title' => 'Post ' . $id,
            'slug' => Str::of('Post ' . $id)->slug('-'),
            'user_id' => rand(1, 2),
            'image' => '2024/03/img0' . $id . '.jpg',
            'category_id' => $category_id,
            'serie_id' => $serie_id,
            'parent_id' => $parent_id,
        ]);
    }   

    protected function createComment($post_id, $user_id, $id = null)
    {
        return Comment::factory()->create([
            'post_id' => $post_id,
            'user_id' => $user_id,
            'parent_id' => $id,
        ]);
    }
}
