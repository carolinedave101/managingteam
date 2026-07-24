<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('giveaways', function (Blueprint $table) {
            $table->foreignId('fan_id')->nullable()->after('celebrity_id')
                ->constrained('users')->nullOnDelete();
            $table->index('fan_id');
        });
    }

    public function down(): void
    {
        Schema::table('giveaways', function (Blueprint $table) {
            $table->dropForeign(['fan_id']);
            $table->dropIndex(['fan_id']);
            $table->dropColumn('fan_id');
        });
    }
};
