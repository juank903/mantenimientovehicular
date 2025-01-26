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
        Schema::create('personalpolicia_subcircuitodependencia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('personalpolicia_id')->nullable()->index('fk_personalpolicia_idx');
            $table->unsignedBigInteger('subcircuitodependencia_id')->nullable()->index('fk_subcircuito_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personalpolicia_subcircuitodependencia');
    }
};
