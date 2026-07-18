<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawal_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('celebrity_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // bank, cashapp, paypal, cryptocurrency
            $table->string('label');
            $table->json('details');
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'celebrity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawal_accounts');
    }
};
