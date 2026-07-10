<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('files', function (Blueprint $table) {
            if (!Schema::hasColumn('files', 'cloudinary_url')) {
                $table->string('cloudinary_url')->nullable()->after('description');
            }
            if (!Schema::hasColumn('files', 'cloudinary_public_id')) {
                $table->string('cloudinary_public_id')->nullable()->after('cloudinary_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            //
        });
    }
};
