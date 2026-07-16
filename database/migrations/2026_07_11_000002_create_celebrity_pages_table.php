<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('celebrity_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('celebrity_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->longText('content')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['celebrity_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('celebrity_pages');
    }
};
