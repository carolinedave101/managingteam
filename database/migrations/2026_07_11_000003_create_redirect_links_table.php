<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('redirect_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('celebrity_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code')->unique();
            $table->string('target_url');
            $table->unsignedBigInteger('clicks')->default(0);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('redirect_links');
    }
};
