<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('celebrity_id')->constrained()->cascadeOnDelete();
            $table->string('subject');
            $table->longText('body');
            $table->string('status')->default('draft');
            $table->integer('total_recipients')->default(0);
            $table->integer('sent_count')->default(0);
            $table->integer('failed_count')->default(0);
            $table->integer('hourly_limit')->default(50);
            $table->integer('hourly_sent_count')->default(0);
            $table->timestamp('hourly_sent_reset_at')->nullable();
            $table->integer('daily_limit')->default(1000);
            $table->integer('daily_sent_count')->default(0);
            $table->timestamp('daily_sent_reset_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_campaigns');
    }
};