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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 99);
            $table->unsignedBigInteger('number');
            $table->string('street', 99);
            $table->string('city_name', 99);
            $table->string('zip_code', 5);
            $table->string('bis', 99)->nullable();
            $table->string('addon', 99)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
