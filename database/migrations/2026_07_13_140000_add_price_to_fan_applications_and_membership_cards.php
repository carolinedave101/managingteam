<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fan_applications', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->after('status');
        });

        Schema::table('membership_cards', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->after('tier');
        });
    }

    public function down(): void
    {
        Schema::table('fan_applications', function (Blueprint $table) {
            $table->dropColumn('price');
        });

        Schema::table('membership_cards', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
