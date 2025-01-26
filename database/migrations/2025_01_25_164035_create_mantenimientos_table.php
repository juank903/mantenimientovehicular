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
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->unsignedBigInteger('id_talleres')->index('fk_mantenimientos_talleres_idx');
            $table->unsignedBigInteger('id_vehiculos')->nullable()->index('fk_mantenimientos_vehiculos_idx');
            $table->enum('tipo_mantenimientos', ['Preventivo', 'Correctivo'])->nullable();
            $table->timestamps();
            $table->string('descripcion_mantenimientos', 5000)->nullable();
            $table->bigInteger('km_mantenimientos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
