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
        Schema::create('quejasugerencias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('detalle_quejasugerencias', 500)->nullable();
            $table->enum('tipo_quejasugerencias', ['Reclamo', 'Sugerencia'])->nullable();
            $table->timestamp('created_at')->nullable();
            $table->string('apellidos_quejasugerencias', 100)->nullable();
            $table->string('nombres_quejasugerencias', 100)->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quejasugerencias');
    }
};
