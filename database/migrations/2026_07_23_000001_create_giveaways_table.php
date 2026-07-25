<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('giveaways', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('celebrity_id');
            $table->index('celebrity_id');
            $table->string('title');
            $table->text('description');
            $table->text('prize_description');
            $table->decimal('prize_amount', 10, 2)->default(0);
            $table->string('prize_image_url')->nullable();
            $table->decimal('entry_fee', 10, 2)->default(0);
            $table->integer('winner_count')->default(1);
            $table->integer('max_entries_per_fan')->default(1);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->string('status')->default('draft');
            $table->boolean('is_active')->default(true);
            $table->json('config')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('giveaways');
    }
};
