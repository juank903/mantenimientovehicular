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
        Schema::table('circuitodependencias', function (Blueprint $table) {
            $table->foreign(['id_distrito_dependencias'], 'fk_circuito_dependencias_distrito')->references(['id'])->on('distritodependencias')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('circuitodependencias', function (Blueprint $table) {
            $table->dropForeign('fk_circuito_dependencias_distrito');
        });
    }
};
