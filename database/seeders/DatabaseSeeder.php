<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Category::create([
        //     'name' => 'Web Site',
        //     'slug' => 'web-site'
        // ]);

        // Post::create([
        //     'title' => 'Article 1',
        //     'author_id' => 1,
        //     'category_id' => 1,
        //     'slug' => 'article-1',
        //     'body' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
        // ]);

        // Call the seeders for the User and Category tables first
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
        ]);

        // Create a new article 
        Post::factory(10)->recycle([
            Category::all(),
            User::all(),
        ])->create();
    }
}
