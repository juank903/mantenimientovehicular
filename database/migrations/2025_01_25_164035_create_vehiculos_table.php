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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('marca_vehiculos', 45)->nullable();
            $table->string('tipo_vehiculos', 45)->nullable();
            $table->string('modelo_vehiculos', 45)->nullable();
            $table->string('color_vehiculos', 45)->nullable();
            $table->string('placa_vehiculos', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
