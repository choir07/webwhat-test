<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('products') && !Schema::hasColumn('products', 'image_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedBigInteger('image_id')->nullable()->after('category_id');
                $table->foreign('image_id')->references('id')->on('files')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['image_id']);
                $table->dropColumn('image_id');
            });
        }
    }
};