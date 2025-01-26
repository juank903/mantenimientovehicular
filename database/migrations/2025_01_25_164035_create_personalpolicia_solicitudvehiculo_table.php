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
        Schema::create('personalpolicia_solicitudvehiculo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('personalpolicia_id')->index('fk_personalpolicia_idx');
            $table->unsignedBigInteger('solicitudvehiculo_id')->index('fk_solicitudvehiculo_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personalpolicia_solicitudvehiculo');
    }
};
