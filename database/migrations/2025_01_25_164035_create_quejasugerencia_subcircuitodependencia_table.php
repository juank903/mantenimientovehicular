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
        Schema::create('quejasugerencia_subcircuitodependencia', function (Blueprint $table) {
            $table->bigIncrements('quejasugerencia_subcircuitodependencia_id');
            $table->unsignedBigInteger('quejasugerencia_id')->index('fk_idquejasugerencias');
            $table->unsignedBigInteger('subcircuitodependencia_id')->index('fk_idsubcircuitosdependencias_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quejasugerencia_subcircuitodependencia');
    }
};
