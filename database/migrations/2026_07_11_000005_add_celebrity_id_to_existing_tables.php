<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fan_applications', function (Blueprint $table) {
            $table->foreignId('celebrity_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('memberships', function (Blueprint $table) {
            $table->foreignId('celebrity_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('meet_greet_events', function (Blueprint $table) {
            $table->foreignId('celebrity_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('meet_greet_tickets', function (Blueprint $table) {
            $table->foreignId('celebrity_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('membership_cards', function (Blueprint $table) {
            $table->foreignId('celebrity_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('private_meetups', function (Blueprint $table) {
            $table->foreignId('celebrity_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->foreignId('celebrity_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('messages')->nullOnDelete();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('celebrity_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('fan_applications', fn (Blueprint $t) => $t->dropForeign(['celebrity_id'])->dropColumn('celebrity_id'));
        Schema::table('memberships', fn (Blueprint $t) => $t->dropForeign(['celebrity_id'])->dropColumn('celebrity_id'));
        Schema::table('meet_greet_events', fn (Blueprint $t) => $t->dropForeign(['celebrity_id'])->dropColumn('celebrity_id'));
        Schema::table('meet_greet_tickets', fn (Blueprint $t) => $t->dropForeign(['celebrity_id'])->dropColumn('celebrity_id'));
        Schema::table('membership_cards', fn (Blueprint $t) => $t->dropForeign(['celebrity_id'])->dropColumn('celebrity_id'));
        Schema::table('private_meetups', fn (Blueprint $t) => $t->dropForeign(['celebrity_id'])->dropColumn('celebrity_id'));
        Schema::table('messages', function (Blueprint $t) {
            $t->dropForeign(['celebrity_id']);
            $t->dropColumn('celebrity_id');
            $t->dropForeign(['parent_id']);
            $t->dropColumn('parent_id');
        });
        Schema::table('orders', fn (Blueprint $t) => $t->dropForeign(['celebrity_id'])->dropColumn('celebrity_id'));
    }
};
