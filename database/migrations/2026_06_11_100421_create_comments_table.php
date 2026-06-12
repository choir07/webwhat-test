<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('post_id')->constrained()->onDelete('cascade');
                $table->string('author_name');
                $table->string('author_email');
                $table->text('content');
                $table->boolean('is_approved')->default(true); // Auto-approve for now
                $table->timestamps();
                
                $table->index(['post_id', 'is_approved']);
                $table->index('created_at');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
