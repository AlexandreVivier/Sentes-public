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
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->text('description');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('community_list_id')->constrained('community_lists')->onDelete('cascade');
            $table->string('individual')->nullable();
            $table->string('group')->nullable();
            $table->string('perspectives')->nullable();
            $table->text('highlights')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communities');
    }
};
