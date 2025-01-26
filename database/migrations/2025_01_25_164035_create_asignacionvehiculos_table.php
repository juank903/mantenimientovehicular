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
        Schema::create('asignacionvehiculos', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('personalpolicias_id')->index('fk_asignado_vehiculos_personal_policias_idx');
            $table->unsignedBigInteger('vehiculos_id')->index('fk_asignado_vehiculos_vehiculos_idx');
            $table->enum('asignacionvehiculos_estado', ['asignado', 'no asignado'])->nullable()->unique('estado_vehiculos_unique');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('asignacionvehiculos_fechaprobacion')->nullable();
            $table->string('asignacionvehiculos_descripcionpedido', 6000)->nullable();
            $table->bigInteger('asignacionvehiculos_kmrecibido')->nullable();
            $table->bigInteger('asignacionvehiculos_kmentregado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacionvehiculos');
    }
};
