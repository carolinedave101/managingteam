<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('celebrity_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('celebrity_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // stripe, bank_transfer, paypal, cryptocurrency
            $table->string('label'); // display name
            $table->boolean('enabled')->default(true);
            $table->json('details')->nullable(); // account details, wallet addresses, api keys
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['celebrity_id', 'enabled']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('celebrity_payment_methods');
    }
};
