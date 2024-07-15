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
        Schema::table('users', function (Blueprint $table) {
            $table->string('diet_restrictions')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('discord_username')->nullable();
            $table->string('facebook_username')->nullable();
            $table->text('biography')->nullable();
            $table->string('trigger_warnings')->nullable();
            $table->string('pronouns')->nullable();
            $table->string('allergies')->nullable();
            $table->string('medical_conditions')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone_number')->nullable();
            $table->string('red_flag_people')->nullable();
            $table->string('first_aid_qualifications')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('diet_restrictions');
            $table->dropColumn('phone_number');
            $table->dropColumn('discord_username');
            $table->dropColumn('facebook_username');
            $table->dropColumn('biography');
            $table->dropColumn('trigger_warnings');
            $table->dropColumn('pronouns');
            $table->dropColumn('allergies');
            $table->dropColumn('medical_conditions');
            $table->dropColumn('emergency_contact_name');
            $table->dropColumn('emergency_contact_phone_number');
            $table->dropColumn('red_flag_people');
            $table->dropColumn('first_aid_qualifications');
        });
    }
};
