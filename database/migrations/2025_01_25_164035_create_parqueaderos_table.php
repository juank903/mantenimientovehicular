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
        Schema::create('parqueaderos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('parqueaderos_direccion', 45)->nullable();
            $table->unsignedBigInteger('vehiculos_id')->index('fk_parqueadero_vehiculo_idx');
            $table->enum('parqueaderos_estado', ['Libre', 'Ocupado'])->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parqueaderos');
    }
};
