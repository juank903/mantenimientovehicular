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
        Schema::table('quejasugerencia_subcircuitodependencia', function (Blueprint $table) {
            $table->foreign(['quejasugerencia_id'], 'fk_idquejasugerencias')->references(['id'])->on('quejasugerencias')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['subcircuitodependencia_id'], 'fk_idsubcircuitosdependencias')->references(['id'])->on('subcircuitodependencias')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quejasugerencia_subcircuitodependencia', function (Blueprint $table) {
            $table->dropForeign('fk_idquejasugerencias');
            $table->dropForeign('fk_idsubcircuitosdependencias');
        });
    }
};
