<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('files')) {
            Schema::create('files', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('original_name');
                $table->string('path');
                $table->string('type')->nullable();
                $table->string('mime_type');
                $table->integer('size');
                $table->string('collection')->default('general');
                $table->text('description')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->timestamps();
                
                $table->index('collection');
                $table->index('user_id');
            });
            
            echo "Files table created successfully!\n";
        } else {
            echo "Files table already exists.\n";
        }
    }
    
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};