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
        Schema::table('parroquiadependencias', function (Blueprint $table) {
            $table->foreign(['id_provincia_dependencias'], 'fk_parroquia_dependencias_provincia')->references(['id'])->on('provinciadependencias')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parroquiadependencias', function (Blueprint $table) {
            $table->dropForeign('fk_parroquia_dependencias_provincia');
        });
    }
};
