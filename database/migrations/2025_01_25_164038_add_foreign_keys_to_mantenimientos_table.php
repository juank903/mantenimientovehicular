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
        Schema::table('mantenimientos', function (Blueprint $table) {
            $table->foreign(['id_talleres'], 'fk_mantenimientos_talleres')->references(['id'])->on('talleres')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['id_vehiculos'], 'fk_mantenimientos_vehiculos')->references(['id'])->on('vehiculos')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mantenimientos', function (Blueprint $table) {
            $table->dropForeign('fk_mantenimientos_talleres');
            $table->dropForeign('fk_mantenimientos_vehiculos');
        });
    }
};
