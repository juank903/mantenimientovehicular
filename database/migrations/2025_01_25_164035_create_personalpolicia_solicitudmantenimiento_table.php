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
        Schema::create('personalpolicia_solicitudmantenimiento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('solicitudmantenimiento_id')->index('fk_personalpolicia_solicitudmantenimiento_idx');
            $table->unsignedBigInteger('personalpolicia_id')->index('fk_solicitudmantenimiento_personalpolicia_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personalpolicia_solicitudmantenimiento');
    }
};
