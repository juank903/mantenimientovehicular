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
        Schema::create('personalpolicias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->unique('iduser_personal_policias_unique');
            $table->string('primernombre_personal_policias', 80)->nullable();
            $table->string('segundonombre_personal_policias', 80)->nullable();
            $table->string('primerapellido_personal_policias', 80)->nullable();
            $table->string('segundoapellido_personal_policias', 80)->nullable();
            $table->integer('cedula_personal_policias')->nullable();
            $table->enum('tiposangre_personal_policias', ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'])->nullable();
            $table->enum('conductor_personal_policias', ['si', 'no'])->nullable();
            $table->enum('rango_personal_policias', ['Capitán', 'Teniente', 'Subteniente', 'Sargento Primero', 'Sargento Segundo', 'Cabo Primero', 'Cabo Segundo'])->nullable();
            $table->enum('rol_personal_policias', ['administrador', 'auxiliar', 'gerencia', 'policia'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personalpolicias');
    }
};
