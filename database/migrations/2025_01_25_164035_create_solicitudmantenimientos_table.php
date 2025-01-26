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
        Schema::create('solicitudmantenimientos', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->timestamp('created_at')->nullable();
            $table->string('solicitudmantenimientos_detalle', 600)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudmantenimientos');
    }
};
