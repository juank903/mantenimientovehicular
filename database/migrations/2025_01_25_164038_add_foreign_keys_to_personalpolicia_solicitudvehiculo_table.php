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
        Schema::table('personalpolicia_solicitudvehiculo', function (Blueprint $table) {
            $table->foreign(['personalpolicia_id'], 'fk_personalpolicia')->references(['id'])->on('personalpolicias')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['solicitudvehiculo_id'], 'fk_solicitudvehiculo')->references(['id'])->on('solicitudvehiculos')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personalpolicia_solicitudvehiculo', function (Blueprint $table) {
            $table->dropForeign('fk_personalpolicia');
            $table->dropForeign('fk_solicitudvehiculo');
        });
    }
};
