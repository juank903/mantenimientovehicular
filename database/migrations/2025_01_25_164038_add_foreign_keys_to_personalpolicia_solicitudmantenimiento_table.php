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
        Schema::table('personalpolicia_solicitudmantenimiento', function (Blueprint $table) {
            $table->foreign(['solicitudmantenimiento_id'], 'fk_personalpolicia_solicitudmantenimiento')->references(['id'])->on('solicitudmantenimientos')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['personalpolicia_id'], 'fk_solicitudmantenimiento_personalpolicia')->references(['id'])->on('personalpolicias')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personalpolicia_solicitudmantenimiento', function (Blueprint $table) {
            $table->dropForeign('fk_personalpolicia_solicitudmantenimiento');
            $table->dropForeign('fk_solicitudmantenimiento_personalpolicia');
        });
    }
};
