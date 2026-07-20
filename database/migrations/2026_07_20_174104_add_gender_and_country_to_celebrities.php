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
        Schema::table('celebrities', function (Blueprint $table) {
            $table->string('gender', 10)->nullable()->after('category');
            $table->string('country', 100)->nullable()->after('gender');
        });
    }

    public function down(): void
    {
        Schema::table('celebrities', function (Blueprint $table) {
            $table->dropColumn(['gender', 'country']);
        });
    }
};
