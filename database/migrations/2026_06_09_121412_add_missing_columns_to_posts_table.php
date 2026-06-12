<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if posts table exists
        if (Schema::hasTable('posts')) {
            
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('posts', 'published_at')) {
                Schema::table('posts', function (Blueprint $table) {
                    $table->timestamp('published_at')->nullable()->after('status');
                });
            }
            
            if (!Schema::hasColumn('posts', 'meta_title')) {
                Schema::table('posts', function (Blueprint $table) {
                    $table->string('meta_title')->nullable()->after('published_at');
                });
            }
            
            if (!Schema::hasColumn('posts', 'meta_description')) {
                Schema::table('posts', function (Blueprint $table) {
                    $table->text('meta_description')->nullable()->after('meta_title');
                });
            }
            
            if (!Schema::hasColumn('posts', 'meta_keywords')) {
                Schema::table('posts', function (Blueprint $table) {
                    $table->string('meta_keywords')->nullable()->after('meta_description');
                });
            }
            
            if (!Schema::hasColumn('posts', 'views')) {
                Schema::table('posts', function (Blueprint $table) {
                    $table->integer('views')->default(0)->after('meta_keywords');
                });
            }
            
            if (!Schema::hasColumn('posts', 'is_featured')) {
                Schema::table('posts', function (Blueprint $table) {
                    $table->boolean('is_featured')->default(false)->after('views');
                });
            }
            
            if (!Schema::hasColumn('posts', 'allow_comments')) {
                Schema::table('posts', function (Blueprint $table) {
                    $table->boolean('allow_comments')->default(true)->after('is_featured');
                });
            }
            
            if (!Schema::hasColumn('posts', 'excerpt')) {
                Schema::table('posts', function (Blueprint $table) {
                    $table->text('excerpt')->nullable()->after('slug');
                });
            }
            
            if (!Schema::hasColumn('posts', 'featured_image_id')) {
                Schema::table('posts', function (Blueprint $table) {
                    $table->foreignId('featured_image_id')->nullable()->after('author_id');
                    $table->foreign('featured_image_id')->references('id')->on('files')->onDelete('set null');
                });
            }
        }
    }

    public function down(): void
    {
        
    }
};