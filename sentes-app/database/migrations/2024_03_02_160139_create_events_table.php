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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 99);
            $table->string('description', 99);
            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->unsignedBigInteger('max_attendees')->default(1);
            $table->string('image_path')->nullable();
            $table->unsignedBigInteger('price')->nullable();
            $table->boolean('is_cancelled')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
