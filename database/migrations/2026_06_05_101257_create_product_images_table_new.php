<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Only create product_images table, NOT products
        if (!Schema::hasTable('product_images')) {
            Schema::create('product_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
                $table->foreignId('file_id')->constrained('files')->onDelete('cascade');
                $table->integer('sort_order')->default(0);
                $table->boolean('is_primary')->default(false);
                $table->string('alt_text')->nullable();
                $table->timestamps();
                
                $table->index(['product_id', 'sort_order']);
                $table->index(['product_id', 'is_primary']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};