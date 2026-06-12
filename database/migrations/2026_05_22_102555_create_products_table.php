<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('sku')->unique();
            $table->string('status')->default('draft');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            
            $table->index('sku');
            $table->index('status');
            $table->index('price');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
