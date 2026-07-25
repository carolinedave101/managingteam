<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('giveaway_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('giveaway_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('celebrity_id');
            $table->index('giveaway_id');
            $table->index('user_id');
            $table->index('celebrity_id');
            $table->integer('entry_number');
            $table->string('status')->default('entered');
            $table->boolean('prize_credited')->default(false);
            $table->string('payment_method')->nullable();
            $table->string('payment_proof')->nullable();
            $table->string('stripe_payment_id')->nullable();
            $table->timestamp('claimed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('giveaway_entries');
    }
};
