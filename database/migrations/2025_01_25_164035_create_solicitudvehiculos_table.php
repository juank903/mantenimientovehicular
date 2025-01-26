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
        Schema::create('solicitudvehiculos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('solicitudvehiculos_detalle', 45)->nullable();
            $table->enum('solicitudvehiculos_tipo', ['Moto', 'Auto', 'Camioneta'])->nullable();
            $table->timestamp('solicitudvehiculos_fecharequerimiento')->nullable();
            $table->enum('solicitudvehiculos_prioridad', ['Alta', 'Baja'])->nullable();
            $table->enum('solicitudvehiculos_estado', ['Pendiente', 'Aprobada', 'Anulada'])->default('Pendiente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudvehiculos');
    }
};
