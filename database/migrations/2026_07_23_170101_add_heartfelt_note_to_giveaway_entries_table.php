<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('giveaway_entries', function (Blueprint $table) {
            $table->text('heartfelt_note')->nullable()->after('payment_proof');
        });
    }

    public function down(): void
    {
        Schema::table('giveaway_entries', function (Blueprint $table) {
            $table->dropColumn('heartfelt_note');
        });
    }
};
