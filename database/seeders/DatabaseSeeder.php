<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(AdminUserSeeder::class);    
    
    // 1. Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'email_verified_at' => now()
            ]
        );
        echo " Admin user created\n";

        // 2. Create categories
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology'],
            ['name' => 'Lifestyle', 'slug' => 'lifestyle'],
            ['name' => 'Development', 'slug' => 'development'],
        ];
        
        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name']]
            );
        }
        echo " Categories created\n";

        // 3. Create sample posts
        if (Post::count() == 0) {
            $posts = [
                [
                    'title' => 'Welcome to The Powerful Posts',
                    'slug' => 'welcome-to-the-powerful-posts',
                    'content' => '<h1>Welcome!</h1><p>This is your first post on The Powerful Posts blog. Start creating amazing content!</p>',
                    'status' => 'published',
                    'author_id' => $admin->id,
                    'published_at' => now(),
                    'views' => 100,
                    'category_id' => Category::where('slug', 'technology')->first()?->id
                ],
                [
                    'title' => 'Getting Started with Laravel',
                    'slug' => 'getting-started-with-laravel',
                    'content' => '<h2>Laravel is Amazing</h2><p>Learn how to build powerful web applications with Laravel.</p>',
                    'status' => 'published',
                    'author_id' => $admin->id,
                    'published_at' => now(),
                    'views' => 75,
                    'category_id' => Category::where('slug', 'development')->first()?->id
                ],
                [
                    'title' => 'Dark Mode is Here!',
                    'slug' => 'dark-mode-is-here',
                    'content' => '<h2>Dark Mode Support</h2><p>Toggle between light and dark themes easily.</p>',
                    'status' => 'published',
                    'author_id' => $admin->id,
                    'published_at' => now(),
                    'views' => 50,
                    'category_id' => Category::where('slug', 'lifestyle')->first()?->id
                ]
            ];

            foreach ($posts as $post) {
                Post::create($post);
            }
            echo " " . count($posts) . " sample posts created\n";
        }

        // 4. Create sample comment
        if (Comment::count() == 0 && Post::count() > 0) {
            $post = Post::first();
            if ($post) {
                Comment::create([
                    'post_id' => $post->id,
                    'author_name' => 'John Doe',
                    'author_email' => 'john@example.com',
                    'content' => 'Great post! Very informative.',
                    'is_approved' => true,
                ]);
                echo " Sample comment created\n";
            }
        }

        echo " Seeding complete!\n";
    }
}