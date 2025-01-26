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
        Schema::table('personalpolicia_subcircuitodependencia', function (Blueprint $table) {
            $table->foreign(['personalpolicia_id'], 'fk_personalpoliciasubcircuito')->references(['id'])->on('personalpolicias')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['subcircuitodependencia_id'], 'fk_subcircuitopersonalpolicia')->references(['id'])->on('subcircuitodependencias')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personalpolicia_subcircuitodependencia', function (Blueprint $table) {
            $table->dropForeign('fk_personalpoliciasubcircuito');
            $table->dropForeign('fk_subcircuitopersonalpolicia');
        });
    }
};
