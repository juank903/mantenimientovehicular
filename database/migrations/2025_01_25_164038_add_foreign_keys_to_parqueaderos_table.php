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
        Schema::table('parqueaderos', function (Blueprint $table) {
            $table->foreign(['vehiculos_id'], 'fk_parqueadero_vehiculo')->references(['id'])->on('vehiculos')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parqueaderos', function (Blueprint $table) {
            $table->dropForeign('fk_parqueadero_vehiculo');
        });
    }
};
