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
        Schema::create('blynk_data', function (Blueprint $table) {
            $table->id();
            $table->string('suhu')->nullable();
            $table->string('humidity')->nullable();
            $table->string('soil')->nullable();
            $table->string('status_penyiraman')->nullable();
            $table->string('pump_type')->nullable(); // 'manual' or 'automated'
            $table->string('upper_limit')->nullable();
            $table->string('lower_limit')->nullable();
            $table->string('watering_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
