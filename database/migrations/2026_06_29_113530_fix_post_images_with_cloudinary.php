<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        // Demo Cloudinary image URL
        $demoImage = 'https://res.cloudinary.com/dgk1pwiet/image/upload/f_auto,q_auto/v1782701866/xdrmhrzaszv64jf9x1jt.jpg';
        
        // Update all posts without images
        $posts = Post::whereNull('featured_image')->orWhere('featured_image', '')->get();
        
        foreach ($posts as $index => $post) {
            $post->featured_image = 'https://picsum.photos/seed/' . ($index + 1) . '/800/400';
            $post->save();
        }
        
        echo " Fixed " . $posts->count() . " posts!\n";
    }

    public function down()
    {
        // Nothing to rollback
    }
};