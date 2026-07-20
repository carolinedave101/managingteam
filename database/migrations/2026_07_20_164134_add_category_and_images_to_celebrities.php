<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('celebrities', function (Blueprint $table) {
            $table->string('category', 50)->default('general')->after('bio');
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::table('celebrities', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropColumn('category');
        });
    }
};
