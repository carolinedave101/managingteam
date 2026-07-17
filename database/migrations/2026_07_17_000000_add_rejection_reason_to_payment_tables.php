<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fan_applications', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable()->after('notes');
        });

        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable()->after('status');
        });

        Schema::table('meet_greet_tickets', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable()->after('status');
        });

        Schema::table('private_meetups', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable()->after('status');
        });

        Schema::table('memberships', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable()->after('is_active');
        });

        Schema::table('membership_cards', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('fan_applications', fn (Blueprint $table) => $table->dropColumn('rejection_reason'));
        Schema::table('wallet_transactions', fn (Blueprint $table) => $table->dropColumn('rejection_reason'));
        Schema::table('meet_greet_tickets', fn (Blueprint $table) => $table->dropColumn('rejection_reason'));
        Schema::table('private_meetups', fn (Blueprint $table) => $table->dropColumn('rejection_reason'));
        Schema::table('memberships', fn (Blueprint $table) => $table->dropColumn('rejection_reason'));
        Schema::table('membership_cards', fn (Blueprint $table) => $table->dropColumn('rejection_reason'));
    }
};
