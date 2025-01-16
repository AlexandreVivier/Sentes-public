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
        Schema::table('contents', function (Blueprint $table) {
            $table->boolean('is_public')->default(true);
            $table->unsignedBigInteger('number_of_selections')->default(1);
            $table->unsignedBigInteger('max_selections')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn('is_public');
            $table->dropColumn('number_of_selections');
            $table->dropColumn('max_selections');
        });
    }
};
