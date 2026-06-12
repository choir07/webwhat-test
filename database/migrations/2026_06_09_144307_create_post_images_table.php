<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('post_images')) {
            Schema::create('post_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('post_id')->constrained()->onDelete('cascade');
                $table->foreignId('file_id')->constrained()->onDelete('cascade');
                $table->integer('sort_order')->default(0);
                $table->string('caption')->nullable();
                $table->timestamps();
                
                $table->index(['post_id', 'sort_order']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('post_images');
    }
};