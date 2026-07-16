<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('celebrities', function (Blueprint $table) {
            $table->index('is_active');
        });

        Schema::table('meet_greet_events', function (Blueprint $table) {
            $table->index('celebrity_id');
            $table->index('is_active');
            $table->index('date');
        });

        Schema::table('meet_greet_tickets', function (Blueprint $table) {
            $table->index('celebrity_id');
            $table->index('event_id');
            $table->index('status');
        });

        Schema::table('memberships', function (Blueprint $table) {
            $table->index('celebrity_id');
            $table->index('user_id');
            $table->index('is_active');
        });

        Schema::table('membership_cards', function (Blueprint $table) {
            $table->index('celebrity_id');
            $table->index('is_active');
        });

        Schema::table('private_meetups', function (Blueprint $table) {
            $table->index('celebrity_id');
            $table->index('user_id');
            $table->index('status');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->index('celebrity_id');
            $table->index('sender_id');
            $table->index('receiver_id');
            $table->index('parent_id');
            $table->index('is_read');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index('celebrity_id');
            $table->index('user_id');
            $table->index('status');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
        });

        Schema::table('fan_applications', function (Blueprint $table) {
            $table->index('celebrity_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('celebrities', fn (Blueprint $t) => $t->dropIndex(['is_active']));

        Schema::table('meet_greet_events', fn (Blueprint $t) => $t->dropIndex(['celebrity_id', 'is_active', 'date']));
        Schema::table('meet_greet_tickets', fn (Blueprint $t) => $t->dropIndex(['celebrity_id', 'event_id', 'status']));
        Schema::table('memberships', fn (Blueprint $t) => $t->dropIndex(['celebrity_id', 'user_id', 'is_active']));
        Schema::table('membership_cards', fn (Blueprint $t) => $t->dropIndex(['celebrity_id', 'is_active']));
        Schema::table('private_meetups', fn (Blueprint $t) => $t->dropIndex(['celebrity_id', 'user_id', 'status']));
        Schema::table('messages', fn (Blueprint $t) => $t->dropIndex(['celebrity_id', 'sender_id', 'receiver_id', 'parent_id', 'is_read']));
        Schema::table('orders', fn (Blueprint $t) => $t->dropIndex(['celebrity_id', 'user_id', 'status']));
        Schema::table('users', fn (Blueprint $t) => $t->dropIndex(['role']));
        Schema::table('fan_applications', fn (Blueprint $t) => $t->dropIndex(['celebrity_id', 'status']));
    }
};
