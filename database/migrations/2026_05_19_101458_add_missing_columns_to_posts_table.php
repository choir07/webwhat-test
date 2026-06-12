<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Check if column doesn't exist before adding (prevents errors)
            if (!Schema::hasColumn('posts', 'title')) {
                $table->string('title')->after('id');
            }
            
            if (!Schema::hasColumn('posts', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
            
            if (!Schema::hasColumn('posts', 'status')) {
                $table->string('status')->default('draft')->after('description');
            }
            
            if (!Schema::hasColumn('posts', 'priority')) {
                $table->string('priority')->default('medium')->after('status');
            }
            
            if (!Schema::hasColumn('posts', 'category_id')) {
                $table->foreignId('category_id')->constrained()->cascadeOnDelete()->after('priority');
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'title', 
                'description', 
                'status', 
                'priority', 
                'category_id'
            ]);
        });
    }
};