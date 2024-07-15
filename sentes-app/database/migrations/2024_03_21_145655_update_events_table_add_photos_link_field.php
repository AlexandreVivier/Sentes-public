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
        Schema::table('events', function (Blueprint $table) {
            $table->string('photos_link')->nullable();
            $table->string('retex_form_link')->nullable();
            $table->string('retex_document_path')->nullable();
            $table->string('video_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('photos_link');
            $table->dropColumn('retex_form_link');
            $table->dropColumn('retex_document_path');
            $table->dropColumn('video_link');
        });
    }
};
