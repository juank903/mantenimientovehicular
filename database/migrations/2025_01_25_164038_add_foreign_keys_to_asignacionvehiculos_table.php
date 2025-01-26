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
        Schema::table('asignacionvehiculos', function (Blueprint $table) {
            $table->foreign(['personalpolicias_id'], 'fk_asignado_vehiculos_personal_policias')->references(['id'])->on('personalpolicias')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['vehiculos_id'], 'fk_asignado_vehiculos_vehiculos')->references(['id'])->on('vehiculos')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asignacionvehiculos', function (Blueprint $table) {
            $table->dropForeign('fk_asignado_vehiculos_personal_policias');
            $table->dropForeign('fk_asignado_vehiculos_vehiculos');
        });
    }
};
